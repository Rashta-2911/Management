<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

abstract class BaseOwnershipPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'pemilik']);
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
        return false;
    }

    public function restore(User $user, Model $record): bool
    {
        return false;
    }

    public function forceDelete(User $user, Model $record): bool
    {
        return false;
    }

    abstract protected function resolvePemilikId(Model $record): ?string;
}
