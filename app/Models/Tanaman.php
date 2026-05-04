<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Tanaman extends Model
{
    protected $table = 'tanaman';

    protected $fillable = [
        'lahan_id', 'anggota_id', 'varietas', 'sumber_bibit', 'jumlah_bibit',
        'luas_tanam', 'jarak_tanam', 'tanggal_tanam', 'estimasi_panen',
        'tanggal_panen_aktual', 'status', 'umur_tanam_bulan',
        'pupuk_digunakan', 'pestisida_digunakan', 'kendala', 'catatan', 'foto',
    ];

    protected $casts = [
        'tanggal_tanam' => 'date',
        'estimasi_panen' => 'date',
        'tanggal_panen_aktual' => 'date',
        'jumlah_bibit' => 'integer',
    ];

    public function lahan(): BelongsTo
    {
        return $this->belongsTo(Lahan::class);
    }

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class);
    }

    public function panen(): HasMany
    {
        return $this->hasMany(Panen::class);
    }

    public function getUmurSaatIniAttribute(): int
    {
        return $this->tanggal_tanam->diffInMonths(now());
    }

    public function getSisaHariPanenAttribute(): ?int
    {
        if (!$this->estimasi_panen) return null;
        $sisa = now()->diffInDays($this->estimasi_panen, false);
        return (int) $sisa;
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'persiapan' => 'secondary',
            'tanam'     => 'primary',
            'tumbuh'    => 'success',
            'panen'     => 'warning',
            'gagal'     => 'danger',
            default     => 'secondary',
        };
    }

    // Estimasi otomatis panen: porang panen perdana ~18-24 bulan
    public static function hitungEstimasiPanen(string $tanggalTanam): string
    {
        return Carbon::parse($tanggalTanam)->addMonths(20)->format('Y-m-d');
    }
}
