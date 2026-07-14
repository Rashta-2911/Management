<?php

namespace App\Filament\Resources\Sewa\Pages;

use App\Filament\Resources\Sewa\SewaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSewa extends ListRecords
{
    protected static string $resource = SewaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Sewa Baru')->icon('heroicon-o-plus'),
        ];
    }
}
