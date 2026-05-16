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
        'luas_tanam', 'jarak_tanam',
        'jarak_tanam_x_cm', 'jarak_tanam_y_cm', 'estimasi_batang',
        'tanggal_tanam', 'estimasi_panen',
        'tunda_tanggal_baru', 'tunda_alasan', 'gagal_alasan',
        'tanggal_panen_aktual', 'status', 'umur_tanam_bulan',
        'konfirmasi_tanam_at', 'konfirmasi_tanam_user_id',
        'konfirmasi_panen_at', 'konfirmasi_panen_user_id',
        'harga_per_kg_panen', 'berat_panen_kg', 'total_nilai_panen', 'kualitas_panen',
        'pupuk_digunakan', 'pestisida_digunakan', 'kendala', 'catatan', 'foto',
    ];

    protected $casts = [
        'tanggal_tanam'        => 'date',
        'estimasi_panen'       => 'date',
        'tunda_tanggal_baru'   => 'date',
        'tanggal_panen_aktual' => 'date',
        'konfirmasi_tanam_at'  => 'datetime',
        'konfirmasi_panen_at'  => 'datetime',
        'jumlah_bibit'         => 'integer',
        'estimasi_batang'      => 'integer',
        'jarak_tanam_x_cm'     => 'integer',
        'jarak_tanam_y_cm'     => 'integer',
        'berat_panen_kg'       => 'float',
        'harga_per_kg_panen'   => 'float',
        'total_nilai_panen'    => 'float',
    ];

    // ── Relationships ──────────────────────────────────────────────

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

    public function konfirmasiTanamUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'konfirmasi_tanam_user_id');
    }

    public function konfirmasiPanenUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'konfirmasi_panen_user_id');
    }

    // ── Computed attributes ────────────────────────────────────────

    public function getUmurSaatIniAttribute(): int
    {
        return $this->tanggal_tanam->diffInMonths(now());
    }

    public function getSisaHariPanenAttribute(): ?int
    {
        $acuan = $this->tunda_tanggal_baru ?? $this->estimasi_panen;
        if (!$acuan) return null;
        return (int) now()->diffInDays($acuan, false);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'persiapan'  => 'secondary',
            'tanam'      => 'primary',
            'tumbuh'     => 'success',
            'siap_panen' => 'warning',
            'panen'      => 'info',
            'tunda'      => 'orange',
            'gagal'      => 'danger',
            default      => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'persiapan'  => 'Persiapan',
            'tanam'      => 'Tanam',
            'tumbuh'     => 'Tumbuh',
            'siap_panen' => 'Siap Panen',
            'panen'      => 'Panen',
            'tunda'      => 'Tunda Panen',
            'gagal'      => 'Gagal Panen',
            default      => ucfirst($this->status),
        };
    }

    public function sudahKonfirmasiTanam(): bool
    {
        return !is_null($this->konfirmasi_tanam_at);
    }

    public function sudahPanen(): bool
    {
        return $this->status === 'panen';
    }

    public function bisaDitunda(): bool
    {
        return in_array($this->status, ['tumbuh', 'siap_panen']);
    }

    public function bisaGagal(): bool
    {
        return in_array($this->status, ['tanam', 'tumbuh', 'siap_panen', 'tunda']);
    }

    /** Minimal 12 bulan setelah tanam sebelum bisa konfirmasi panen */
    public function bisaPanen(): bool
    {
        return in_array($this->status, ['tumbuh', 'siap_panen', 'tunda'])
            && $this->tanggal_tanam->diffInMonths(now()) >= 12;
    }

    public function bulanSisaHinggaPanen(): int
    {
        return max(0, 12 - $this->tanggal_tanam->diffInMonths(now()));
    }

    // ── Static helpers ─────────────────────────────────────────────

    /** Estimasi panen: porang perdana ~20 bulan */
    public static function hitungEstimasiPanen(string $tanggalTanam): string
    {
        return Carbon::parse($tanggalTanam)->addMonths(20)->format('Y-m-d');
    }

    /**
     * Hitung estimasi batang berdasarkan luas lahan (dalam satuan asli) dan jarak tanam.
     * Porang standar: 100×100 cm = 10.000 batang/ha
     */
    public static function hitungEstimasiBatang(
        float $luasLahan,
        string $satuanLuas,
        int $jarakXcm = 100,
        int $jarakYcm = 100
    ): int {
        // Convert to m²
        $luasM2 = match($satuanLuas) {
            'ha'  => $luasLahan * 10000,
            'are' => $luasLahan * 100,
            'm2'  => $luasLahan,
            default => $luasLahan,
        };

        $jarakXm = $jarakXcm / 100;
        $jarakYm = $jarakYcm / 100;

        return (int) floor($luasM2 / ($jarakXm * $jarakYm));
    }
}
