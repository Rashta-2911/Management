<?php

namespace App\Filament\Resources\Pembayaran\Pages;

use App\Filament\Resources\Pembayaran\PembayaranResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPembayaran extends ListRecords
{
    protected static string $resource = PembayaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Pembayaran Baru')->icon('heroicon-o-plus'),
        ];
    }
}
