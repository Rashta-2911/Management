<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PenggajianPolicy extends BaseOwnershipPolicy
{
    public function create(User $user): bool
    {
        return $user->hasRole('pemilik');
    }

    public function update(User $user, Model $record): bool
    {
        return $user->hasRole('pemilik')
            && $this->resolvePemilikId($record) === $user->id;
    }

    public function delete(User $user, Model $record): bool
    {
        return $this->update($user, $record);
    }

    public function restore(User $user, Model $record): bool
    {
        return $this->update($user, $record);
    }

    public function forceDelete(User $user, Model $record): bool
    {
        return false;
    }

    protected function resolvePemilikId(Model $record): ?string
    {
        return $record->karyawan?->properti?->pemilik_id;
    }
}
