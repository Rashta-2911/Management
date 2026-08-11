<?php

namespace App\Filament\Resources\Karyawan\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class KaryawanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Karyawan')
                    ->description('Nama, jabatan, dan ID Karyawan')
                    ->icon('heroicon-o-user')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('nama')
                            ->label('Nama Karyawan')
                            ->icon('heroicon-o-user')
                            ->weight(FontWeight::Bold)
                            ->size('md')
                            ->placeholder('-'),

                        TextEntry::make('jabatan')
                            ->label('Jabatan')
                            ->icon('heroicon-o-briefcase')
                            ->weight(FontWeight::Bold)
                            ->size('md')
                            ->placeholder('-'),

                        TextEntry::make('id')
                            ->label('ID')
                            ->icon('heroicon-o-identification')
                            ->weight(FontWeight::Bold)
                            ->size('md')
                            ->placeholder('-'),

                        TextEntry::make('properti.nama_properti')
                            ->label('Di Properti')
                            ->icon('heroicon-o-home-modern')
                            ->weight(FontWeight::Bold)
                            ->size('md')
                            ->placeholder('-'),
                    ]),

                Section::make('Kontak')
                    ->description('No. HP & Email')
                    ->icon('heroicon-o-phone')
                    ->columns(1)
                    ->schema([
                        TextEntry::make('no_telepon')
                            ->label('No. HP')
                            ->icon('heroicon-o-phone')
                            ->weight(FontWeight::Bold)
                            ->size('md')
                            ->placeholder('-'),

                        TextEntry::make('email')
                            ->label('Email')
                            ->icon('heroicon-o-envelope')
                            ->weight(FontWeight::Bold)
                            ->size('md')
                            ->placeholder('-'),
                    ]),

                Section::make('Penggajian')
                    ->description('Pendapatan Karyawan')
                    ->icon('heroicon-o-banknotes')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('gaji_pokok')
                            ->label('Nominal Gaji')
                            ->icon('heroicon-o-banknotes')
                            ->money('Rp')
                            ->formatStateUsing(fn ($state) => 'Rp '.number_format($state, 0, ',', '.'))
                            ->color('success')
                            ->weight(FontWeight::Bold)
                            ->size('md')
                            ->placeholder('-'),
                    ]),

                Section::make('Tanggal Masuk')
                    ->description('Tanggal Masuk Kerja')
                    ->icon('heroicon-o-calendar')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('tanggal_masuk')
                            ->label('Tanggal Masuk')
                            ->icon('heroicon-o-calendar')
                            ->weight(FontWeight::Bold)
                            ->size('md')
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
