<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kamar extends Model
{
    use SoftDeletes;
    protected $table = 'kamar';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tipe_kamar_id',
        'nomor_kamar',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            $prefix = 'KMR';

            $last = static::orderByRaw("CAST(SUBSTRING(id, 5) AS UNSIGNED) DESC", [])->first();

            if (!$last) {
                $model->id = $prefix . '-0001';
                return;
            }

            $number = (int) str_replace($prefix . '-', '', $last->id);

            $model->id = $prefix . '-' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    protected function kamarLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Kamar ' . $this->nomor_kamar,
        );
    }

    public function penghuni(): HasMany
    {
        return $this->hasMany(Penghuni::class, 'kamar_id');
    }

    public function tipeKamar(): BelongsTo
    {
        return $this->belongsTo(TipeKamar::class, 'tipe_kamar_id');
    }

    public function sewaAktif(): HasOne
    {
        return $this->hasOne(Sewa::class, 'kamar_id')->where('status', 'aktif');
    }
}