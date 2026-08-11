<?php

namespace App\Filament\Resources\Kamar\Pages;

use App\Filament\Resources\Kamar\KamarResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;
use Override;

class ViewKamar extends ViewRecord
{
    protected static string $resource = KamarResource::class;

    protected ?string $heading = 'Data Kamar';

    #[Override]
    protected function getHeaderActions(): array
    {
        if (! Auth::user()?->isPemilik()) {
            return [];
        }

        return [
            EditAction::make(),
        ];
    }
}
