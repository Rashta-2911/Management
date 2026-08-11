<?php

namespace App\Filament\Resources\Penggajian\Schemas;

use App\Models\Karyawan;
use App\Services\PropertiContext;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class PenggajianForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Karyawan')
                    ->description('Pilih properti dan karyawan yang akan digaji')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('karyawan_id')
                                    ->label('Karyawan')
                                    ->options(function () {
                                        $propertiId = app(PropertiContext::class)->currentId();
                                        $query = Karyawan::query()->with('properti');

                                        if ($propertiId) {
                                            $query->where('properti_id', $propertiId);
                                        }

                                        return $query->get()->mapWithKeys(function ($karyawan) {
                                            return [
                                                $karyawan->id => "{$karyawan->nama} ({$karyawan->jabatan}) — {$karyawan->properti?->nama_properti} ({$karyawan->properti?->alamat})",
                                            ];
                                        });
                                    })
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        if ($state) {
                                            $karyawan = Karyawan::find($state);
                                            if ($karyawan) {
                                                $set('nominal_gaji', $karyawan->gaji_pokok);
                                            }
                                        }
                                    })
                                    ->prefixIcon('heroicon-o-identification')
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Section::make('Periode & Nominal')
                    ->description('Periode penggajian dan jumlah gaji yang dibayarkan')
                    ->icon('heroicon-o-banknotes')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('bulan')
                                    ->label('Bulan')
                                    ->options([
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                                    ])
                                    ->required()
                                    ->default(now()->month)
                                    ->prefixIcon('heroicon-o-calendar'),

                                TextInput::make('tahun')
                                    ->label('Tahun')
                                    ->required()
                                    ->numeric()
                                    ->default(now()->year)
                                    ->prefixIcon('heroicon-o-calendar-days'),

                                TextInput::make('nominal_gaji')
                                    ->label('Nominal Gaji')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->prefixIcon('heroicon-o-banknotes')
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Section::make('Status Pembayaran')
                    ->description('Konfirmasi status dan bukti pembayaran gaji')
                    ->icon('heroicon-o-check-circle')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'Belum Dibayar' => 'Belum Dibayar',
                                        'Sudah Dibayar' => 'Sudah Dibayar',
                                    ])
                                    ->required()
                                    ->default('Sudah Dibayar')
                                    ->live()
                                    ->prefixIcon('heroicon-o-check-circle'),

                                DatePicker::make('tanggal_dibayar')
                                    ->label('Tanggal Dibayar')
                                    ->default(now())
                                    ->required(fn (Get $get) => $get('status') === 'Sudah Dibayar')
                                    ->prefixIcon('heroicon-o-calendar-days'),

                                FileUpload::make('bukti_transfer')
                                    ->label('Bukti Transfer / Pembayaran')
                                    ->image()
                                    ->directory('bukti-transfer')
                                    ->maxSize(5120)
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
