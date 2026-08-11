<?php

namespace App\Policies;

use Illuminate\Database\Eloquent\Model;

class TipeKamarPolicy extends BaseOwnershipPolicy
{
    protected function resolvePemilikId(Model $record): ?string
    {
        return $record->properti?->pemilik_id;
    }
}
