<?php

namespace App\Filament\Resources\Kamar\Schemas;

use App\Models\TipeKamar;
use App\Services\PropertiContext;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KamarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kamar')
                    ->description('Detail tipe kamar dan penomoran')
                    ->icon('heroicon-o-home')
                    ->columns(1)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('tipe_kamar_id')
                            ->label('Tipe Kamar')
                            ->options(function () {
                                $propertiId = app(PropertiContext::class)->currentId();

                                return TipeKamar::where('properti_id', $propertiId)
                                    ->pluck('nama_tipe', 'id');
                            })
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
                                'Terisi' => 'Terisi',
                            ])
                            ->default('Tersedia')
                            ->required()
                            ->prefixIcon('heroicon-o-check-circle'),
                    ]),
            ]);
    }
}
