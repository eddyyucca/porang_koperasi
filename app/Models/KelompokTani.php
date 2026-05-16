<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KelompokTani extends Model
{
    protected $table = 'kelompok_tani';

    protected $fillable = [
        'nama_kelompok',
        'nomor_sk',
        'ketua_nama',
        'ketua_nik',
        'ketua_telepon',
        'sekretaris',
        'bendahara',
        'provinsi_id',
        'provinsi_nama',
        'kabupaten_id',
        'kabupaten_nama',
        'kecamatan_id',
        'kecamatan_nama',
        'desa_id',
        'desa_nama',
        'alamat',
        'tahun_berdiri',
        'jumlah_anggota',
        'komoditas_utama',
        'luas_lahan_total',
        'bumdes_id',
        'koperasi_id',
        'status',
        'catatan',
        'foto',
    ];

    protected $casts = [
        'tahun_berdiri'    => 'integer',
        'luas_lahan_total' => 'float',
        'jumlah_anggota'   => 'integer',
    ];

    // Relations

    public function anggota(): HasMany
    {
        return $this->hasMany(Anggota::class);
    }

    public function bumdes(): BelongsTo
    {
        return $this->belongsTo(Bumdes::class);
    }

    public function koperasi(): BelongsTo
    {
        return $this->belongsTo(Koperasi::class);
    }

    // Accessors

    public function getLuasHektarAttribute(): float
    {
        return $this->luas_lahan_total / 10000;
    }

    public function getLokasi(): string
    {
        return implode(', ', array_filter([
            $this->desa_nama,
            $this->kecamatan_nama,
            $this->kabupaten_nama,
        ]));
    }

    // Static helpers

    public static function generateNomorKelompok(): string
    {
        $tahun = date('Y');
        $last  = static::whereYear('created_at', $tahun)
            ->orderBy('id', 'desc')
            ->first();
        $urut = $last ? ((int) substr($last->id, -4)) + 1 : 1;
        return 'KT-' . $tahun . '-' . str_pad($urut, 4, '0', STR_PAD_LEFT);
    }
}
