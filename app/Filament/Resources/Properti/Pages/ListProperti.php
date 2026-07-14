<?php

namespace App\Filament\Resources\Properti\Pages;

use App\Filament\Resources\Properti\PropertiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListProperti extends ListRecords
{
    protected static string $resource = PropertiResource::class;

    protected function getHeaderActions(): array
    {
        if (! Auth::user()?->isPemilik()) {
            return [];
        }

        return [
            CreateAction::make()->label('Properti Baru')->icon('heroicon-o-plus'),
        ];
    }
}
