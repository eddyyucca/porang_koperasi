<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'aktif',
        'wilayah_kabupaten_id', 'wilayah_kabupaten_nama',
        'wilayah_kecamatan_id', 'wilayah_kecamatan_nama',
        'wilayah_desa_id', 'wilayah_desa_nama',
        'anggota_id', 'bumdes_id',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'aktif' => 'boolean',
        ];
    }

    // --- Role checks ---

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['superadmin', 'admin']);
    }

    public function isOperator(): bool
    {
        return in_array($this->role, ['superadmin', 'admin', 'operator']);
    }

    public function isAdminDesa(): bool
    {
        return $this->role === 'admin_desa';
    }

    public function isPetani(): bool
    {
        return $this->role === 'petani';
    }

    public function isBumdesRole(): bool
    {
        return $this->role === 'bumdes';
    }

    /** True if user can see all data (no wilayah scope) */
    public function isGlobalAccess(): bool
    {
        return in_array($this->role, ['superadmin', 'admin', 'operator']);
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'superadmin'  => 'Super Admin',
            'admin'       => 'Admin',
            'operator'    => 'Operator',
            'admin_desa'  => 'Admin Desa',
            'petani'      => 'Petani',
            'bumdes'      => 'BUMDes',
            default       => ucfirst($this->role),
        };
    }

    // --- Relationships ---

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function bumdes()
    {
        return $this->belongsTo(Bumdes::class);
    }
}
