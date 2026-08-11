<?php

namespace App\Filament\Resources\Sewa\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class SewaTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(query: function ($query, $direction) {
                        return $query->orderByRaw("CAST(SUBSTRING(id, 2) AS UNSIGNED) $direction");
                    })
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('kamar.nomor_kamar')
                    ->label('No. Kamar')
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-o-home')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('penghuni.nama_penghuni')
                    ->label('Nama Penghuni')
                    ->weight('bold')
                    ->icon('heroicon-o-user')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('kamar.tipeKamar.nama_tipe')
                    ->label('Tipe Kamar')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('harga_disepakati')
                    ->label('Harga')
                    ->money('Rp')
                    ->formatStateUsing(fn ($state) => 'Rp '.number_format($state, 0, ',', '.'))
                    ->color('success')
                    ->weight('bold')
                    ->sortable(),

                TextColumn::make('tanggal_mulai')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->icon('heroicon-o-calendar')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aktif' => 'success',
                        'Selesai' => 'gray',
                        'Dibatalkan' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton()
                    ->tooltip('Lihat Detail'),
                EditAction::make()
                    ->iconButton()
                    ->tooltip('Edit Data'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ])->visible(fn () => ! Auth::user()?->hasRole('pemilik')),
            ]);
    }
}
