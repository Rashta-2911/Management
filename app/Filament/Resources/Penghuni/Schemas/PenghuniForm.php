<?php

namespace App\Filament\Resources\Penghuni\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class PenghuniForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Penghuni')
                    ->description('Data diri dan penempatan kamar')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('nama_penghuni')
                                    ->label('Nama Lengkap')
                                    ->required()
                                    ->prefixIcon('heroicon-o-user'),

                                Select::make('kamar_id')
                                    ->label('No. Kamar')
                                    ->relationship('kamar', 'nomor_kamar')
                                    ->preload()
                                    ->searchable()
                                    ->required()
                                    ->prefixIcon('heroicon-o-home'),

                                Select::make('status')
                                    ->label('Status Pekerjaan/Pendidikan')
                                    ->options([
                                        'Pekerja' => 'Pekerja',
                                        'Mahasiswa' => 'Mahasiswa',
                                        'Lainnya' => 'Lainnya',
                                    ])
                                    ->required()
                                    ->prefixIcon('heroicon-o-briefcase'),
                            ]),
                    ]),

                Section::make('Kontak & Identitas')
                    ->description('Informasi kontak yang dapat dihubungi')
                    ->icon('heroicon-o-phone')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('no_hp')
                                    ->label('No. Handphone (WhatsApp)')
                                    ->tel()
                                    ->rules(['regex:/^(0|62|\+62)[0-9]{9,13}$/'])
                                    ->helperText('Format: 081234567890 atau 6281234567890')
                                    ->required()
                                    ->prefixIcon('heroicon-o-device-phone-mobile'),

                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                                    ->prefixIcon('heroicon-o-envelope'),

                                TextInput::make('alamat_asal')
                                    ->label('Alamat Asal')
                                    ->required()
                                    ->columnSpanFull()
                                    ->prefixIcon('heroicon-o-map'),
                            ]),
                    ]),
            ]);
    }
}
