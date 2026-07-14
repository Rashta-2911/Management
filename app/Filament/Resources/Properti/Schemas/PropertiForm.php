<?php

namespace App\Filament\Resources\Properti\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class PropertiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dasar')
                    ->description('Detail utama properti')
                    ->icon('heroicon-o-building-office-2')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('nama_properti')
                                    ->label('Nama Properti')
                                    ->required()
                                    ->prefixIcon('heroicon-o-building-office'),
                                    
                                TextInput::make('jenis_properti')
                                    ->label('Jenis Properti')
                                    ->required()
                                    ->prefixIcon('heroicon-o-tag'),

                                TextInput::make('alamat')
                                    ->label('Alamat Lengkap')
                                    ->required()
                                    ->columnSpanFull()
                                    ->prefixIcon('heroicon-o-map-pin'),

                                TextInput::make('kontak_pemilik')
                                    ->label('Kontak Pemilik')
                                    ->required()
                                    ->prefixIcon('heroicon-o-phone'),
                            ]),
                    ]),

                Section::make('Fasilitas & Peraturan')
                    ->description('Informasi tambahan terkait operasional properti')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Textarea::make('fasilitas_umum')
                            ->label('Fasilitas Umum')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),

                        Textarea::make('peraturan')
                            ->label('Peraturan')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
