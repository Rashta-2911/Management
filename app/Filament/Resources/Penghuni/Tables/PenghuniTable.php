<?php

namespace App\Filament\Resources\Penghuni\Tables;

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

class PenghuniTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('nama_penghuni')
                    ->label('Nama Penghuni')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-o-user'),
                TextColumn::make('kamar.nomor_kamar')
                    ->label('Kamar')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-o-home'),
                TextColumn::make('no_hp')
                    ->label('No WhatsApp')
                    ->searchable()
                    ->icon('heroicon-o-device-phone-mobile'),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->icon('heroicon-o-envelope')
                    ->iconColor('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->label('Pekerjaan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pekerja' => 'info',
                        'Mahasiswa' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('alamat_asal')
                    ->label('Alamat Asal')
                    ->limit(30)
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
