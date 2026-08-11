<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

class Penggajian extends Model
{
    protected $table = 'penggajian';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'karyawan_id',
        'bulan',
        'tahun',
        'nominal_gaji',
        'status',
        'tanggal_dibayar',
        'catatan',
        'bukti_transfer',
        'dikirim_at',
        'dikirim_via',
    ];

    protected $casts = [
        'tanggal_dibayar' => 'date',
        'nominal_gaji' => 'decimal:2',
        'dikirim_at' => 'datetime',
    ];

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $prefix = 'GJ';

            $last = static::query()
                ->orderByRaw('CAST(SUBSTRING(id, 4) AS UNSIGNED) DESC', [])
                ->first();

            if (! $last) {
                $model->id = $prefix.'-0001';

                return;
            }

            $number = (int) str_replace($prefix.'-', '', $last->id);
            $model->id = $prefix.'-'.str_pad($number + 1, 4, '0', STR_PAD_LEFT);
        });

        static::updating(function ($model) {
            // safety net: kalau status diubah jadi Sudah Dibayar tapi tanggal belum keisi, isi otomatis
            if ($model->isDirty('status') && $model->status === 'Sudah Dibayar' && ! $model->tanggal_dibayar) {
                $model->tanggal_dibayar = now();
            }
        });
    }

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class);
    }
}
