<?php

namespace App\Policies;

use App\Models\Pengguna;
use App\Models\RequestPelanggan;
use Illuminate\Auth\Access\Response;

class RequestPelangganPolicy
{
    public function viewAny(Pengguna $pengguna): bool
    {
        return true;
    }

    public function view(Pengguna $pengguna, RequestPelanggan $requestPelanggan): bool
    {
        return true;
    }

    public function create(Pengguna $pengguna): bool
    {
        return true;
    }

    public function update(Pengguna $pengguna, RequestPelanggan $requestPelanggan): bool
    {
        return true;
    }

    public function delete(Pengguna $pengguna, RequestPelanggan $requestPelanggan): bool
    {
        return $pengguna->peran === 'pemilik';
    }

    public function restore(Pengguna $pengguna, RequestPelanggan $requestPelanggan): bool
    {
        return $pengguna->peran === 'pemilik';
    }

    public function forceDelete(Pengguna $pengguna, RequestPelanggan $requestPelanggan): bool
    {
        return $pengguna->peran === 'pemilik';
    }
}
