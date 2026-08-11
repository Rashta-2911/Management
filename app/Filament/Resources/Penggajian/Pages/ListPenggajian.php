<?php

namespace App\Filament\Resources\Penggajian\Pages;

use App\Filament\Resources\Penggajian\PenggajianResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPenggajian extends ListRecords
{
    protected static string $resource = PenggajianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Penggajian Baru')
                ->icon('heroicon-o-plus'),
        ];
    }
}
