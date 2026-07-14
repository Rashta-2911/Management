<?php

namespace App\Filament\Resources\Kamar\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class KamarTable
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
                
                TextColumn::make('nomor_kamar')
                    ->label('No. Kamar')
                    ->sortable(query: function ($query, $direction) {
                        return $query->orderByRaw("CAST(nomor_kamar AS UNSIGNED) $direction");
                    })
                    ->searchable()
                    ->weight('bold')
                    ->icon('heroicon-o-home'),

                TextColumn::make('tipeKamar.nama_tipe')
                    ->label('Tipe Kamar')
                    ->badge()
                    ->color('warning')
                    ->searchable(),

                TextColumn::make('tipeKamar.tipe_sewa')
                    ->label('Tipe Sewa')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('tipeKamar.harga')
                    ->label('Harga')
                    ->money('Rp')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->color('success')
                    ->weight('bold'),
                
                TextColumn::make('tipeKamar.luas_kamar')
                    ->label('Luas')
                    ->suffix(' m²')
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        'Tersedia' => 'success',
                        'Terisi'   => 'danger',
                        default    => 'gray',
                    })
                    ->searchable(),

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
            ->defaultSort(fn ($query) =>
                $query->orderByRaw("CAST(SUBSTRING(id, 2) AS UNSIGNED) ASC")
            )
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
                    RestoreBulkAction::make()
                ]),
            ]);
    }
}
