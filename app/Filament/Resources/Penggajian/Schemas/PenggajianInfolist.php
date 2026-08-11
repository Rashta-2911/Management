<?php

namespace App\Filament\Resources\Penggajian\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;

class PenggajianInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Penggajian')
                    ->description('Detail data gaji karyawan')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('id')
                                    ->label('ID Penggajian')
                                    ->icon('heroicon-o-identification')
                                    ->weight(FontWeight::Bold)
                                    ->copyable(),

                                TextEntry::make('karyawan.nama')
                                    ->label('Nama Karyawan')
                                    ->icon('heroicon-o-user')
                                    ->weight(FontWeight::Bold),

                                TextEntry::make('bulan')
                                    ->label('Periode Bulan')
                                    ->icon('heroicon-o-calendar')
                                    ->formatStateUsing(fn (int $state): string => [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                                        4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                                        10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                                    ][$state] ?? '-'),

                                TextEntry::make('tahun')
                                    ->label('Tahun')
                                    ->icon('heroicon-o-calendar-days'),
                            ]),
                    ]),

                Section::make('Nominal & Status')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('nominal_gaji')
                                    ->label('Nominal Gaji')
                                    ->icon('heroicon-o-banknotes')
                                    ->money('Rp')
                                    ->formatStateUsing(fn ($state) => 'Rp '.number_format($state, 0, ',', '.'))
                                    ->weight(FontWeight::Bold)
                                    ->size(TextSize::Large)
                                    ->color('success'),

                                TextEntry::make('status')
                                    ->label('Status')
                                    ->icon('heroicon-o-check-circle')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Sudah Dibayar' => 'success',
                                        'Belum Dibayar' => 'danger',
                                        default => 'gray',
                                    }),

                                TextEntry::make('tanggal_dibayar')
                                    ->label('Tanggal Dibayar')
                                    ->icon('heroicon-o-calendar-days')
                                    ->date('d F Y')
                                    ->placeholder('Belum dibayar'),
                            ]),
                    ]),

                Section::make('Informasi Tambahan')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Dibuat pada')
                                    ->icon('heroicon-o-clock')
                                    ->dateTime('d F Y, H:i'),

                                TextEntry::make('updated_at')
                                    ->label('Diperbarui pada')
                                    ->icon('heroicon-o-clock')
                                    ->dateTime('d F Y, H:i'),
                            ]),
                    ]),
            ]);
    }
}
