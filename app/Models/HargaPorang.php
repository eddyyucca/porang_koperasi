<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HargaPorang extends Model
{
    protected $table = 'harga_porang';

    protected $fillable = ['harga_per_kg', 'berlaku_mulai', 'keterangan', 'user_id'];

    protected $casts = [
        'berlaku_mulai' => 'date',
        'harga_per_kg'  => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Ambil harga aktif saat ini (berlaku_mulai <= hari ini, terbaru) */
    public static function hargaAktif(): ?self
    {
        return static::where('berlaku_mulai', '<=', today())
            ->orderByDesc('berlaku_mulai')
            ->orderByDesc('id')
            ->first();
    }

    public function getHargaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga_per_kg, 0, ',', '.');
    }
}
