<?php

namespace App\Policies;

use Illuminate\Database\Eloquent\Model;

class PenghuniPolicy extends BaseOwnershipPolicy
{
    protected function resolvePemilikId(Model $record): ?string
    {
        return $record->kamar?->tipeKamar?->properti?->pemilik_id;
    }
}
