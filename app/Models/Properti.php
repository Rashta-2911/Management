<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Properti extends Model
{
    use SoftDeletes;
    protected $table = 'properti';
    protected $fillable = [
        'nama_properti',
        'alamat',
        'jenis_properti',
        'kontak_pemilik',
        'fasilitas_umum',
        'peraturan',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {

            $prefix = 'PR';

            $last = static::orderByRaw("CAST(SUBSTRING(id, 4) AS UNSIGNED) DESC", [])->first();

            if (!$last) {
                $model->id = $prefix . '-0001';
                return;
            }

            $number = (int) str_replace($prefix . '-', '', $last->id);

            $model->id = $prefix . '-' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    public function tipeKamar(): HasMany
    {
        return $this->hasMany(TipeKamar::class, 'properti_id');
    }

    public function pemilik(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pemilik_id');
    }
}
