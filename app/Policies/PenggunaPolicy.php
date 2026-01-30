<?php

namespace App\Policies;

use App\Models\Pengguna;
use Illuminate\Auth\Access\Response;

class PenggunaPolicy
{
    public function viewAny(Pengguna $pengguna): bool
    {
        return $pengguna->peran === 'pemilik';
    }

    public function view(Pengguna $pengguna, Pengguna $targetUser): bool
    {
        return $pengguna->peran === 'pemilik';
    }

    public function create(Pengguna $pengguna): bool
    {
        return $pengguna->peran === 'pemilik';
    }

    public function update(Pengguna $pengguna, Pengguna $targetUser): bool
    {
        return $pengguna->peran === 'pemilik' || $pengguna->id === $targetUser->id;
    }

    public function delete(Pengguna $pengguna, Pengguna $targetUser): bool
    {
        return $pengguna->peran === 'pemilik' && $pengguna->id !== $targetUser->id;
    }

    public function restore(Pengguna $pengguna, Pengguna $targetUser): bool
    {
        return $pengguna->peran === 'pemilik';
    }

    public function forceDelete(Pengguna $pengguna, Pengguna $targetUser): bool
    {
        return $pengguna->peran === 'pemilik';
    }
}