<?php

namespace App\Filament\Resources\TipeKamar\Pages;

use App\Filament\Resources\TipeKamar\TipeKamarResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Override;

class EditTipeKamar extends EditRecord
{
    protected static string $resource = TipeKamarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    #[Override]
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
