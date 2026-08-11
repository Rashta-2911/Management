<?php

namespace App\Filament\Resources\Karyawan\Pages;

use App\Filament\Resources\Karyawan\KaryawanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditKaryawan extends EditRecord
{
    protected static string $resource = KaryawanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
