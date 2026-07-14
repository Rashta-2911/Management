<?php

namespace App\Filament\Resources\Properti\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;

class PropertiTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('nama_properti')
                    ->label('Nama Properti')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->icon('heroicon-o-building-office-2'),
                TextColumn::make('jenis_properti')
                    ->label('Jenis Properti')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('primary'),
                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->limit(40)
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-o-map-pin')
                    ->iconColor('gray'),
                TextColumn::make('kontak_pemilik')
                    ->label('Kontak Pemilik')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-o-phone'),
                TextColumn::make('fasilitas_umum')
                    ->label('Fasilitas Umum')
                    ->limit(30)
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('peraturan')
                    ->label('Peraturan')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->peraturan)
                    ->sortable()
                    ->searchable()
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
                ]),
            ]);
    }
}
