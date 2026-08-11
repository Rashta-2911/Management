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
use Filament\Forms\Components\Radio;
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
                    ->label('Kirim Slip')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->visible(fn (Penggajian $record) => $record->status === 'Sudah Dibayar' && (Auth::user()?->hasAnyRole(['pemilik', 'admin']) ?? false)
                    )
                    ->modalHeading('Kirim Slip Gaji')
                    ->modalDescription('Pilih metode pengiriman detail gaji untuk karyawan ini.')
                    ->form([
                        Radio::make('metode')
                            ->options([
                                'email' => 'Kirim via Email',
                                'whatsapp' => 'Kirim via WhatsApp',
                            ])
                            ->required(),
                    ])
                    ->action(function (Penggajian $record, array $data) {
                        if ($data['metode'] === 'email') {
                            $sent = SlipGajiService::kirimSlipEmail($record);

                            Notification::make()
                                ->title($sent ? 'Slip gaji berhasil dikirim via email' : 'Alamat email karyawan belum tersedia')
                                ->success($sent)
                                ->danger(! $sent)
                                ->send();

                            return;
                        }

                        $whatsappUrl = SlipGajiService::buatLinkWa($record, $data['metode']);

                        if ($whatsappUrl) {
                            Notification::make()
                                ->title('Slip gaji siap dikirim, lanjutkan di WhatsApp')
                                ->success()
                                ->send();

                            return redirect()->away($whatsappUrl);
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

                    BulkAction::make('kirimSlipMassal')
                        ->label('Kirim Slip Terpilih')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('info')
                        ->visible(fn () => Auth::user()?->hasAnyRole(['pemilik', 'admin']) ?? false)
                        ->requiresConfirmation()
                        ->modalHeading('Kirim Slip Gaji Massal')
                        ->modalDescription('WhatsApp tidak bisa dikirim massal otomatis (keterbatasan platform) — pilih Email untuk pengiriman langsung, atau gunakan WhatsApp untuk generate PDF saja lalu kirim satu-satu.')
                        ->form([
                            Radio::make('metode')
                                ->options([
                                    'email' => 'Kirim via Email (otomatis)',
                                    'whatsapp' => 'Generate PDF saja (kirim manual satu-satu)',
                                ])
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data) {
                            $diproses = 0;

                            foreach ($records as $record) {
                                if ($record->status !== 'Sudah Dibayar') {
                                    continue;
                                }

                                if ($data['metode'] === 'email') {
                                    if (SlipGajiService::kirimSlipEmail($record)) {
                                        $diproses++;
                                    }
                                } else {
                                    SlipGajiService::buatDanSimpanPdf($record);
                                    $diproses++;
                                }
                            }

                            $pesan = $data['metode'] === 'email'
                                ? "{$diproses} slip gaji berhasil dikirim via Email"
                                : "{$diproses} PDF slip gaji berhasil dibuat, silakan kirim via WhatsApp satu per satu";

                            Notification::make()->title($pesan)->success()->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('tahun', 'desc');
    }
}
