<?php

namespace App\Policies;

use App\Models\Sewa;
use Illuminate\Database\Eloquent\Model;

class SewaPolicy extends BaseOwnershipPolicy
{
    protected function resolvePemilikId(Model $record): ?string
    {
        return $record->kamar?->tipeKamar?->properti?->pemilik_id;
    }
}