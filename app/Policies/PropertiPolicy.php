<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PropertiPolicy extends BaseOwnershipPolicy
{
    public function create(User $user): bool
    {
        return $user->hasRole('pemilik');
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
        return $record->pemilik_id;
    }
}
