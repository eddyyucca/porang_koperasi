<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Panen extends Model
{
    protected $table = 'panen';

    protected $fillable = [
        'tanaman_id', 'lahan_id', 'anggota_id',
        'tanggal_panen', 'berat_panen_kg', 'kualitas',
        'harga_per_kg', 'total_nilai', 'pembeli', 'metode_jual',
        'status_jual', 'catatan', 'foto',
    ];

    protected $casts = [
        'tanggal_panen' => 'date',
        'berat_panen_kg' => 'float',
        'harga_per_kg' => 'float',
        'total_nilai' => 'float',
    ];

    public function tanaman(): BelongsTo
    {
        return $this->belongsTo(Tanaman::class);
    }

    public function lahan(): BelongsTo
    {
        return $this->belongsTo(Lahan::class);
    }

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class);
    }

    // Hitung total nilai otomatis saat simpan
    protected static function booted(): void
    {
        static::saving(function ($panen) {
            if ($panen->harga_per_kg && $panen->berat_panen_kg) {
                $panen->total_nilai = $panen->harga_per_kg * $panen->berat_panen_kg;
            }
        });
    }

    public function getKualitasBadgeAttribute(): string
    {
        return match($this->kualitas) {
            'Grade A' => 'success',
            'Grade B' => 'warning',
            'Grade C' => 'secondary',
            default   => 'secondary',
        };
    }
}
