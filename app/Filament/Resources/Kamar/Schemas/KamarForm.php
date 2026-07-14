<?php

namespace App\Filament\Resources\Kamar\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use App\Models\TipeKamar;

class KamarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kamar')
                    ->description('Detail tipe kamar dan penomoran')
                    ->icon('heroicon-o-home')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('tipe_kamar_id')
                                    ->label('Tipe Kamar')
                                    ->options(TipeKamar::all()->pluck('nama_tipe', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->prefixIcon('heroicon-o-tag'),

                                TextInput::make('nomor_kamar')
                                    ->label('No. Kamar')
                                    ->required()
                                    ->prefixIcon('heroicon-o-hashtag'),

                                Select::make('status')       
                                    ->label('Status Ketersediaan')
                                    ->options([
                                        'Tersedia' => 'Tersedia',
                                        'Terisi'   => 'Terisi',
                                    ])
                                    ->default('Tersedia')
                                    ->required()
                                    ->prefixIcon('heroicon-o-check-circle'),
                            ]),
                    ]),
            ]);
    }
}