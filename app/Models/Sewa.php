<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sewa extends Model
{
    protected $table = 'sewa';

    protected $fillable = [
        'kamar_id',
        'penghuni_id',
        'tipe_kamar_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'harga_disepakati',
        'status',
        'catatan',
    ];

    use SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (blank($model->tipe_kamar_id) && filled($model->kamar_id)) {
                $kamar = Kamar::query()->find($model->kamar_id);

                if ($kamar) {
                    $model->tipe_kamar_id = $kamar->tipe_kamar_id;
                }
            }

            $prefix = 'S';

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
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'harga_disepakati' => 'decimal:2',
    ];

    public function kamar(): BelongsTo
    {
        return $this->belongsTo(Kamar::class, 'kamar_id');
    }

    public function penghuni(): BelongsTo
    {
        return $this->belongsTo(Penghuni::class, 'penghuni_id');
    }

    public function tagihan(): HasMany
    {
        return $this->hasMany(Tagihan::class, 'sewa_id');
    }

    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'sewa_id');
    }

    public function tipeKamar(): BelongsTo
    {
        return $this->belongsTo(TipeKamar::class, 'tipe_kamar_id');
    }
}
