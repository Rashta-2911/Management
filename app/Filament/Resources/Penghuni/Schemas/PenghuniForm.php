<?php

namespace App\Filament\Resources\Penghuni\Schemas;

use App\Services\PropertiContext;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

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
                                    ->relationship('kamar', 'nomor_kamar',
                                        modifyQueryUsing: fn (Builder $query) => $query->whereHas('tipeKamar',
                                            fn ($sq) => $sq->where('properti_id', app(PropertiContext::class)->currentId())
                                        )
                                    )
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
                                    ->columnSpanFull()
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
                                    ->placeholder('08XXXXXXXXXX')
                                    ->required()
                                    ->prefixIcon('heroicon-o-device-phone-mobile'),

                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->placeholder('budi12@xxx.com')
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
