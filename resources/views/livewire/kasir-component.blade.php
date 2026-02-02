<div class="container-fluid vh-100 p-0">
    <style>
        
        .product-img-wrapper {
            width: 100%;
            height: 180px; 
            background-color: #f8f9fa;
            position: relative;
            overflow: hidden;
        }

        .product-img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
            object-position: center;
        }

       
        .product-card .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 90px; 
        }

        .product-card .card-title {
            font-size: 1rem;
            font-weight: bold;
            color: #212529;
            margin-bottom: 8px;
            
            display: -webkit-box;
            -webkit-line-clamp: 2; 
            -webkit-box-orient: vertical;
            overflow: hidden;
            
            min-height: 1.8em; 
            line-height: 1.2em;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .cat-chip {
            transition: all 0.2s;
            background-color: #ee8358;
            color: white;
        }
        .cat-chip:hover {
            background-color: #26A69A;
            color: white;
            border-color: #26A69A;
        }
        .cat-chip.active {
            background-color: #00695C;
            color: white;
            border-color: #00695C;
        }

        .qty-btn {
            background-color: #B2DFDB;
            border-color: #B2DFDB;
            color: #00695C;
            transition: all 0.2s;
        }
        .qty-btn:hover, .qty-btn:active, .qty-btn:focus {
            background-color: #00695C !important;
            border-color: #00695C !important;
            color: white !important;
        }

        .btn-emerald {
            background-color: #00695C;
            border-color: #00695C;
            color: white;
            transition: all 0.2s;
        }
        .btn-emerald:hover, .btn-emerald:active, .btn-emerald:focus {
            background-color: #004D40 !important;
            border-color: #004D40 !important;
            color: white !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 105, 92, 0.3);
        }

        .btn-oren {
            background-color: #ee8358;
            border-color: #ee8358;
            color: white;
            transition: all 0.2s;
        }
        .btn-oren:hover, .btn-oren:active, .btn-oren:focus {
            background-color: #E64A19 !important;
            border-color: #E64A19 !important;
            color: white !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(238, 131, 88, 0.3);
        }

        
        @media print {
            body * { visibility: hidden; }
            .fi-notification, 
            .fi-notifications, 
            [wire\:id*="notifications"],
            [x-data*="notification"] { 
                display: none !important; 
                visibility: hidden !important;
            }
            #print-area, #print-area * { visibility: visible; }
            #print-area {
                position: absolute; left: 0; top: 0;
                width: 58mm; margin: 0; padding: 10px 5px;
                background-color: #fff; color: #000;
                font-family: 'Courier New', Courier, monospace;
                font-size: 11px; line-height: 1.2;
            }
            @page { size: auto; margin: 0; }
            .store-header { text-align: center; font-family: sans-serif; margin-bottom: 10px; }
            .store-name { font-size: 16px; font-weight: 900; text-transform: uppercase; margin-bottom: 4px; letter-spacing: 1px; }
            .store-info { font-size: 10px; color: #333; }
            .text-center { text-align: center; }
            .text-end { text-align: right; }
            .fw-bold { font-weight: bold; }
            .text-uppercase { text-transform: uppercase; }
            .divider { border-bottom: 1px dashed #000; margin: 8px 0; width: 100%; display: block; }
            .divider-bold { border-bottom: 2px solid #000; margin: 8px 0; }
            .flex-row { display: flex; justify-content: space-between; width: 100%; }
            .item-row { margin-bottom: 6px; }
            .item-name { font-weight: bold; margin-bottom: 2px; }
            .info-table { width: 100%; font-size: 11px; }
            .info-table td { vertical-align: top; padding-bottom: 3px; }
            .label-col { width: 60px; white-space: nowrap; }
            .colon-col { width: 10px; text-align: center; }
            .total-section { font-size: 14px; font-weight: bold; margin: 5px 0; }
            .bottom-id { text-align: center; margin: 10px 0; font-size: 10px; }
            .footer { margin-top: 15px; font-size: 9px; text-align: center; font-style: italic; }
        }
    </style>

    <div class="row g-0 h-100">

        <div class="col-md-4 col-lg-3 cart-section shadow-sm" style="background-color: #FFF8E7;">
            <div class="p-3 border-bottom z-1" style="background-color: #FFF8E7;">
                <h5 class="fw-bold mb-0" style="color: #00695C;"><i class="bi bi-cart-fill me-2"></i>Pesanan</h5>
                <small class="text-muted">{{ count($cart) }} Items</small>
            </div>

            <div class="flex-grow-1 p-3 scroll-area" style="background-color: #FFF8E7;">
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show small mb-2">
                        {{ session('success') }}
                        <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @forelse($cart as $id => $item)
                    <div class="card mb-2 border-0 shadow-sm" style="background-color: #FFEFD5;" wire:key="cart-{{ $id }}">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="overflow-hidden">
                                    <h6 class="mb-0 fw-bold text-dark text-truncate" style="max-width: 150px;">
                                        {{ $item['name'] }}
                                    </h6>
                                    @if($item['price'] < $item['original_price'])
                                        <small class="text-decoration-line-through text-muted" style="font-size: 0.75rem;">
                                            Rp {{ number_format($item['original_price'], 0, ',', '.') }}
                                        </small>
                                    @endif
                                </div>
                                <button class="btn btn-sm btn-link p-0 ms-2" style="color: #00695C;" 
                                        wire:click="editItem('{{ $id }}')" 
                                        title="Ubah Harga / Diskon">
                                    <i class="bi bi-pencil-square fs-6"></i>
                                </button>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="fw-bold" style="color: #00695C;">
                                    @ Rp {{ number_format($item['price'], 0, ',', '.') }}
                                </span>
                                
                                <div class="input-group input-group-sm" style="width: 90px;">
                                    <button class="btn qty-btn" wire:click="updateQty('{{ $id }}', -1)">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="text" class="form-control text-center px-0 bg-white fw-bold" value="{{ $item['qty'] }}" readonly>
                                    <button class="btn qty-btn" wire:click="updateQty('{{ $id }}', 1)"
                                        @php $produkDb = \App\Models\Produk::find($id); @endphp
                                        @if($item['qty'] >= ($produkDb->stok_saat_ini ?? 0)) disabled @endif>
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="text-end mt-2 pt-1 border-top border-light">
                                <span class="fw-bold text-dark">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center mt-5 text-muted opacity-50">
                        <i class="bi bi-basket display-1"></i>
                        <p class="mt-2">Keranjang Kosong</p>
                    </div>
                @endforelse
            </div>

            <div class="p-3 border-top z-1 shadow-lg" style="background-color: #FFF8E7;">
                <div class="d-flex justify-content-between mb-2">
                    <span class="h6 mb-0">Total Tagihan</span>
                    <span class="h4 mb-0 fw-bold" style="color: #00695C;">
                        Rp {{ number_format($totalBayar, 0, ',', '.') }}
                    </span>
                </div>
                
                <div class="mb-2">
                    <select wire:model.live="metode_pembayaran" class="form-select fw-bold" style="border-color: #00695C; color: #00695C;">
                        <option value="tunai">💵 Tunai (Cash)</option>
                        <option value="transfer_bca">🏦 Transfer Bank - BCA</option>
                        <option value="transfer_bri">🏦 Transfer Bank - BRI</option>
                        <option value="transfer_mandiri">🏦 Transfer Bank - Mandiri</option>
                        <option value="qris">📱 QRIS / E-Wallet</option>
                    </select>
                </div>

                <div class="input-group mb-2">
                    <span class="input-group-text bg-light border-end-0">Rp</span>
                    <input type="number" wire:model.live.debounce.500ms="uang_diterima" 
                        class="form-control border-start-0 text-end fw-bold fs-5" placeholder="0"
                        id="inputUangDiterima">
                    <button class="btn btn-emerald font-monospace" type="button" 
                            wire:click="setUangPas" title="Uang Pas">Pas</button>
                </div>

                <div class="d-flex justify-content-between mb-3 small">
                    <span class="text-muted">Kembalian:</span>
                    <span class="fw-bold {{ $this->kembalian < 0 ? 'text-danger' : 'text-success' }}">
                        Rp {{ number_format($this->kembalian, 0, ',', '.') }}
                    </span>
                </div>
                
                <button wire:click="checkout" class="btn btn-emerald w-100 py-3 fw-bold rounded-3" 
                    {{ empty($cart) ? 'disabled' : '' }}>
                    <i class="bi bi-wallet2 me-2"></i> BAYAR SEKARANG
                </button>
                
              
                    <a href="/admin/request-pelanggans" class="btn btn-link w-100 btn-sm text-decoration-none text-muted mt-1">
                        <i class="bi bi-list-check me-1"></i> Lihat Request Pelanggan
                    </a>
             
            </div>
        </div>

        <div class="col-md-8 col-lg-9 product-section" style="background-color: #FFF8E7;">
            <div class="p-3 border-bottom shadow-sm z-1" style="background-color: #FFF8E7;">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="input-group input-group-lg flex-grow-1">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" wire:model.live="search" class="form-control border-start-0 ps-0" 
                            placeholder="Cari produk...">
                    </div>

                    <select wire:model.live="tipe_size" class="form-select p-2" style="width: auto; min-width: 120px;">
                        <option value="">All Size</option>
                        <option value="normal">Normal</option>
                        <option value="jumbo">Jumbo</option>
                    </select>
                </div>
                
                <div class="d-flex gap-2 overflow-auto pb-1 hide-scrollbar" style="white-space: nowrap;">
                    <button class="btn btn-sm rounded-pill cat-chip {{ is_null($kategori_id) ? 'active' : '' }} px-4 py-2" 
                        wire:click="filterKategori(null)">Semua</button>
                    @foreach($this->categories as $kat)
                        <button class="btn btn-sm rounded-pill cat-chip {{ $kategori_id == $kat->id ? 'active' : '' }} px-4 py-2" 
                            wire:key="kat-{{ $kat->id }}"
                            wire:click="filterKategori('{{ $kat->id }}')">{{ $kat->nama_kategori }}</button>
                    @endforeach
                </div>
            </div>

            <div class="flex-grow-1 p-4 scroll-area">
                <div class="row row-cols-2 row-cols-md-4 row-cols-xl-5 row-cols-xxl-6 g-3">
                    @foreach($this->products as $produk)
                        <div class="col" wire:key="prod-{{ $produk->id }}">
                            <div class="card h-100 product-card shadow-sm border-0" wire:click="addToCart('{{ $produk->id }}')" style="cursor: pointer;">
                                <div class="product-img-wrapper position-relative">
                                    @if($produk->gambar)
                                        <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top product-img" alt="{{ $produk->nama_barang }}">
                                    @else
                                        <div class="product-img d-flex align-items-center justify-content-center text-muted bg-light">
                                            <i class="bi bi-image fs-1 opacity-25"></i>
                                        </div>
                                    @endif
                                    <span class="position-absolute top-0 start-0 badge m-2 {{ $produk->tipe_size === 'jumbo' ? 'bg-secondary text-white' : 'bg-secondary text-white' }}">
                                        {{ ucfirst($produk->tipe_size ?? 'normal') }}
                                    </span>
                                    <span class="position-absolute top-0 end-0 badge bg-dark m-2 opacity-75">
                                        Stok: {{ $produk->stok_saat_ini }}
                                    </span>
                                </div>
                                <div class="card-body p-3 text-center">
                                    <h6 class="card-title" title="{{ $produk->nama_barang }}">
                                        {{ $produk->nama_barang }}
                                    </h6>
                                    <p class="fw-bold mb-0" style="color: #00695C;">
                                        Rp {{ number_format($produk->harga_bandrol, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($this->products->isEmpty())
                    <div class="d-flex flex-column align-items-center justify-content-center h-50 text-muted">
                        <i class="bi bi-search display-1 opacity-25 mb-3"></i>
                        <h5>Produk tidak ditemukan</h5>
                        <p>Coba kata kunci lain atau kategori berbeda</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditHarga" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header py-2" style="background-color: #ee8358;">
                <h6 class="modal-title fw-bold small text-white">Ubah Harga / Diskon</h6>
                <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="background-color: #FFF8E7;">
                <div class="mb-3 text-center">
                    <small class="text-muted d-block mb-1">Nama Produk</small>
                    <span class="fw-bold text-dark">{{ $editingNamaBarang }}</span>
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold text-muted">Harga Deal</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">Rp</span>
                        <input type="number" class="form-control fw-bold text-end fs-5" style="color: #00695C;" 
                            wire:model="editingHargaBaru" 
                            wire:keydown.enter="simpanHargaBaru"
                            id="inputHargaBaru">
                    </div>
                </div>
            </div>
            <div class="modal-footer py-2" style="background-color: #FFF8E7;">
                <button type="button" class="btn btn-outline-secondary btn-sm px-3 rounded-3" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Batal
                </button>
                <button type="button" class="btn btn-oren btn-sm px-3 rounded-3" wire:click="simpanHargaBaru">
                    <i class="bi bi-check2-circle me-1"></i> Simpan
                </button>   
            </div>
        </div>
    </div>
</div>

    <div id="print-area" class="d-none d-print-block">
        @if($this->lastTransaction)
            <div class="store-header">
                <div class="store-name">FIWRIN FASHION</div>
                <div class="store-info">Balubur Town Square (Baltos)</div>
            <div class="store-info">Lantai 1 Blok X Nomor 36, Bandung</div>
                <div class="store-info">Telp: 0812-3456-7890</div>
            </div>

            <div class="divider"></div>

            <table class="info-table" border="0" cellspacing="0" cellpadding="0">
                <tr><td></td><td></td><td></td></tr>
                <tr>
                    <td class="label-col">Tanggal</td>
                    <td class="colon-col">:</td>
                    <td>
                        {{ date('d/m/Y', strtotime($this->lastTransaction->waktu_transaksi)) }} 
                        {{ date('H:i', strtotime($this->lastTransaction->waktu_transaksi)) }}
                    </td>
                </tr>
                <tr>
                    <td class="label-col">Kasir</td>
                    <td class="colon-col">:</td>
                    <td>{{ \Illuminate\Support\Str::limit($this->lastTransaction->pengguna->name ?? $this->lastTransaction->pengguna->nama ?? 'Admin', 15) }}</td>
                </tr>
            </table>

            <div class="divider"></div>

            @foreach($this->lastTransaction->details as $detail)
                <div class="item-row">
                    <div class="item-name">{{ $detail->produk->nama_barang ?? 'Item Terhapus' }}</div>
                    <div class="flex-row">
                        <span>{{ $detail->jumlah_beli }} x {{ number_format($detail->harga_satuan_deal, 0, ',', '.') }}</span>
                        <span>{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @if($detail->nominal_diskon > 0)
                        <div class="flex-row" style="font-size: 9px; font-style: italic; color: #444;">
                            <span></span>
                            <span>(Hemat: -{{ number_format($detail->nominal_diskon, 0, ',', '.') }})</span>
                        </div>
                    @endif
                </div>
            @endforeach

            <div class="divider-bold"></div>

            <div class="flex-row total-section">
                <span>TOTAL</span>
                <span>Rp {{ number_format($this->lastTransaction->total_bayar, 0, ',', '.') }}</span>
            </div>

            <div class="flex-row" style="margin-top: 5px;">
                <span>Bayar ({{ strtoupper($this->lastTransaction->metode_pembayaran) }})</span>
                <span>Rp {{ number_format($this->lastTransaction->bayar_diterima ?? $this->lastTransaction->total_bayar, 0, ',', '.') }}</span>
            </div>

            <div class="flex-row" style="margin-top: 2px;">
                <span>Kembali</span>
                <span>Rp {{ number_format($this->lastTransaction->kembalian ?? 0, 0, ',', '.') }}</span>
            </div>

            <div class="divider"></div>

            <div class="bottom-id">
                <div>NO. REF / ID TRANSAKSI:</div>
                <div class="fw-bold" style="font-size: 12px; letter-spacing: 0.5px; margin-top: 2px;">
                    {{ $this->lastTransaction->id }}
                </div>
            </div>

            <div class="footer">
                <div>*** TERIMA KASIH ***</div>
                <div style="margin-top: 5px;">Barang yang sudah dibeli</div>
                <div>tidak dapat ditukar/dikembalikan</div>
            </div>
        @endif
    </div>

<div class="mobile-tabs d-md-none" x-data="{ activeTab: 'products' }">
    <button class="tab-btn" 
            :class="{ 'active': activeTab === 'products' }"
            @click="activeTab = 'products'; 
                    document.querySelector('.cart-section').classList.remove('mobile-active');
                    document.querySelector('.product-section').classList.remove('mobile-hidden');">
        <i class="bi bi-grid-3x3-gap me-1"></i> Produk
    </button>
    <button class="tab-btn position-relative" 
            :class="{ 'active': activeTab === 'cart' }"
            @click="activeTab = 'cart';
                    document.querySelector('.cart-section').classList.add('mobile-active');
                    document.querySelector('.product-section').classList.add('mobile-hidden');">
        <i class="bi bi-cart3 me-1"></i> Keranjang
        @if(count($cart) > 0)
            <span class="position-absolute top-0 end-0 badge rounded-pill bg-danger" style="font-size: 10px; transform: translate(25%, -25%);">
                {{ count($cart) }}
            </span>
        @endif
    </button>
</div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        const modalElement = document.getElementById('modalEditHarga');
        const modal = new bootstrap.Modal(modalElement);
        const inputHarga = document.getElementById('inputHargaBaru');

        Livewire.on('open-modal-edit', () => {
            modal.show();
            setTimeout(() => { inputHarga.focus(); inputHarga.select(); }, 500);
        });
        Livewire.on('close-modal-edit', () => modal.hide());

        Livewire.on('trigger-print-receipt', () => {
            setTimeout(() => {
                window.print();
            }, 500);
        });
    });
</script>