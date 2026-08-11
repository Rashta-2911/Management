<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tagihan extends Model
{
    protected $table = 'tagihan';

    protected $fillable = [
        'penghuni_id',
        'kamar_id',
        'sewa_id',
        'jumlah',
        'tanggal_tagihan',
        'tanggal_jatuh_tempo',
        'status',
        'catatan',
    ];

    protected $attributes = [
        'status' => 'Belum Lunas',
    ];

    use SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {

            $prefix = 'T';

            $last = static::orderByRaw('CAST(SUBSTRING(id, 5) AS UNSIGNED) DESC', [])->first();

            if (! $last) {
                $model->id = $prefix.'-0001';

                return;
            }

            $number = (int) str_replace($prefix.'-', '', $last->id);

            $model->id = $prefix.'-'.str_pad($number + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    protected $casts = [
        'tanggal_tagihan' => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'jumlah' => 'decimal:2',
    ];

    public function sewa(): BelongsTo
    {
        return $this->belongsTo(Sewa::class, 'sewa_id');
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'tagihan_id');
    }

    public function penghuni(): HasOneThrough
    {
        return $this->hasOneThrough(
            Penghuni::class,
            Sewa::class,
            'id',
            'id',
            'sewa_id',
            'penghuni_id'
        );
    }
}
