<?php

namespace App\Filament\Resources\Penggajian\Tables;

use App\Models\Penggajian;
use App\Services\SlipGajiService;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PenggajianTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('karyawan.nama')
                    ->label('Karyawan')
                    ->description(fn (Penggajian $record) => $record->karyawan?->properti?->nama)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('periode')
                    ->label('Periode')
                    ->state(fn (Penggajian $record) => Carbon::create($record->tahun, $record->bulan, 1)->translatedFormat('F Y'))
                    ->sortable(query: fn ($query, $direction) => $query
                        ->orderBy('tahun', $direction)
                        ->orderBy('bulan', $direction)),

                TextColumn::make('nominal_gaji')
                    ->label('Nominal')
                    ->money('Rp')
                    ->sortable()
                    ->weight('bold')
                    ->color('success')
                    ->formatStateUsing(fn ($state) => 'Rp '.number_format($state, 0, ',', '.'))
                    ->summarize(Sum::make()
                        ->label('Total')
                        ->formatStateUsing(fn ($state) => 'Rp '.number_format($state, 0, ',', '.'))
                        ->money('Rp')),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => $state === 'Sudah Dibayar' ? 'success' : 'warning'),

                TextColumn::make('tanggal_dibayar')
                    ->label('Tgl Dibayar')
                    ->date('d M Y')
                    ->placeholder('-')
                    ->toggleable(),

                IconColumn::make('dikirim_at')
                    ->label('Slip')
                    ->boolean()
                    ->getStateUsing(fn (Penggajian $record) => $record->dikirim_at !== null)
                    ->tooltip(fn (Penggajian $record) => $record->dikirim_at
                        ? 'Dikirim '.$record->dikirim_at->diffForHumans().' via '.str_replace('_', ' & ', $record->dikirim_via ?? '-')
                        : 'Belum dikirim'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Belum Dibayar' => 'Belum Dibayar',
                        'Sudah Dibayar' => 'Sudah Dibayar',
                    ]),
            ])
            ->modifyQueryUsing(function ($query) {
                $user = Auth::user();

                if (! $user) {
                    return $query->whereRaw('1 = 0');
                }

                if ($user->hasRole('admin')) {
                    return $query; // admin: lihat semua, read-only (sudah di-enforce di Policy)
                }

                if ($user->hasRole('pemilik')) {
                    return $query->whereHas(
                        'karyawan.properti',
                        fn ($q) => $q->where('pemilik_id', $user->id)
                    );
                }

                return $query->whereRaw('1 = 0');
            })
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('tandaiDibayar')
                    ->label('Tandai Dibayar')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn (Penggajian $record) => $record->status === 'Belum Dibayar' && (Auth::user()?->hasRole('pemilik') ?? false)
                    )
                    ->requiresConfirmation()
                    ->action(fn (Penggajian $record) => $record->update([
                        'status' => 'Sudah Dibayar',
                        'tanggal_dibayar' => now(),
                    ])),

                Action::make('kirimSlipGaji')
                    ->label('Kirim Slip (WA)')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->visible(fn (Penggajian $record) => $record->status === 'Sudah Dibayar' && (Auth::user()?->hasAnyRole(['pemilik', 'admin']) ?? false)
                    )
                    ->action(function (Penggajian $record, $livewire) {
                        $whatsappUrl = SlipGajiService::buatLinkWa($record);

                        if ($whatsappUrl) {
                            Notification::make()
                                ->title('Slip gaji siap dikirim, lanjutkan di WhatsApp')
                                ->body('WhatsApp dibuka di tab baru. Halaman ini tetap terbuka.')
                                ->success()
                                ->send();

                            // Buka WhatsApp di tab baru agar halaman penggajian tetap terbuka
                            $escapedUrl = addslashes($whatsappUrl);
                            $livewire->js("window.open('{$escapedUrl}', '_blank')");

                            return;
                        }

                        Notification::make()
                            ->title('Nomor WhatsApp karyawan belum tersedia')
                            ->danger()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),

                    BulkAction::make('generatePdfMassal')
                        ->label('Generate PDF Slip Gaji')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('info')
                        ->visible(fn () => Auth::user()?->hasAnyRole(['pemilik', 'admin']) ?? false)
                        ->requiresConfirmation()
                        ->modalHeading('Generate PDF Slip Gaji Massal')
                        ->modalDescription('Proses ini akan membuat file PDF slip gaji untuk data yang dipilih (slip gaji akan tersimpan di sistem agar bisa di-download).')
                        ->action(function (Collection $records) {
                            $diproses = 0;

                            foreach ($records as $record) {
                                if ($record->status !== 'Sudah Dibayar') {
                                    continue;
                                }

                                SlipGajiService::buatDanSimpanPdf($record);
                                $diproses++;
                            }

                            Notification::make()->title("{$diproses} PDF slip gaji berhasil dibuat")->success()->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('tahun', 'desc');
    }
}
