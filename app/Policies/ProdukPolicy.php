<?php

namespace App\Policies;

use App\Models\Pengguna;
use App\Models\Produk;
use Illuminate\Auth\Access\Response;

class ProdukPolicy
{
    public function viewAny(Pengguna $user): bool
    {
        return $user->peran === 'pemilik';
    }

    public function create(Pengguna $user): bool
    {
        return $user->peran === 'pemilik';
    }

    public function update(Pengguna $user, Produk $produk): bool
    {
        return $user->peran === 'pemilik';
    }

    public function delete(Pengguna $user, Produk $produk): bool
    {
        return $user->peran === 'pemilik';
    }

    public function restore(Pengguna $pengguna, Produk $produk): bool
    {
        return false;
    }

    public function forceDelete(Pengguna $pengguna, Produk $produk): bool
    {
        return false;
    }
}
