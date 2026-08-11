<?php

namespace App\Filament\Resources\Penggajian\Pages;

use App\Filament\Resources\Penggajian\PenggajianResource;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPenggajian extends EditRecord
{
    protected static string $resource = PenggajianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            EditAction::make(),
        ];
    }
}
