<?php

namespace App\Filament\Resources\TipeKamar\Pages;

use App\Filament\Resources\TipeKamar\TipeKamarResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTipeKamar extends ListRecords
{
    protected static string $resource = TipeKamarResource::class;

    protected function getHeaderActions(): array
    {
        if (!TipeKamarResource::canCreate()) {
            return [];
        }

        return [
            CreateAction::make()->label('Tipe Kamar Baru')->icon('heroicon-o-plus'),
        ];
    }
}
