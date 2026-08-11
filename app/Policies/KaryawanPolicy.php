<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class KaryawanPolicy extends BaseOwnershipPolicy
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

        return $user->hasRole('pemilik') && $this->isOwnedBy($record, $user);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('pemilik');
    }

    public function update(User $user, Model $record): bool
    {
        return $user->hasRole('pemilik') && $this->isOwnedBy($record, $user);
    }

    public function delete(User $user, Model $record): bool
    {
        return $this->update($user, $record);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasRole('pemilik');
    }

    public function restore(User $user, Model $record): bool
    {
        return $this->update($user, $record);
    }

    public function restoreAny(User $user): bool
    {
        return $user->hasRole('pemilik');
    }

    public function forceDelete(User $user, Model $record): bool
    {
        return $this->update($user, $record);
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->hasRole('pemilik');
    }

    protected function isOwnedBy(Model $record, User $user): bool
    {
        return $record->properti()
            ->where('pemilik_id', $user->id)
            ->exists();
    }

    protected function resolvePemilikId(Model $record): ?string
    {
        return $record->properti()->value('pemilik_id');
    }
}
