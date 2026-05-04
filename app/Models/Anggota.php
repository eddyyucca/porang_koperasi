<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Anggota extends Model
{
    protected $table = 'anggota';

    protected $fillable = [
        'nomor_anggota', 'jenis_anggota', 'bumdes_id',
        'nik', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'golongan_darah', 'agama', 'status_perkawinan',
        'pendidikan', 'pekerjaan_ktp', 'kewarganegaraan',
        'alamat_ktp', 'rt_ktp', 'rw_ktp', 'desa_id_ktp', 'desa_ktp',
        'kecamatan_id_ktp', 'kecamatan_ktp', 'kabupaten_id_ktp', 'kabupaten_ktp',
        'provinsi_id_ktp', 'provinsi_ktp', 'kode_pos_ktp',
        'alamat_domisili', 'rt_domisili', 'rw_domisili',
        'desa_domisili', 'kecamatan_domisili', 'kabupaten_domisili', 'provinsi_domisili',
        'telepon', 'email', 'foto_ktp', 'foto_diri',
        'no_rekening', 'nama_bank',
        'koperasi_id', 'tanggal_daftar', 'status', 'catatan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_daftar' => 'date',
    ];

    public function koperasi(): BelongsTo
    {
        return $this->belongsTo(Koperasi::class);
    }

    public function bumdes(): BelongsTo
    {
        return $this->belongsTo(Bumdes::class);
    }

    public function lahan(): HasMany
    {
        return $this->hasMany(Lahan::class);
    }

    public function tanaman(): HasMany
    {
        return $this->hasMany(Tanaman::class);
    }

    public function panen(): HasMany
    {
        return $this->hasMany(Panen::class);
    }

    public function getUmurAttribute(): int
    {
        return $this->tanggal_lahir->age;
    }

    public function getAlamatLengkapKtpAttribute(): string
    {
        $parts = array_filter([
            $this->alamat_ktp,
            $this->rt_ktp ? 'RT ' . $this->rt_ktp : null,
            $this->rw_ktp ? 'RW ' . $this->rw_ktp : null,
            $this->desa_ktp,
            $this->kecamatan_ktp,
            $this->kabupaten_ktp,
            $this->provinsi_ktp,
        ]);
        return implode(', ', $parts);
    }

    public function getTotalLahanAttribute(): float
    {
        return $this->lahan()->where('aktif', true)->sum('luas_lahan');
    }

    public function getTotalPanenKgAttribute(): float
    {
        return $this->panen()->sum('berat_panen_kg');
    }

    // Generate nomor anggota otomatis
    public static function generateNomorAnggota(): string
    {
        $tahun = date('Y');
        $last = static::whereYear('created_at', $tahun)
            ->orderBy('id', 'desc')
            ->first();
        $urut = $last ? ((int) substr($last->nomor_anggota, -4)) + 1 : 1;
        return 'KTP-' . $tahun . '-' . str_pad($urut, 4, '0', STR_PAD_LEFT);
    }
}
