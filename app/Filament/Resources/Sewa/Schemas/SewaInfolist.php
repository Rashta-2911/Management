<?php

namespace App\Filament\Resources\Sewa\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Support\Enums\FontWeight;

class SewaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Sewa')
                    ->description('Kamar dan penghuni yang terlibat dalam sewa ini')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('kamar.nomor_kamar')
                            ->label('No. Kamar')
                            ->icon('heroicon-o-home-modern')
                            ->weight(FontWeight::Bold)
                            ->size('lg')
                            ->placeholder('-'),

                        TextEntry::make('penghuni.nama_penghuni')
                            ->label('Nama Penghuni')
                            ->icon('heroicon-o-user')
                            ->weight(FontWeight::Bold)
                            ->size('lg')
                            ->placeholder('-'),

                        TextEntry::make('kamar.tipeKamar.nama_tipe')
                            ->label('Tipe Kamar')
                            ->icon('heroicon-o-building-office-2')
                            ->badge()
                            ->color('warning')
                            ->placeholder('-'),

                        TextEntry::make('id')
                            ->label('ID Sewa')
                            ->icon('heroicon-o-identification')
                            ->color('gray')
                            ->copyable()
                            ->placeholder('-'),
                    ]),

                Section::make('Periode & Status')
                    ->description('Durasi sewa dan status keberlangsungannya')
                    ->icon('heroicon-o-calendar-days')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('tanggal_mulai')
                            ->label('Tanggal Mulai Sewa')
                            ->icon('heroicon-o-calendar')
                            ->date()
                            ->placeholder('-'),

                        TextEntry::make('tanggal_selesai')
                            ->label('Tanggal Berakhir Sewa')
                            ->icon('heroicon-o-calendar')
                            ->date()
                            ->placeholder('-'),

                        TextEntry::make('status')
                            ->label('Status Sewa')
                            ->icon('heroicon-o-check-circle')
                            ->badge()
                            ->color(fn (?string $state): string => match ($state) {
                                'Aktif' => 'success',
                                'Selesai' => 'gray',
                                'Berakhir' => 'danger',
                                default => 'gray',
                            })
                            ->placeholder('-'),
                    ]),

                Section::make('Riwayat Pencatatan')
                    ->description('Waktu data ini dibuat dan terakhir diperbarui')
                    ->icon('heroicon-o-clock')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed()
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