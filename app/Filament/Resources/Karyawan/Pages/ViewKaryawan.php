<?php

namespace App\Filament\Resources\Karyawan\Pages;

use App\Filament\Resources\Karyawan\KaryawanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewKaryawan extends ViewRecord
{
    protected static string $resource = KaryawanResource::class;

    protected ?string $heading = 'Data Karyawan';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
