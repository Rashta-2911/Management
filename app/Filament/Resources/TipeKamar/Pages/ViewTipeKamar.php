<?php

namespace App\Filament\Resources\TipeKamar\Pages;

use App\Filament\Resources\TipeKamar\TipeKamarResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Override;

class ViewTipeKamar extends ViewRecord
{
    protected static string $resource = TipeKamarResource::class;

    protected ?string $heading = 'Data Tipe Kamar';

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
