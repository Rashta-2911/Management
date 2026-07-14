<?php

namespace App\Filament\Resources\Penghuni\Pages;

use App\Filament\Resources\Penghuni\PenghuniResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPenghuni extends EditRecord
{
    protected static string $resource = PenghuniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ViewAction::make(),
            
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
