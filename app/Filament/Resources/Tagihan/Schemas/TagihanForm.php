<?php

namespace App\Filament\Resources\Tagihan\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use App\Models\Sewa;

class TagihanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Utama')
                    ->description('Detail sewa dan jumlah tagihan')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('sewa_id')
                                    ->label('Pilih Sewa Aktif')
                                    ->options(
                                        Sewa::with(['penghuni', 'kamar'])
                                            ->where('status', 'Aktif')
                                            ->get()
                                            ->mapWithKeys(fn ($sewa) => [
                                                $sewa->id => "{$sewa->penghuni->nama_penghuni} — Kamar {$sewa->kamar->nomor_kamar}",
                                            ])
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->reactive()
                                    ->prefixIcon('heroicon-o-document-text')
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state) {
                                            $sewa = Sewa::find($state);
                                            $set('jumlah', $sewa?->harga_disepakati);
                                        }
                                    }),

                                TextInput::make('jumlah')
                                    ->label('Jumlah Tagihan')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),
                            ]),
                    ]),

                Section::make('Tanggal & Status')
                    ->description('Pengaturan jadwal dan status pembayaran')
                    ->icon('heroicon-o-calendar-days')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                DatePicker::make('tanggal_tagihan')
                                    ->label('Tanggal Tagihan')
                                    ->default(now())
                                    ->required()
                                    ->prefixIcon('heroicon-o-calendar'),

                                DatePicker::make('tanggal_jatuh_tempo')
                                    ->label('Jatuh Tempo')
                                    ->after('tanggal_tagihan')
                                    ->required()
                                    ->prefixIcon('heroicon-o-clock'),

                                Select::make('status')
                                    ->options([
                                        'Belum Lunas' => 'Belum Lunas',
                                        'Terlambat' => 'Terlambat',
                                        'Lunas' => 'Lunas',
                                    ])
                                    ->default('Belum Lunas')
                                    ->hidden(fn (string $operation) => $operation === 'create')
                                    ->required()
                                    ->prefixIcon('heroicon-o-flag'),
                            ]),
                    ]),

                Section::make('Catatan Tambahan')
                    ->schema([
                        Textarea::make('catatan')
                            ->label('Catatan')
                            ->nullable()
                            ->columnSpanFull()
                            ->rows(3),
                    ]),
            ]);
    }
}
