<?php

namespace App\Filament\Resources\Penghuni\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Support\Enums\FontWeight;

class PenghuniInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Penghuni')
                    ->description('Nama, status, dan kode penghuni')
                    ->icon('heroicon-o-user')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('nama_penghuni')
                            ->label('Nama Penghuni')
                            ->icon('heroicon-o-user')
                            ->weight(FontWeight::Bold)
                            ->size('lg')
                            ->placeholder('-'),

                        TextEntry::make('status')
                            ->label('Status')
                            ->icon('heroicon-o-user-group')
                            ->badge()
                            ->color(fn (?string $state): string => match ($state) {
                                'Aktif' => 'success',
                                'Tidak Aktif' => 'danger',
                                default => 'gray',
                            })
                            ->placeholder('-'),

                        TextEntry::make('id')
                            ->label('ID Penghuni')
                            ->icon('heroicon-o-identification')
                            ->color('gray')
                            ->copyable()
                            ->placeholder('-'),
                    ]),

                Section::make('Kontak & Domisili')
                    ->description('Informasi kontak dan alamat asal penghuni')
                    ->icon('heroicon-o-phone')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('no_hp')
                            ->label('No HP')
                            ->icon('heroicon-o-phone')
                            ->copyable()
                            ->placeholder('-'),

                        TextEntry::make('email')
                            ->label('Email')
                            ->icon('heroicon-o-envelope')
                            ->copyable()
                            ->placeholder('-'),

                        TextEntry::make('alamat_asal')
                            ->label('Alamat Asal')
                            ->icon('heroicon-o-home')
                            ->prose()
                            ->placeholder('-')
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