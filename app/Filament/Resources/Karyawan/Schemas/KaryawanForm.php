<?php

namespace App\Filament\Resources\Karyawan\Schemas;

use App\Services\PropertiContext;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class KaryawanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Karyawan')
                    ->description('Data diri dan penempatan kerja karyawan')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('nama')
                                    ->label('Nama')
                                    ->required()
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-o-user'),

                                TextInput::make('jabatan')
                                    ->label('Jabatan')
                                    ->required()
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-o-briefcase'),

                                Select::make('properti_id')
                                    ->label('Properti')
                                    ->options(function () {
                                        return app(PropertiContext::class)->availableFor(Auth::user())
                                            ->mapWithKeys(fn ($p) => [$p->id => "{$p->nama_properti} — {$p->alamat}"]);
                                    })
                                    ->default(fn () => app(PropertiContext::class)->currentId())
                                    ->searchable()
                                    ->required()
                                    ->prefixIcon('heroicon-o-building-office')
                                    ->columnSpanFull(),

                                DatePicker::make('tanggal_masuk')
                                    ->label('Tanggal Masuk')
                                    ->required()
                                    ->prefixIcon('heroicon-o-calendar'),
                            ]),
                    ]),

                Section::make('Kontak & Gaji')
                    ->description('Informasi kontak dan gaji pokok karyawan')
                    ->icon('heroicon-o-phone')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('no_telepon')
                                    ->label('Nomor HP')
                                    ->tel()
                                    ->maxLength(20)
                                    ->prefixIcon('heroicon-o-device-phone-mobile'),

                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-o-envelope'),

                                TextInput::make('gaji_pokok')
                                    ->label('Gaji Pokok')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->prefixIcon('heroicon-o-banknotes')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
