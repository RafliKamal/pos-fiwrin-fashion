<?php

namespace App\Livewire;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;

class KasirComponent extends Component
{
    public $search = '';
    public $kategori_id = null;
    public $tipe_size = null;
    public $cart = [];

    public $uang_diterima = null;
    public $metode_pembayaran = 'tunai';
    public $totalBayar = 0;

    public $editingItemId = null;
    public $editingHargaBaru = 0;
    public $editingNamaBarang = '';

    public $lastTransactionId = null;

    public $products = [];
    public $categories = [];

    public function mount()
    {
        $this->loadData();
    }

    public function updatedSearch()
    {
        $this->loadProductsOnly();
    }

    public function updatedTipeSize()
    {
        $this->loadProductsOnly();
    }

    public function loadData()
    {
        $this->categories = Kategori::whereHas('produk', function ($query) {
            $query->where('stok_saat_ini', '>', 0);
        })->orderBy('nama_kategori', 'asc')->get();

        $this->loadProductsOnly();
    }

    public function loadProductsOnly()
    {
        $query = Produk::query();

        $query->where('stok_saat_ini', '>', 0);

        if ($this->search) {
            $query->where('nama_barang', 'like', '%' . $this->search . '%');
        }

        if ($this->kategori_id) {
            $query->where('kategori_id', $this->kategori_id);
        }

        if ($this->tipe_size) {
            $query->where('tipe_size', $this->tipe_size);
        }

        $this->products = $query->orderBy('nama_barang', 'asc')->get();
    }

    public function filterKategori($id)
    {
        $this->kategori_id = $id;
        $this->loadProductsOnly();
    }

    public function filterTipeSize($size)
    {
        $this->tipe_size = $size;
        $this->loadProductsOnly();
    }

    public function getKembalianProperty()
    {
        return (int) $this->uang_diterima - $this->totalBayar;
    }

    public function getLastTransactionProperty()
    {
        if (!$this->lastTransactionId)
            return null;
        return Transaksi::with(['details.produk', 'pengguna'])->find($this->lastTransactionId);
    }

    public function updatedMetodePembayaran()
    {
        $currentTotal = collect($this->cart)->sum('subtotal');

        if ($this->metode_pembayaran !== 'tunai') {
            $this->uang_diterima = $currentTotal;
        } else {
            $this->uang_diterima = null;
        }
    }

    public function setUangPas()
    {
        $this->uang_diterima = collect($this->cart)->sum('subtotal');
    }

    public function addToCart($productId)
    {
        $produk = Produk::find($productId);
        if (!$produk)
            return;

        if ($produk->stok_saat_ini < 1) {
            $this->notifikasiStokHabis($produk->nama_barang);
            return;
        }

        if (isset($this->cart[$productId])) {
            if ($this->cart[$productId]['qty'] + 1 > $produk->stok_saat_ini) {
                $this->notifikasiStokHabis($produk->nama_barang);
                return;
            }
            $this->cart[$productId]['qty']++;
        } else {
            $this->cart[$productId] = [
                'id' => $produk->id,
                'name' => $produk->nama_barang,
                'price' => $produk->harga_bandrol,
                'original_price' => $produk->harga_bandrol,
                'qty' => 1,
                'gambar' => $produk->gambar,
                'subtotal' => $produk->harga_bandrol
            ];
        }
        $this->updateSubtotal($productId);
    }

    public function updateQty($productId, $change)
    {
        if (isset($this->cart[$productId])) {
            $produk = Produk::find($productId);
            $newQty = $this->cart[$productId]['qty'] + $change;

            if ($change > 0 && $newQty > ($produk->stok_saat_ini ?? 0)) {
                $this->notifikasiStokHabis($produk->nama_barang);
                return;
            }

            if ($newQty <= 0) {
                unset($this->cart[$productId]);
            } else {
                $this->cart[$productId]['qty'] = $newQty;
                $this->updateSubtotal($productId);
            }
        }
    }

    public function updateSubtotal($productId)
    {
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['subtotal'] = $this->cart[$productId]['price'] * $this->cart[$productId]['qty'];

            if ($this->metode_pembayaran !== 'tunai') {
                $this->uang_diterima = collect($this->cart)->sum('subtotal');
            }
        }
    }

    public function editItem($productId)
    {
        if (isset($this->cart[$productId])) {
            $this->editingItemId = $productId;
            $this->editingNamaBarang = $this->cart[$productId]['name'];
            $this->editingHargaBaru = $this->cart[$productId]['price'];
            $this->dispatch('open-modal-edit');
        }
    }

    public function simpanHargaBaru()
    {
        if ($this->editingItemId && isset($this->cart[$this->editingItemId])) {
            $hargaBaru = max(0, (int) $this->editingHargaBaru);

            $this->cart[$this->editingItemId]['price'] = $hargaBaru;
            $this->updateSubtotal($this->editingItemId);

            $this->dispatch('close-modal-edit');
            $this->editingItemId = null;
        }
    }

    public function checkout()
    {
        if (empty($this->cart))
            return;

        $finalTotal = collect($this->cart)->sum('subtotal');
        $uangBayar = (int) $this->uang_diterima;

        if ($uangBayar < $finalTotal) {
            Notification::make()
                ->title('Pembayaran Gagal')
                ->body('Uang yang diterima KURANG dari total tagihan.')
                ->danger()
                ->send();
            return;
        }

        $kembalian = $uangBayar - $finalTotal;

        DB::transaction(function () use ($finalTotal, $uangBayar, $kembalian) {
            $trxId = 'TRX' . date('YmdHis') . rand(100, 999);

            $trx = Transaksi::create([
                'id' => $trxId,
                'pengguna_id' => Auth::id() ?? 'USR001',
                'waktu_transaksi' => now('Asia/Jakarta'),
                'total_bayar' => $finalTotal,
                'bayar_diterima' => $uangBayar,
                'kembalian' => $kembalian,
                'metode_pembayaran' => $this->metode_pembayaran,
            ]);

            foreach ($this->cart as $item) {
                $detailId = 'DTL' . Str::random(15);
                $selisih = $item['original_price'] - $item['price'];
                $totalDiskon = ($selisih > 0 ? $selisih : 0) * $item['qty'];

                $produk = Produk::find($item['id']);
                $hargaModal = $produk ? $produk->harga_modal : 0;

                DetailTransaksi::create([
                    'id' => $detailId,
                    'transaksi_id' => $trx->id,
                    'produk_id' => $item['id'],
                    'jumlah_beli' => $item['qty'],
                    'harga_satuan_deal' => $item['price'],
                    'harga_modal' => $hargaModal,
                    'subtotal' => $item['subtotal'],
                    'nominal_diskon' => $totalDiskon,
                ]);

                if ($produk)
                    $produk->decrement('stok_saat_ini', $item['qty']);
            }

            $this->lastTransactionId = $trx->id;
        });

        $this->cart = [];
        $this->uang_diterima = null;
        $this->metode_pembayaran = 'tunai';
        $this->totalBayar = 0;

        $this->loadData();

        Notification::make()->title('Transaksi Berhasil')->success()->send();
        $this->dispatch('trigger-print-receipt');
    }

    private function notifikasiStokHabis($namaBarang)
    {
        Notification::make()
            ->title('Stok Habis')
            ->body("Stok {$namaBarang} tidak cukup.")
            ->danger()
            ->send();
    }

    public function render()
    {
        if (!empty($this->cart)) {
            $this->totalBayar = collect($this->cart)->sum('subtotal');
        } else {
            $this->totalBayar = 0;
        }

        return view('livewire.kasir-component');
    }
}