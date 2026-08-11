<?php

namespace App\Filament\Resources\Properti\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

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
                                Select::make('pemilik_id')
                                    ->label('Pemilik')
                                    ->relationship(
                                        name: 'pemilik',
                                        modifyQueryUsing: fn (Builder $query) => $query->role('pemilik')
                                    )
                                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->nama} ({$record->email})")
                                    ->searchable(['nama', 'email'])
                                    ->preload()
                                    ->required(fn () => Auth::user()?->hasRole('admin'))
                                    ->default(fn () => Auth::id())
                                    ->visible(fn () => Auth::user()?->hasRole('admin'))
                                    ->columnSpanFull(),

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
                                    ->columnSpanFull()
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
                            ->nullable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
