<?php

namespace App\Filament\Resources\Pembayaran\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Storage;

class PembayaranTable
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
                
                TextColumn::make('sewa.penghuni.nama_penghuni')
                    ->label('Penghuni')
                    ->weight('bold')
                    ->icon('heroicon-o-user')
                    ->searchable(),
                
                TextColumn::make('tanggal_pembayaran')
                    ->label('Tanggal Pembayaran')
                    ->date('d M Y')
                    ->icon('heroicon-o-calendar')
                    ->searchable(),

                TextColumn::make('metode_pembayaran')
                    ->label('Metode')
                    ->badge()
                    ->color(fn(string $state) => match($state) {
                        'Transfer' => 'info', // Navy
                        'Cash'     => 'success',
                        default    => 'gray',
                    })
                    ->searchable(),

                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->money('Rp')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->color('success')
                    ->weight('bold')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state) => match($state) {
                        'Lunas' => 'warning', // Gold
                        'Belum Lunas' => 'danger',
                        default => 'gray',
                    }),
                
                ImageColumn::make('bukti_pembayaran')
                    ->label('Bukti')
                    ->disk('public')
                    ->circular()
                    ->action(
                        Action::make('lihatBukti')
                            ->modalHeading('Bukti Pembayaran')
                            ->modalContent(fn ($record) => new HtmlString(
                                '<img src="' . Storage::url($record->bukti_pembayaran) . '" style="width:100%; border-radius:0.5rem;">'
                            ))
                            ->modalSubmitAction(false)
                            ->modalCancelAction(false)
                    ),
            ])
            ->defaultSort('tanggal_pembayaran', 'desc')
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
                ]),
            ]);
    }
}
