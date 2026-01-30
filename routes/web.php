<?php

use App\Http\Controllers\KasirController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CetakStrukController;

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/admin/login');
})->name('logout');


Route::middleware(['auth'])->get('/transaksi/{id}/print', [CetakStrukController::class, 'print'])->name('cetak.struk');