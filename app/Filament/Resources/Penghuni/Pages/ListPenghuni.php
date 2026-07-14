<?php

namespace App\Filament\Resources\Penghuni\Pages;

use App\Filament\Resources\Penghuni\PenghuniResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPenghuni extends ListRecords
{
    protected static string $resource = PenghuniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Penghuni Baru')->icon('heroicon-o-plus'),
        ];
    }
}
