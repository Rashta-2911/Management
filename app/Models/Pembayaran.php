<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'sewa_id',
        'tagihan_id',
        'tanggal_pembayaran',
        'metode_pembayaran',
        'jumlah',
        'status',
        'bukti_pembayaran',
    ];

    use SoftDeletes;

    #[Override]
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {

            $prefix = 'PYR';

            $last = static::orderByRaw('CAST(SUBSTRING(id, 5) AS UNSIGNED) DESC', [])->first();

            if (! $last) {
                $model->id = $prefix.'-0001';

                return;
            }

            $number = (int) str_replace($prefix.'-', '', $last->id);

            $model->id = $prefix.'-'.str_pad($number + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    #[Override]
    protected static function booted(): void
    {
        static::created(function (Pembayaran $pembayaran) {
            $pembayaran->tagihan->update(['status' => 'Lunas']);
        });
    }

    public function sewa(): BelongsTo
    {
        return $this->belongsTo(Sewa::class, 'sewa_id');
    }

    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class, 'tagihan_id');
    }
}
