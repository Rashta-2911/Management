<?php

namespace App\Filament\Resources\Kamar\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class KamarInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kamar')
                    ->description('Detail dasar dan status kamar')
                    ->icon('heroicon-o-home-modern')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('nomor_kamar')
                            ->label('No. Kamar')
                            ->icon('heroicon-o-key')
                            ->weight(FontWeight::Bold)
                            ->size('md'),

                        TextEntry::make('status')
                            ->label('Status Kamar')
                            ->icon('heroicon-o-check-circle')
                            ->badge()
                            ->size('md')
                            ->color(fn (string $state): string => match ($state) {
                                'Tersedia' => 'success',
                                'Terisi' => 'danger',
                                default => 'gray',
                            }),

                        TextEntry::make('tipeKamar.nama_tipe')
                            ->label('Tipe Kamar')
                            ->icon('heroicon-o-building-office-2')
                            ->badge()
                            ->color('warning')
                            ->placeholder('-'),

                        TextEntry::make('tipeKamar.harga')
                            ->label('Harga/bulan')
                            ->icon('heroicon-o-banknotes')
                            ->money('Rp')
                            ->formatStateUsing(fn ($state) => 'Rp '.number_format($state, 0, ',', '.'))
                            ->weight(FontWeight::Bold)
                            ->color('success')
                            ->size('md')
                            ->placeholder('-'),
                    ]),

                Section::make('Riwayat Pencatatan')
                    ->description('Waktu data ini dibuat dan terakhir diperbarui')
                    ->icon('heroicon-o-clock')
                    ->columns(1)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Dibuat pada')
                            ->icon('heroicon-o-calendar')
                            ->dateTime('d M Y, H:i')
                            ->color('gray'),

                        TextEntry::make('updated_at')
                            ->label('Diperbarui pada')
                            ->icon('heroicon-o-arrow-path')
                            ->dateTime('d M Y, H:i')
                            ->color('gray'),
                    ]),
            ]);
    }
}
