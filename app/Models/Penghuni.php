<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Penghuni extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'kamar_id',
        'nama_penghuni',
        'no_hp',
        'email',
        'alamat_asal',
        'status',
    ];
    protected $table = 'penghuni';

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {

            $prefix = 'P';

            $last = static::orderByRaw("CAST(SUBSTRING(id, 5) AS UNSIGNED) DESC", [])->first();

            if (!$last) {
                $model->id = $prefix . '-0001';
                return;
            }

            $number = (int) str_replace($prefix . '-', '', $last->id);

            $model->id = $prefix . '-' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    protected function noHpWa(): Attribute
    {
        return Attribute::make(
            get: function () {
                $nomor = preg_replace('/\D/', '', $this->no_hp);

                if (str_starts_with($nomor, '0')) {
                    $nomor = '62' . substr($nomor, 1);
                } elseif (!str_starts_with($nomor, '62')) {
                    $nomor = '62' . $nomor;
                }

                return $nomor;
            }
        );
    }

    public function hasValidNoHp(): bool
    {
        $nomor = preg_replace('/\D/', '', $this->no_hp ?? '');
        return strlen($nomor) >= 10;
    }

    public function sewa(): HasMany
    {
        return $this->hasMany(Sewa::class, 'penghuni_id');
    }

    public function kamar(): BelongsTo
    {
    return $this->belongsTo(Kamar::class, 'kamar_id');
    }

    public function sewaAktif(): HasOne
    {
        return $this->hasOne(Sewa::class, 'penghuni_id')->where('status', 'aktif');
    }

    public function kamarSekarang(): HasOneThrough
    {
        return $this->hasOneThrough(
            Kamar::class,
            Sewa::class,
            'penghuni_id',
            'id',
            'id',
            'kamar_id'
        )-> where('sewa.status', 'Aktif');
    }
}
