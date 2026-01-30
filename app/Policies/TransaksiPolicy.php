<?php

namespace App\Policies;

use App\Models\Pengguna;
use App\Models\Transaksi;
use Illuminate\Auth\Access\Response;

class TransaksiPolicy
{
    public function viewAny(Pengguna $user): bool
    {
        return $user->peran === 'pemilik';
    }

    public function create(Pengguna $user): bool
    {
        return $user->peran === 'pemilik';
    }

    public function update(Pengguna $user, Transaksi $transaksi): bool
    {
        return $user->peran === 'pemilik';
    }

    public function delete(Pengguna $user, Transaksi $transaksi): bool
    {
        return $user->peran === 'pemilik';
    }

    public function restore(Pengguna $pengguna, Transaksi $transaksi): bool
    {
        return false;
    }

    public function forceDelete(Pengguna $pengguna, Transaksi $transaksi): bool
    {
        return false;
    }
}
