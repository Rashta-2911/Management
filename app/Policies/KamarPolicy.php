<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class KamarPolicy extends BaseOwnershipPolicy
{
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'pemilik']);
    }

    public function update(User $user, Model $record): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->hasRole('pemilik')
            && $this->resolvePemilikId($record) === $user->id;
    }

    protected function resolvePemilikId(Model $record): ?string
    {
        return $record->tipeKamar?->properti?->pemilik_id;
    }
}
