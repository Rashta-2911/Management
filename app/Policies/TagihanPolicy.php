<?php

namespace App\Policies;

use Illuminate\Database\Eloquent\Model;

class TagihanPolicy extends BaseOwnershipPolicy
{
    protected function resolvePemilikId(Model $record): ?string
    {
        return $record->sewa?->kamar?->tipeKamar?->properti?->pemilik_id;
    }
}
