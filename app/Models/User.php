<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;

#[Fillable(['nama', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory, Notifiable, HasRoles;

    public $incrementing = false;
    protected $keyType = 'string';

    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {

            $prefix = 'USR';

            $last = static::orderByRaw("CAST(SUBSTRING(id, 5) AS UNSIGNED) DESC", [])->first();

            if (!$last) {
                $model->id = $prefix . '-0001';
                return;
            }

            $number = (int) str_replace($prefix . '-', '', $last->id);

            $model->id = $prefix . '-' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->nama,
            set: fn ($value) => ['nama' => $value],
        );
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFilamentName(): string
    {
        return $this->nama ?? 'User';
    }

    public function isAdmin() : bool
    {
        return $this->hasRole('admin');
    }

    public function isPemilik() : bool
    {
        return $this->hasRole('pemilik');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasAnyRole(['pemilik', 'admin']);
    }
}
