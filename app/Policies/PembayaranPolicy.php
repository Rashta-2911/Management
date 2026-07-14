<?php

namespace App\Policies;

use App\Models\Pembayaran;
use Illuminate\Database\Eloquent\Model;

class PembayaranPolicy extends BaseOwnershipPolicy
{
    protected function resolvePemilikId(Model $record): ?string
    {
        return $record->sewa?->kamar?->tipeKamar?->properti?->pemilik_id;
    }
}