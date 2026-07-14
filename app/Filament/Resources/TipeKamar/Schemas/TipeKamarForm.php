<?php

namespace App\Filament\Resources\TipeKamar\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use App\Models\Properti;

class TipeKamarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Tipe Kamar')
                    ->description('Informasi properti dan tipe kamar')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('properti_id')
                                    ->label('Properti')
                                    ->options(Properti::all()->pluck('nama_properti', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->prefixIcon('heroicon-o-building-office-2'),

                                TextInput::make('nama_tipe')
                                    ->label('Tipe Kamar')
                                    ->required()
                                    ->prefixIcon('heroicon-o-tag'),

                                TextInput::make('kapasitas')
                                    ->label('Kapasitas')
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(255)
                                    ->suffix('orang')
                                    ->required()
                                    ->prefixIcon('heroicon-o-users'),
                                    
                                TextInput::make('luas_kamar')
                                    ->label('Luas Kamar (m²)')
                                    ->numeric()
                                    ->suffix('m²')
                                    ->required()
                                    ->prefixIcon('heroicon-o-arrows-pointing-out'),
                            ]),
                    ]),

                Section::make('Harga & Fasilitas')
                    ->description('Pengaturan harga sewa dan fasilitas yang tersedia')
                    ->icon('heroicon-o-currency-dollar')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('tipe_sewa')
                                    ->label('Tipe Sewa')
                                    ->options([
                                        'Harian' => 'Harian',
                                        'Mingguan' => 'Mingguan',
                                        'Bulanan' => 'Bulanan',
                                    ])
                                    ->required()
                                    ->prefixIcon('heroicon-o-calendar-days'),
                                    
                                TextInput::make('harga')
                                    ->label('Harga')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),
                            ]),

                        TextInput::make('fasilitas')
                            ->label('Fasilitas')
                            ->required()
                            ->columnSpanFull()
                            ->prefixIcon('heroicon-o-sparkles'),
                    ]),
            ]);
    }
}
