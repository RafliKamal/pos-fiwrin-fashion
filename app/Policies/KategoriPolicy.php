<?php

namespace App\Policies;

use App\Models\Kategori;
use App\Models\Pengguna;
use Illuminate\Auth\Access\Response;

class KategoriPolicy
{
    public function viewAny(Pengguna $user): bool
    {
        return $user->peran === 'pemilik';
    }

    public function create(Pengguna $user): bool
    {
        return $user->peran === 'pemilik';
    }

    public function update(Pengguna $user, Kategori $kategori): bool
    {
        return $user->peran === 'pemilik';
    }

    public function delete(Pengguna $user, Kategori $kategori): bool
    {
        return $user->peran === 'pemilik';
    }

    public function restore(Pengguna $pengguna, Kategori $kategori): bool
    {
        return false;
    }

    public function forceDelete(Pengguna $pengguna, Kategori $kategori): bool
    {
        return false;
    }
}
