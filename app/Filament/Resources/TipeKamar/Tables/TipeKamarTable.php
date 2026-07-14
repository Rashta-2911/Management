<?php

namespace App\Filament\Resources\TipeKamar\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;

class TipeKamarTable
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
                    
                TextColumn::make('properti.nama_properti')
                    ->label('Properti')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-o-building-office-2'),

                TextColumn::make('nama_tipe')
                    ->label('Tipe Kamar')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->icon('heroicon-o-tag'),
                    
                TextColumn::make('tipe_sewa')
                    ->label('Tipe Sewa')
                    ->badge()
                    ->color('info'),

                TextColumn::make('harga')
                    ->label('Harga')
                    ->money('Rp')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->color('success'),

                TextColumn::make('kamar_count')
                    ->label('Jml Kamar')
                    ->counts('kamar')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('kapasitas')
                    ->label('Kapasitas')
                    ->suffix(' org')
                    ->sortable()
                    ->icon('heroicon-o-users')
                    ->iconColor('gray'),

                TextColumn::make('luas_kamar')
                    ->label('Luas')
                    ->suffix(' m²')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('fasilitas')
                    ->label('Fasilitas')
                    ->limit(30)
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make()
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
                ]),
            ]);
    }
}
