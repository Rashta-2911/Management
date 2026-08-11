<?php

namespace App\Filament\Resources\Penggajian\Pages;

use App\Filament\Resources\Penggajian\PenggajianResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Override;

class ViewPenggajian extends ViewRecord
{
    protected static string $resource = PenggajianResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
