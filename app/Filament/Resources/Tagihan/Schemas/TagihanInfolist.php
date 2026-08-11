<?php

namespace App\Filament\Resources\Tagihan\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class TagihanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ringkasan Tagihan')
                    ->description('Status dan nominal tagihan')
                    ->icon('heroicon-o-document-text')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('jumlah')
                            ->label('Total Tagihan')
                            ->icon('heroicon-o-banknotes')
                            ->money('IDR')
                            ->weight(FontWeight::Bold)
                            ->size('lg')
                            ->color('success')
                            ->placeholder('-'),

                        TextEntry::make('status')
                            ->label('Status Tagihan')
                            ->icon('heroicon-o-document-check')
                            ->badge()
                            ->size('lg')
                            ->color(fn (?string $state): string => match ($state) {
                                'Lunas' => 'success',
                                'Terlambat' => 'danger',
                                'Belum Lunas' => 'warning',
                                default => 'gray',
                            })
                            ->placeholder('-'),

                        TextEntry::make('id')
                            ->label('ID Tagihan')
                            ->icon('heroicon-o-identification')
                            ->color('gray')
                            ->copyable()
                            ->placeholder('-'),
                    ]),

                Section::make('Detail Sewa Terkait')
                    ->description('Kamar, penghuni, dan periode sewa dari tagihan ini')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('sewa.kamar.nomor_kamar')
                            ->label('No. Kamar')
                            ->icon('heroicon-o-home-modern')
                            ->weight(FontWeight::Bold)
                            ->placeholder('-'),

                        TextEntry::make('sewa.penghuni.nama_penghuni')
                            ->label('Nama Penghuni')
                            ->icon('heroicon-o-user')
                            ->weight(FontWeight::Bold)
                            ->placeholder('-'),

                        TextEntry::make('sewa.kamar.tipeKamar.nama_tipe')
                            ->label('Tipe Kamar')
                            ->icon('heroicon-o-building-office-2')
                            ->badge()
                            ->color('gray')
                            ->placeholder('-'),

                        TextEntry::make('sewa.id')
                            ->label('ID Sewa')
                            ->icon('heroicon-o-identification')
                            ->color('gray')
                            ->copyable()
                            ->placeholder('-'),

                        TextEntry::make('sewa.tanggal_mulai')
                            ->label('Tanggal Mulai Sewa')
                            ->icon('heroicon-o-calendar')
                            ->date()
                            ->placeholder('-'),

                        TextEntry::make('sewa.tanggal_selesai')
                            ->label('Tanggal Selesai Sewa')
                            ->icon('heroicon-o-calendar')
                            ->date()
                            ->placeholder('-'),
                    ]),

                Section::make('Riwayat Pencatatan')
                    ->description('Waktu data ini dibuat dan terakhir diperbarui')
                    ->icon('heroicon-o-clock')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Dibuat Pada')
                            ->icon('heroicon-o-calendar')
                            ->dateTime('d M Y, H:i')
                            ->color('gray'),

                        TextEntry::make('updated_at')
                            ->label('Diperbarui Pada')
                            ->icon('heroicon-o-arrow-path')
                            ->dateTime('d M Y, H:i')
                            ->color('gray'),
                    ]),
            ]);
    }
}
