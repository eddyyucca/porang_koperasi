<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
// Bumdes loaded via relationship, no extra import needed (same namespace)

class Lahan extends Model
{
    protected $table = 'lahan';

    protected $fillable = [
        'anggota_id', 'pemilik_type', 'bumdes_id', 'nama_lahan', 'luas_lahan', 'satuan_luas',
        'provinsi_id', 'provinsi_nama', 'kabupaten_id', 'kabupaten_nama',
        'kecamatan_id', 'kecamatan_nama', 'desa_id', 'desa_nama', 'alamat_lahan',
        'latitude', 'longitude', 'geojson',
        'status_kepemilikan', 'jenis_dokumen', 'nomor_dokumen', 'dokumen_file',
        'kondisi_tanah', 'aktif', 'catatan',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
        'luas_lahan' => 'float',
    ];

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class);
    }

    public function bumdes(): BelongsTo
    {
        return $this->belongsTo(Bumdes::class);
    }

    public function getPemilikNamaAttribute(): string
    {
        if ($this->pemilik_type === 'bumdes') {
            return $this->bumdes?->nama ?? '-';
        }
        return $this->anggota?->nama_lengkap ?? '-';
    }

    public function tanaman(): HasMany
    {
        return $this->hasMany(Tanaman::class);
    }

    public function panen(): HasMany
    {
        return $this->hasMany(Panen::class);
    }

    public function getLuasHektarAttribute(): float
    {
        return match($this->satuan_luas) {
            'm2'  => $this->luas_lahan / 10000,
            'are' => $this->luas_lahan / 100,
            'ha'  => $this->luas_lahan,
            default => $this->luas_lahan / 10000,
        };
    }

    public function getLokasiAttribute(): string
    {
        return implode(', ', array_filter([
            $this->desa_nama, $this->kecamatan_nama, $this->kabupaten_nama
        ]));
    }

    public function hasKoordinat(): bool
    {
        return !is_null($this->latitude) && !is_null($this->longitude);
    }
}
