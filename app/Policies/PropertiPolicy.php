<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PropertiPolicy extends BaseOwnershipPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'pemilik']);
    }

    public function view(User $user, Model $record): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->hasRole('pemilik')
            && $this->resolvePemilikId($record) === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Model $record): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Model $record): bool
    {
        return $user->hasRole('admin');
    }

    protected function resolvePemilikId(Model $record): ?string
    {
        return $record->pemilik_id;
    }
}
