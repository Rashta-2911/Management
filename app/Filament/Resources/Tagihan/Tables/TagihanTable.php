<?php

namespace App\Filament\Resources\Tagihan\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use App\Models\Tagihan;
use Filament\Actions\Action;
use App\Services\WhatsappReminderService;

class TagihanTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('sewa.penghuni.nama_penghuni')
                    ->label('Penghuni')
                    ->weight('bold')
                    ->icon('heroicon-o-user')
                    ->searchable(),

                TextColumn::make('sewa.kamar.nomor_kamar')
                    ->label('Kamar')
                    ->badge()
                    ->color('gray')
                    ->icon('heroicon-o-home')
                    ->sortable(),
                
                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->money('Rp')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->color('primary')
                    ->weight('bold')
                    ->sortable(),

                TextColumn::make('tanggal_tagihan')
                    ->label('Tgl Tagihan')
                    ->date('d M Y')
                    ->icon('heroicon-o-calendar')
                    ->sortable(),

                TextColumn::make('tanggal_jatuh_tempo')
                    ->label('Jatuh Tempo')
                    ->date('d M Y')
                    ->icon('heroicon-o-clock')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'Lunas'       => 'warning', // Gold theme color
                        'Belum Lunas' => 'info',    // Navy theme color
                        'Belum lunas' => 'info',
                        'Terlambat'   => 'danger',  // Brick theme color
                        default       => 'gray',
                    }),
            ])
            ->defaultSort('tanggal_jatuh_tempo', 'asc')
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton()
                    ->tooltip('Lihat Detail'),
                EditAction::make()
                    ->iconButton()
                    ->tooltip('Edit Tagihan'),
                Action::make('kirim_reminder')
                    ->iconButton()
                    ->tooltip('Kirim Reminder WA')
                    ->icon('heroicon-o-paper-airplane') // Icon untuk mengirim pesan
                    ->color('success')
                    ->visible(fn (Tagihan $record) =>
                        in_array($record->status, ['Belum Lunas', 'Belum lunas', 'Terlambat'])
                        && $record->sewa->penghuni?->hasValidNoHp()
                        && \Carbon\Carbon::parse($record->tanggal_jatuh_tempo)->subDays(7)->startOfDay()->isPast()
                    )
                    ->url(fn (Tagihan $record) => WhatsappReminderService::buatLinkReminder($record))
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
