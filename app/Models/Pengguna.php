<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengguna extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory, Notifiable, HasCustomId, SoftDeletes;

    protected $table = 'pengguna';
    public $prefix = 'USR';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'peran',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->peran, ['pemilik', 'karyawan']);
    }

    public function getRedirectRoute(): string
    {
        return $this->peran === 'karyawan' ? '/kasir' : '/admin';
    }

    public function getFilamentName(): string
    {
        return $this->nama;
    }
}