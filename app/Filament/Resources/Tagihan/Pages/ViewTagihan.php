<?php

namespace App\Filament\Resources\Tagihan\Pages;

use App\Filament\Resources\Tagihan\TagihanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTagihan extends ViewRecord
{
    protected static string $resource = TagihanResource::class;

    protected ?string $heading = 'Data Tagihan';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
