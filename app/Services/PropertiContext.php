<?php

namespace App\Services;

use App\Models\Properti;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PropertiContext
{
    protected const SESSION_KEY = 'properti_aktif_id';

    public function availableFor(?User $user): Collection
    {
        if (! $user) {
            return collect();
        }

        if ($user->hasRole('admin')) {
            return Properti::query()->orderBy('nama_properti', 'asc')->get();
        }

        if ($user->hasRole('pemilik')) {
            return Properti::query()
                ->where('pemilik_id', $user->id)
                ->orderBy('nama_properti', 'asc')
                ->get();
        }

        return collect();
    }

    public function set(string $propertiId, ?User $user = null): void
    {
        $user = $user ?? Auth::user();

        if (! $user) {
            return;
        }

        $available = $this->availableFor($user);
        if ($available->contains(fn ($item) => $item->id === $propertiId)) {
            session()->put(self::SESSION_KEY, $propertiId);
        }
    }

    public function currentId(): ?string
    {
        $user = Auth::user();

        if (! $user) {
            return null;
        }

        $id = session()->get(self::SESSION_KEY);
        $available = $this->availableFor($user);

        if ($id && $available->contains(fn ($item) => $item->id === $id)) {
            return $id;
        }

        $first = $available->first();
        if ($first) {
            $this->set($first->id, $user);

            return $first->id;
        }

        return null;
    }

    public function current(): ?Properti
    {
        $id = $this->currentId();

        if (! $id) {
            return null;
        }

        return Properti::query()->find($id);
    }
}
