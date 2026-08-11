<?php

namespace App\Filament\Resources\Pembayaran\Pages;

use App\Filament\Resources\Pembayaran\PembayaranResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewPembayaran extends ViewRecord
{
    protected static string $resource = PembayaranResource::class;

    public function getTitle(): string|Htmlable
    {
        return $this->getRecordTitle();
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
