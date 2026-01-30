<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class CetakStrukController extends Controller
{
    public function print($id)
    {
        $transaksi = Transaksi::with(['details.produk', 'pengguna'])->withTrashed()->findOrFail($id);

        return view('cetak-struk', compact('transaksi'));
    }
}