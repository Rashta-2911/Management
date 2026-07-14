<?php

namespace App\Filament\Resources\Pembayaran\Pages;

use App\Filament\Resources\Pembayaran\PembayaranResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Override;

class EditPembayaran extends EditRecord
{
    protected static string $resource = PembayaranResource::class;

    public function getTitle(): string | \Illuminate\Contracts\Support\Htmlable
    {
        return $this->getRecordTitle();
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
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
