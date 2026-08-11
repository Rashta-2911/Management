<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;

class Karyawan extends Model
{
    use SoftDeletes;

    protected $table = 'karyawan';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'properti_id',
        'nama',
        'jabatan',
        'no_telepon',
        'email',
        'gaji_pokok',
        'tanggal_masuk',
    ];

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $prefix = 'KRY';

            $last = static::query()
                ->orderByRaw('CAST(SUBSTRING(id, 5) AS UNSIGNED) DESC', [])
                ->first();

            if (! $last) {
                $model->id = $prefix.'-0001';

                return;
            }

            $number = (int) str_replace($prefix.'-', '', $last->id);
            $model->id = $prefix.'-'.str_pad($number + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    public function penggajian(): HasMany
    {
        return $this->hasMany(Penggajian::class, 'karyawan_id');
    }

    public function properti(): BelongsTo
    {
        return $this->belongsTo(Properti::class, 'properti_id');
    }
}
