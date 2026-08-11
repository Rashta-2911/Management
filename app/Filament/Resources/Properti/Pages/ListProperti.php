<?php

namespace App\Filament\Resources\Properti\Pages;

use App\Filament\Resources\Properti\PropertiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProperti extends ListRecords
{
    protected static string $resource = PropertiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Properti Baru')->icon('heroicon-o-plus'),
        ];
    }
}
