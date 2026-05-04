<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Koperasi extends Model
{
    protected $table = 'koperasi';

    protected $fillable = [
        'nama', 'nomor_badan_hukum', 'tanggal_berdiri', 'alamat',
        'provinsi_id', 'provinsi_nama', 'kabupaten_id', 'kabupaten_nama',
        'kecamatan_id', 'kecamatan_nama', 'desa_id', 'desa_nama', 'kode_pos',
        'ketua', 'sekretaris', 'bendahara', 'telepon', 'email', 'logo',
        'visi', 'misi', 'aktif',
    ];

    protected $casts = [
        'tanggal_berdiri' => 'date',
        'aktif' => 'boolean',
    ];

    public function anggota(): HasMany
    {
        return $this->hasMany(Anggota::class);
    }

    public function totalAnggota(): int
    {
        return $this->anggota()->where('status', 'aktif')->count();
    }
}
