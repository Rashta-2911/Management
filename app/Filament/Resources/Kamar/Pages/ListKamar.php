<?php

namespace App\Filament\Resources\Kamar\Pages;

use App\Filament\Resources\Kamar\KamarResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListKamar extends ListRecords
{
    protected static string $resource = KamarResource::class;

    protected function getHeaderActions(): array
    {
        if (! Auth::user()?->hasAnyRole(['admin', 'pemilik'])) {
            return [];
        }

        return [
            CreateAction::make()->label('Kamar Baru')->icon('heroicon-o-plus'),
        ];
    }
}
