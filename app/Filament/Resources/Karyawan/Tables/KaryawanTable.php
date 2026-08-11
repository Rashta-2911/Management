<?php

namespace App\Filament\Resources\Karyawan\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class KaryawanTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('properti.nama_properti')
                    ->label('Manager')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->visible(fn () => Auth::user()?->hasRole('pemilik')),

                TextColumn::make('jabatan')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('no_telepon')
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('gaji_pokok')
                    ->money('Rp')
                    ->formatStateUsing(fn ($state) => 'Rp '.number_format($state, 0, ',', '.'))
                    ->color('success')
                    ->weight('bold')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('status')->badge()
                    ->color(fn (string $state) => $state === 'Aktif' ? 'success' : 'gray')
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('properti_id')
                    ->label('Manager')
                    ->relationship('properti', 'nama_properti')
                    ->searchable()
                    ->preload()
                    ->visible(fn () => Auth::user()?->hasRole('pemilik')),
                TrashedFilter::make(),
            ])
            ->modifyQueryUsing(function ($query) {
                $user = Auth::user();

                if (! $user) {
                    return $query->whereRaw('1 = 0');
                }

                if ($user->hasRole('admin')) {
                    return $query;
                }

                if ($user->hasRole('pemilik')) {
                    return $query->whereHas(
                        'properti',
                        fn ($q) => $q->where('pemilik_id', $user->id)
                    );
                }

                return $query->whereRaw('1 = 0');
            })
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                ForceDeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('nama');
    }
}
