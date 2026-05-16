<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenPdf extends Model
{
    protected $table = 'dokumen_pdf';

    protected $fillable = ['nama', 'file_path', 'ukuran', 'deskripsi'];

    public function getUkuranFormatAttribute(): string
    {
        $bytes = $this->ukuran ?? 0;
        if ($bytes >= 1048576) return round($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024)    return round($bytes / 1024, 1)    . ' KB';
        return $bytes . ' B';
    }
}
