<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipeKamar extends Model
{
    use SoftDeletes;
    protected $table = 'tipe_kamar';
    protected $fillable = [
        'properti_id',
        'nama_tipe',
        'fasilitas',
        'luas_kamar',
        'kapasitas',
        'harga',
        'tipe_sewa',
    ];
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {

            $prefix = 'TK';

            $last = static::orderByRaw("CAST(SUBSTRING(id, 5) AS UNSIGNED) DESC", [])->first();

            if (!$last) {
                $model->id = $prefix . '-0001';
                return;
            }

            $number = (int) str_replace($prefix . '-', '', $last->id);

            $model->id = $prefix . '-' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    public function properti(): BelongsTo
    {
        return $this->belongsTo(Properti::class, 'properti_id');
    }

    public function kamar(): HasMany
    {
        return $this->hasMany(Kamar::class, 'tipe_kamar_id');
    }
}
