<?php

namespace App\Filament\Resources\TipeKamar\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class TipeKamarInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Tipe Kamar')
                    ->description('Nama, harga, dan kode tipe kamar')
                    ->icon('heroicon-o-building-office-2')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('nama_tipe')
                            ->label('Nama Tipe Kamar')
                            ->icon('heroicon-o-building-office-2')
                            ->weight(FontWeight::Bold)
                            ->size('md')
                            ->placeholder('-'),

                        TextEntry::make('harga')
                            ->label('Harga/bulan')
                            ->icon('heroicon-o-banknotes')
                            ->money('Rp')
                            ->formatStateUsing(fn ($state) => 'Rp '.number_format($state, 0, ',', '.'))
                            ->weight(FontWeight::Bold)
                            ->size('md')
                            ->color('success')
                            ->placeholder('-'),

                        TextEntry::make('id')
                            ->label('ID Tipe Kamar')
                            ->icon('heroicon-o-identification')
                            ->color('gray')
                            ->copyable()
                            ->placeholder('-'),
                    ]),

                Section::make('Fasilitas')
                    ->description('Daftar fasilitas yang tersedia untuk tipe kamar ini')
                    ->icon('heroicon-o-sparkles')
                    ->schema([
                        TextEntry::make('fasilitas')
                            ->label('Fasilitas')
                            ->icon('heroicon-o-sparkles')
                            ->prose()
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('Riwayat Pencatatan')
                    ->description('Waktu data ini dibuat dan terakhir diperbarui')
                    ->icon('heroicon-o-clock')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Dibuat pada')
                            ->icon('heroicon-o-calendar')
                            ->dateTime('d M Y, H:i')
                            ->color('gray'),

                        TextEntry::make('updated_at')
                            ->label('Terakhir diperbarui')
                            ->icon('heroicon-o-arrow-path')
                            ->dateTime('d M Y, H:i')
                            ->color('gray'),
                    ]),
            ]);
    }
}
