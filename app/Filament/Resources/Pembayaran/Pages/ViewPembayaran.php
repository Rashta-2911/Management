<?php

namespace App\Filament\Resources\Pembayaran\Pages;

use App\Filament\Resources\Pembayaran\PembayaranResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPembayaran extends ViewRecord
{
    protected static string $resource = PembayaranResource::class;

    public function getTitle(): string | \Illuminate\Contracts\Support\Htmlable
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
