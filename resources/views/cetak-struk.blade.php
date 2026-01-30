<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $transaksi->id }}</title>
    <style>
        @media print {
            @page {
                margin: 0;
                size: auto;
            }

            body {
                margin: 0;
                padding: 0;
            }
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            color: #000;
            background-color: #fff;
            line-height: 1.2;
        }

        .struk-wrapper {
            width: 58mm;
            padding: 10px 5px;
            margin: 0 auto;
            box-sizing: border-box;
        }

        .store-header {
            text-align: center;
            font-family: sans-serif;
            margin-bottom: 10px;
        }

        .store-name {
            font-size: 16px;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 4px;
            letter-spacing: 1px;
        }

        .store-info {
            font-size: 10px;
            color: #333;
        }

        .fw-bold {
            font-weight: bold;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-center {
            text-align: center;
        }

        .divider {
            border-bottom: 1px dashed #000;
            margin: 8px 0;
            width: 100%;
            display: block;
        }

        .divider-bold {
            border-bottom: 2px solid #000;
            margin: 8px 0;
        }

        .flex-row {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .item-row {
            margin-bottom: 6px;
        }

        .item-name {
            font-weight: bold;
            margin-bottom: 2px;
        }

        .info-table {
            width: 100%;
            font-size: 11px;
        }

        .info-table td {
            vertical-align: top;
            padding-bottom: 3px;
        }

        .label-col {
            width: 60px;
            white-space: nowrap;
        }

        .colon-col {
            width: 10px;
            text-align: center;
        }

        .total-section {
            font-size: 14px;
            font-weight: bold;
            margin: 5px 0;
        }

        .footer {
            margin-top: 15px;
            font-size: 9px;
            text-align: center;
            font-style: italic;
        }

        .bottom-id {
            text-align: center;
            margin: 10px 0;
            font-size: 10px;
        }
    </style>
</head>

<body onload="window.print()">

    <div class="struk-wrapper">

        <div class="store-header">
            <div class="store-name">FIWRIN FASHION</div>
            <div class="store-info">Jl. Contoh No. 123, Kota Bandung</div>
            <div class="store-info">Telp: 0812-3456-7890</div>
        </div>

        <div class="divider"></div>

        <table class="info-table" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="label-col">Tanggal</td>
                <td class="colon-col">:</td>
                <td>
                    {{ date('d/m/Y', strtotime($transaksi->waktu_transaksi)) }}
                    {{ date('H:i', strtotime($transaksi->waktu_transaksi)) }}
                </td>
            </tr>
            <tr>
                <td class="label-col">Kasir</td>
                <td class="colon-col">:</td>
                <td>{{ \Illuminate\Support\Str::limit($transaksi->pengguna->name ?? $transaksi->pengguna->nama ?? 'Admin', 15) }}
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        @foreach($transaksi->details as $detail)
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
            <span>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
        </div>

        <div class="flex-row" style="margin-top: 2px;">
            <span>Bayar ({{ strtoupper($transaksi->metode_pembayaran) }})</span>
            <span>Rp {{ number_format($transaksi->bayar_diterima, 0, ',', '.') }}</span>
        </div>

        <div class="flex-row" style="margin-top: 2px;">
            <span>Kembali</span>
            <span>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
        </div>

        <div class="divider"></div>

        <div class="bottom-id">
            <div>NO. REF / ID TRANSAKSI:</div>
            <div class="fw-bold" style="font-size: 12px; letter-spacing: 0.5px; margin-top: 2px;">
                {{ $transaksi->id }}
            </div>
        </div>

        <div class="footer">
            <div>*** TERIMA KASIH ***</div>
            <div style="margin-top: 5px;">Barang yang sudah dibeli</div>
            <div>tidak dapat ditukar/dikembalikan</div>
        </div>

    </div>

</body>

</html>