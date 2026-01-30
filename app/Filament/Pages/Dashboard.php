<?php

namespace App\Filament\Pages;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Kategori;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Dashboard extends Page
{
    protected static ?int $navigationSort = -2;

    public static function canAccess(): bool
    {
        return auth()->user()?->peran === 'pemilik';
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-home';
    }

    public function getView(): string
    {
        return 'filament.pages.dashboard';
    }

    public function getViewData(): array
    {
        Carbon::setLocale('id');
        $today = Carbon::today();

        $pendapatanBersih = Transaksi::with('details.produk')
            ->whereDate('waktu_transaksi', $today)
            ->get()
            ->sum(fn($t) => $t->profit);
        $transaksiHariIni = Transaksi::whereDate('waktu_transaksi', $today)->count();
        $produkTerjual = DetailTransaksi::whereHas('transaksi', fn($q) => $q->whereDate('waktu_transaksi', $today))->sum('jumlah_beli');

        $prediction = Cache::get('ml_prediction_data');
        $rawLabels = $prediction['chart_data']['labels'] ?? [];
        $forecastValues = $prediction['chart_data']['values'] ?? [];

        $forecastLabels = collect($rawLabels)->map(function ($label) {
            if (str_starts_with($label, 'Minggu')) {
                return $label;
            }
            try {
                return Carbon::parse($label)->translatedFormat('l, d M');
            } catch (\Exception $e) {
                return $label;
            }
        })->toArray();

        $rawRestockData = $prediction['restock_data'] ?? [];

        $stokPerKategori = Produk::join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->selectRaw('kategori.nama_kategori, SUM(produk.stok_saat_ini) as total_stok')
            ->groupBy('kategori.nama_kategori')
            ->pluck('total_stok', 'nama_kategori')
            ->toArray();

        $restockData = collect($rawRestockData)->map(function ($item) use ($stokPerKategori) {
            $stok = $stokPerKategori[$item['kategori']] ?? 0;
            $prediksi = $item['qty'];
            $selisih = $stok - $prediksi;

            if ($stok === 0) {
                $status = 'kosong';
            } elseif ($selisih < 0) {
                $status = 'kurang';
            } elseif ($selisih <= 5) {
                $status = 'pas';
            } else {
                $status = 'aman';
            }

            return [
                'kategori' => $item['kategori'],
                'prediksi' => $prediksi,
                'stok' => $stok,
                'selisih' => $selisih,
                'status' => $status,
            ];
        })->sortBy(function ($item) {
            return match ($item['status']) {
                'kosong' => 0,
                'kurang' => 1,
                'pas' => 2,
                'aman' => 3,
            };
        })->values()->toArray();

        $salesData = [];
        $salesLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $salesLabels[] = $date->translatedFormat('D, d M');
            $salesData[] = Transaksi::whereDate('waktu_transaksi', $date)->sum('total_bayar') ?? 0;
        }

        $topProducts = DetailTransaksi::select('produk_id', DB::raw('SUM(jumlah_beli) as total_qty'))
            ->with('produk')
            ->groupBy('produk_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $paymentMethods = Transaksi::select('metode_pembayaran', DB::raw('count(*) as total'))
            ->groupBy('metode_pembayaran')
            ->get();

        return compact(
            'pendapatanBersih',
            'transaksiHariIni',
            'produkTerjual',
            'forecastLabels',
            'forecastValues',
            'restockData',
            'salesLabels',
            'salesData',
            'topProducts',
            'paymentMethods'
        );
    }
}