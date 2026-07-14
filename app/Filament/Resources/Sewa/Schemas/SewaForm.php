<?php

namespace App\Filament\Resources\Sewa\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class SewaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Sewa')
                    ->description('Detail penghuni dan kamar yang disewa')
                    ->icon('heroicon-o-home-modern')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('kamar_id')
                                    ->label('No. Kamar')
                                    ->relationship('kamar', 'nomor_kamar')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->prefixIcon('heroicon-o-home'),

                                Select::make('penghuni_id')
                                    ->label('Nama Penghuni')
                                    ->relationship('penghuni', 'nama_penghuni')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->prefixIcon('heroicon-o-user'),
                            ]),
                    ]),

                Section::make('Periode & Harga')
                    ->description('Durasi sewa dan kesepakatan harga')
                    ->icon('heroicon-o-calendar-days')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                DatePicker::make('tanggal_mulai')
                                    ->label('Tanggal Mulai')
                                    ->required()
                                    ->prefixIcon('heroicon-o-calendar'),

                                DatePicker::make('tanggal_selesai')
                                    ->label('Tanggal Selesai')
                                    ->required()
                                    ->prefixIcon('heroicon-o-calendar'),

                                TextInput::make('harga_disepakati')
                                    ->label('Harga Disepakati')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->minValue(0)
                                    ->step(1000)
                                    ->placeholder('0')
                                    ->required(),
                            ]),
                    ]),

                Section::make('Status & Catatan')
                    ->description('Status terkini dan catatan tambahan')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                Select::make('status')
                                    ->label('Status Sewa')
                                    ->options([
                                        'Aktif' => 'Aktif',
                                        'Selesai' => 'Selesai',
                                        'Dibatalkan' => 'Dibatalkan',
                                    ])
                                    ->native(false)
                                    ->hiddenOn('create')
                                    ->required()
                                    ->prefixIcon('heroicon-o-flag'),

                                Textarea::make('catatan')
                                    ->label('Catatan')
                                    ->required()
                                    ->rows(3),
                            ]),
                    ]),
            ]);
    }
}
