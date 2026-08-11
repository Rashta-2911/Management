<?php

namespace App\Filament\Resources\Sewa\Pages;

use App\Filament\Resources\Sewa\SewaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSewa extends ViewRecord
{
    protected static string $resource = SewaResource::class;

    protected ?string $heading = 'Data Sewa';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
