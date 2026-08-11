<?php

namespace App\Filament\Resources\Pembayaran\Schemas;

use App\Models\Sewa;
use App\Models\Tagihan;
use App\Services\PropertiContext;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PembayaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Referensi')
                    ->description('Tautan data ke Sewa dan Tagihan')
                    ->icon('heroicon-o-link')
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                Select::make('sewa_id')
                                    ->label('Data Sewa')
                                    ->options(function () {
                                        $propertiId = app(PropertiContext::class)->currentId();

                                        $query = Sewa::query()->with(['kamar.tipeKamar']);

                                        if ($propertiId) {
                                            $query->whereHas('kamar.tipeKamar', fn ($sq) => $sq->where('properti_id', $propertiId));
                                        }

                                        return $query->get()->mapWithKeys(fn ($sewa) => [
                                            $sewa->id => $sewa->kamar?->nomor_kamar ? "Kamar {$sewa->kamar->nomor_kamar} — {$sewa->penghuni?->nama_penghuni}" : $sewa->id,
                                        ]);
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->prefixIcon('heroicon-o-home-modern'),

                                Select::make('tagihan_id')
                                    ->label('Tagihan Terkait')
                                    ->options(function () {
                                        $propertiId = app(PropertiContext::class)->currentId();

                                        $query = Tagihan::query()->with(['sewa.kamar.tipeKamar']);

                                        if ($propertiId) {
                                            $query->whereHas('sewa.kamar.tipeKamar', fn ($sq) => $sq->where('properti_id', $propertiId));
                                        }

                                        return $query->get()->mapWithKeys(fn ($tagihan) => [
                                            $tagihan->id => $tagihan->sewa?->kamar?->nomor_kamar
                                                ? "Tagihan {$tagihan->id} — Kamar {$tagihan->sewa->kamar->nomor_kamar}"
                                                : $tagihan->id,
                                        ]);
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->nullable()
                                    ->prefixIcon('heroicon-o-document-text'),
                            ]),
                    ]),

                Section::make('Detail Pembayaran')
                    ->description('Informasi nilai, tanggal, dan metode')
                    ->icon('heroicon-o-currency-dollar')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('jumlah')
                                    ->label('Jumlah Pembayaran')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),

                                DatePicker::make('tanggal_pembayaran')
                                    ->label('Tanggal Pembayaran')
                                    ->required()
                                    ->prefixIcon('heroicon-o-calendar'),

                                Select::make('metode_pembayaran')
                                    ->label('Metode Pembayaran')
                                    ->options([
                                        'Transfer' => 'Transfer',
                                        'Cash' => 'Cash',
                                    ])
                                    ->required()
                                    ->prefixIcon('heroicon-o-credit-card'),

                                Select::make('status')
                                    ->label('Status Validasi')
                                    ->options([
                                        'Lunas' => 'Lunas',
                                    ])
                                    ->default('Lunas')
                                    ->required()
                                    ->prefixIcon('heroicon-o-check-circle'),
                            ]),
                    ]),

                Section::make('Bukti Transaksi')
                    ->description('Upload foto atau screenshot bukti transfer')
                    ->icon('heroicon-o-photo')
                    ->columnSpanFull()
                    ->schema([
                        FileUpload::make('bukti_pembayaran')
                            ->label('Upload Bukti')
                            ->image()
                            ->disk('public')
                            ->directory('pembayaran')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->previewable(true)
                            ->downloadable(true)
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
