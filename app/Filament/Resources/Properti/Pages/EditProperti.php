<?php

namespace App\Filament\Resources\Properti\Pages;

use App\Filament\Resources\Properti\PropertiResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Override;

class EditProperti extends EditRecord
{
    protected static string $resource = PropertiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
            ViewAction::make(),
        ];
    }

    #[Override]
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
