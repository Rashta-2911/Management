<?php

namespace App\Filament\Resources\Properti\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Support\Enums\FontWeight;

class PropertiInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Properti')
                    ->description('Nama dan jenis properti')
                    ->icon('heroicon-o-building-office-2')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('nama_properti')
                            ->label('Nama Properti')
                            ->icon('heroicon-o-building-office-2')
                            ->weight(FontWeight::Bold)
                            ->size('lg')
                            ->columnSpan(1),

                        TextEntry::make('jenis_properti')
                            ->label('Jenis Properti')
                            ->icon('heroicon-o-tag')
                            ->badge()
                            ->color('warning')
                            ->placeholder('-')
                            ->columnSpan(1),
                    ]),

                Section::make('Lokasi')
                    ->description('Alamat lengkap properti')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        TextEntry::make('alamat')
                            ->label('Alamat Properti')
                            ->icon('heroicon-o-map-pin')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('Peraturan & Fasilitas')
                    ->description('Ketentuan dan fasilitas yang tersedia di properti')
                    ->icon('heroicon-o-document-text')
                    ->columns(1)
                    ->schema([
                        TextEntry::make('peraturan')
                            ->label('Peraturan Properti')
                            ->icon('heroicon-o-clipboard-document-list')
                            ->placeholder('-')
                            ->prose()
                            ->columnSpanFull(),

                        TextEntry::make('fasilitas_umum')
                            ->label('Fasilitas Umum')
                            ->icon('heroicon-o-sparkles')
                            ->placeholder('-')
                            ->prose()
                            ->columnSpanFull(),
                    ]),

                Section::make('Riwayat Pencatatan')
                    ->description('Waktu data ini dibuat dan terakhir diperbarui')
                    ->icon('heroicon-o-clock')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Dibuat Pada')
                            ->icon('heroicon-o-calendar')
                            ->date()
                            ->color('gray'),

                        TextEntry::make('updated_at')
                            ->label('Terakhir Diperbarui')
                            ->icon('heroicon-o-arrow-path')
                            ->dateTime()
                            ->color('gray'),
                    ]),
            ]);
    }
}