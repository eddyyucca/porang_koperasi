<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bumdes extends Model
{
    protected $table = 'bumdes';

    protected $fillable = [
        'nama', 'nomor_sk', 'tanggal_sk', 'alamat',
        'provinsi_id', 'provinsi_nama', 'kabupaten_id', 'kabupaten_nama',
        'kecamatan_id', 'kecamatan_nama', 'desa_id', 'desa_nama',
        'direktur', 'telepon', 'email', 'rekening_bank', 'nama_bank', 'aktif',
    ];

    protected $casts = [
        'tanggal_sk' => 'date',
        'aktif' => 'boolean',
    ];

    public function lahan(): HasMany
    {
        return $this->hasMany(Lahan::class);
    }

    public function getLokasiAttribute(): string
    {
        return implode(', ', array_filter([
            $this->desa_nama, $this->kecamatan_nama, $this->kabupaten_nama
        ]));
    }
}
