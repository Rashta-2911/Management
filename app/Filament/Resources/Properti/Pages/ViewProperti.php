<?php

namespace App\Filament\Resources\Properti\Pages;

use App\Filament\Resources\Properti\PropertiResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;
use Override;

class ViewProperti extends ViewRecord
{
    protected static string $resource = PropertiResource::class;

    protected ?string $heading = 'Data Properti';

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
