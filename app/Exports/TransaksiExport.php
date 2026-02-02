<?php

namespace App\Exports;

use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TransaksiExport
{
    protected ?Builder $query;

    public function __construct(?Builder $query = null)
    {
        $this->query = $query;
    }

    public function download(string $filename): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();

        // Get data
        $query = $this->query ?? Transaksi::query();
        $transaksis = $query->with(['pengguna', 'details.produk.kategori'])->get();

        // Sheet 1: Data Transaksi
        $this->createTransaksiSheet($spreadsheet, $transaksis);

        // Sheet 2: Ringkasan Pendapatan
        $this->createRingkasanSheet($spreadsheet, $transaksis);

        $writer = new Xlsx($spreadsheet);

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    protected function createTransaksiSheet(Spreadsheet $spreadsheet, $transaksis): void
    {
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Transaksi');

        // Set headers
        $headers = [
            'ID Transaksi',
            'Waktu Transaksi',
            'Kasir',
            'Metode Pembayaran',
            'Nama Barang',
            'Jumlah Beli',
            'Harga Satuan',
            'Diskon',
            'Subtotal',
            'Total Bayar',
            'Pendapatan Bersih',
            'Bayar Diterima',
            'Kembalian',
        ];

        $sheet->fromArray($headers, null, 'A1');
        $this->applyHeaderStyle($sheet, 'A1:M1');

        $row = 2;
        foreach ($transaksis as $transaksi) {
            $waktuTransaksi = $transaksi->waktu_transaksi
                ? Carbon::parse($transaksi->waktu_transaksi)->format('d/m/Y H:i')
                : '-';

            $details = $transaksi->details ?? collect();

            if ($details->isEmpty()) {
                $sheet->setCellValue('A' . $row, $transaksi->id);
                $sheet->setCellValue('B' . $row, $waktuTransaksi);
                $sheet->setCellValue('C' . $row, $transaksi->pengguna?->nama ?? '-');
                $sheet->setCellValue('D' . $row, strtoupper($transaksi->metode_pembayaran ?? '-'));
                $sheet->setCellValue('E' . $row, '-');
                $sheet->setCellValue('F' . $row, '-');
                $sheet->setCellValue('G' . $row, '-');
                $sheet->setCellValue('H' . $row, '-');
                $sheet->setCellValue('I' . $row, '-');
                $sheet->setCellValue('J' . $row, $transaksi->total_bayar);
                $sheet->setCellValue('K' . $row, $transaksi->profit);
                $sheet->setCellValue('L' . $row, $transaksi->bayar_diterima);
                $sheet->setCellValue('M' . $row, $transaksi->kembalian);
                $row++;
            } else {
                $isFirstRow = true;
                foreach ($details as $detail) {
                    $sheet->setCellValue('A' . $row, $isFirstRow ? $transaksi->id : '');
                    $sheet->setCellValue('B' . $row, $isFirstRow ? $waktuTransaksi : '');
                    $sheet->setCellValue('C' . $row, $isFirstRow ? ($transaksi->pengguna?->nama ?? '-') : '');
                    $sheet->setCellValue('D' . $row, $isFirstRow ? strtoupper($transaksi->metode_pembayaran ?? '-') : '');
                    $sheet->setCellValue('E' . $row, $detail->produk?->nama_barang ?? '-');
                    $sheet->setCellValue('F' . $row, $detail->jumlah_beli ?? 0);
                    $sheet->setCellValue('G' . $row, $detail->harga_satuan_deal ?? 0);
                    $sheet->setCellValue('H' . $row, $detail->nominal_diskon ?? 0);
                    $sheet->setCellValue('I' . $row, $detail->subtotal ?? 0);
                    $sheet->setCellValue('J' . $row, $isFirstRow ? $transaksi->total_bayar : '');
                    $sheet->setCellValue('K' . $row, $isFirstRow ? $transaksi->profit : '');
                    $sheet->setCellValue('L' . $row, $isFirstRow ? $transaksi->bayar_diterima : '');
                    $sheet->setCellValue('M' . $row, $isFirstRow ? $transaksi->kembalian : '');

                    $isFirstRow = false;
                    $row++;
                }
            }
        }

        $lastRow = $row - 1;
        if ($lastRow >= 2) {
            $this->applyDataStyle($sheet, 'A2:M' . $lastRow);
            $sheet->getStyle('G2:M' . $lastRow)->getNumberFormat()->setFormatCode('#,##0');
        }

        foreach (range('A', 'M') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    protected function createRingkasanSheet(Spreadsheet $spreadsheet, $transaksis): void
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Ringkasan Pendapatan');

        $currentRow = 1;

        // 1. Pendapatan Per Hari
        $currentRow = $this->addPendapatanPerHari($sheet, $transaksis, $currentRow);
        $currentRow += 2;

        // 2. Pendapatan Per Minggu
        $currentRow = $this->addPendapatanPerMinggu($sheet, $transaksis, $currentRow);
        $currentRow += 2;

        // 3. Pendapatan Per Bulan
        $currentRow = $this->addPendapatanPerBulan($sheet, $transaksis, $currentRow);
        $currentRow += 2;

        // 4. Pendapatan Per Tahun
        $currentRow = $this->addPendapatanPerTahun($sheet, $transaksis, $currentRow);
        $currentRow += 2;

        // 5. Produk Terjual Per Kategori (Mingguan)
        $currentRow = $this->addProdukPerKategoriMingguan($sheet, $transaksis, $currentRow);
        $currentRow += 2;

        // 6. Metode Pembayaran Per Minggu
        $currentRow = $this->addMetodePembayaranPerMinggu($sheet, $transaksis, $currentRow);
        $currentRow += 2;

        // 7. Produk Terlaris
        $this->addProdukTerlaris($sheet, $transaksis, $currentRow);

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    protected function addPendapatanPerHari($sheet, $transaksis, int $startRow): int
    {
        $sheet->setCellValue('A' . $startRow, 'PENDAPATAN PER HARI');
        $sheet->getStyle('A' . $startRow)->getFont()->setBold(true)->setSize(12);
        $startRow++;

        $headers = ['Tanggal', 'Jumlah Transaksi', 'Total Pendapatan', 'Profit'];
        $sheet->fromArray($headers, null, 'A' . $startRow);
        $this->applyHeaderStyle($sheet, 'A' . $startRow . ':D' . $startRow);
        $startRow++;

        $grouped = $transaksis->groupBy(fn($t) => Carbon::parse($t->waktu_transaksi)->format('Y-m-d'));

        foreach ($grouped->sortKeys() as $date => $items) {
            $sheet->setCellValue('A' . $startRow, Carbon::parse($date)->format('d/m/Y'));
            $sheet->setCellValue('B' . $startRow, $items->count());
            $sheet->setCellValue('C' . $startRow, $items->sum('total_bayar'));
            $sheet->setCellValue('D' . $startRow, $items->sum('profit'));
            $startRow++;
        }

        $this->applyDataStyle($sheet, 'A' . ($startRow - $grouped->count()) . ':D' . ($startRow - 1));
        $sheet->getStyle('C' . ($startRow - $grouped->count()) . ':D' . ($startRow - 1))->getNumberFormat()->setFormatCode('#,##0');

        return $startRow;
    }

    protected function addPendapatanPerMinggu($sheet, $transaksis, int $startRow): int
    {
        $sheet->setCellValue('A' . $startRow, 'PENDAPATAN PER MINGGU');
        $sheet->getStyle('A' . $startRow)->getFont()->setBold(true)->setSize(12);
        $startRow++;

        $headers = ['Minggu/Tahun', 'Jumlah Transaksi', 'Total Pendapatan', 'Profit'];
        $sheet->fromArray($headers, null, 'A' . $startRow);
        $this->applyHeaderStyle($sheet, 'A' . $startRow . ':D' . $startRow);
        $startRow++;

        $grouped = $transaksis->groupBy(fn($t) => Carbon::parse($t->waktu_transaksi)->format('W/Y'));

        foreach ($grouped->sortKeys() as $week => $items) {
            $sheet->setCellValue('A' . $startRow, 'Minggu ' . $week);
            $sheet->setCellValue('B' . $startRow, $items->count());
            $sheet->setCellValue('C' . $startRow, $items->sum('total_bayar'));
            $sheet->setCellValue('D' . $startRow, $items->sum('profit'));
            $startRow++;
        }

        if ($grouped->count() > 0) {
            $this->applyDataStyle($sheet, 'A' . ($startRow - $grouped->count()) . ':D' . ($startRow - 1));
            $sheet->getStyle('C' . ($startRow - $grouped->count()) . ':D' . ($startRow - 1))->getNumberFormat()->setFormatCode('#,##0');
        }

        return $startRow;
    }

    protected function addPendapatanPerBulan($sheet, $transaksis, int $startRow): int
    {
        $sheet->setCellValue('A' . $startRow, 'PENDAPATAN PER BULAN');
        $sheet->getStyle('A' . $startRow)->getFont()->setBold(true)->setSize(12);
        $startRow++;

        $headers = ['Bulan/Tahun', 'Jumlah Transaksi', 'Total Pendapatan', 'Profit'];
        $sheet->fromArray($headers, null, 'A' . $startRow);
        $this->applyHeaderStyle($sheet, 'A' . $startRow . ':D' . $startRow);
        $startRow++;

        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $grouped = $transaksis->groupBy(fn($t) => Carbon::parse($t->waktu_transaksi)->format('Y-m'));

        foreach ($grouped->sortKeys() as $month => $items) {
            $date = Carbon::parse($month . '-01');
            $sheet->setCellValue('A' . $startRow, $namaBulan[$date->month] . ' ' . $date->year);
            $sheet->setCellValue('B' . $startRow, $items->count());
            $sheet->setCellValue('C' . $startRow, $items->sum('total_bayar'));
            $sheet->setCellValue('D' . $startRow, $items->sum('profit'));
            $startRow++;
        }

        if ($grouped->count() > 0) {
            $this->applyDataStyle($sheet, 'A' . ($startRow - $grouped->count()) . ':D' . ($startRow - 1));
            $sheet->getStyle('C' . ($startRow - $grouped->count()) . ':D' . ($startRow - 1))->getNumberFormat()->setFormatCode('#,##0');
        }

        return $startRow;
    }

    protected function addPendapatanPerTahun($sheet, $transaksis, int $startRow): int
    {
        $sheet->setCellValue('A' . $startRow, 'PENDAPATAN PER TAHUN');
        $sheet->getStyle('A' . $startRow)->getFont()->setBold(true)->setSize(12);
        $startRow++;

        $headers = ['Tahun', 'Jumlah Transaksi', 'Total Pendapatan', 'Profit'];
        $sheet->fromArray($headers, null, 'A' . $startRow);
        $this->applyHeaderStyle($sheet, 'A' . $startRow . ':D' . $startRow);
        $startRow++;

        $grouped = $transaksis->groupBy(fn($t) => Carbon::parse($t->waktu_transaksi)->format('Y'));

        foreach ($grouped->sortKeys() as $year => $items) {
            $sheet->setCellValue('A' . $startRow, $year);
            $sheet->setCellValue('B' . $startRow, $items->count());
            $sheet->setCellValue('C' . $startRow, $items->sum('total_bayar'));
            $sheet->setCellValue('D' . $startRow, $items->sum('profit'));
            $startRow++;
        }

        if ($grouped->count() > 0) {
            $this->applyDataStyle($sheet, 'A' . ($startRow - $grouped->count()) . ':D' . ($startRow - 1));
            $sheet->getStyle('C' . ($startRow - $grouped->count()) . ':D' . ($startRow - 1))->getNumberFormat()->setFormatCode('#,##0');
        }

        return $startRow;
    }

    protected function addProdukPerKategoriMingguan($sheet, $transaksis, int $startRow): int
    {
        $sheet->setCellValue('A' . $startRow, 'PRODUK TERJUAL PER KATEGORI (MINGGUAN)');
        $sheet->getStyle('A' . $startRow)->getFont()->setBold(true)->setSize(12);
        $startRow++;

        $headers = ['Minggu/Tahun', 'Kategori', 'Jumlah Terjual', 'Total Penjualan'];
        $sheet->fromArray($headers, null, 'A' . $startRow);
        $this->applyHeaderStyle($sheet, 'A' . $startRow . ':D' . $startRow);
        $startRow++;

        $dataStartRow = $startRow;

        // Flatten details with week info
        $details = $transaksis->flatMap(function ($t) {
            $week = Carbon::parse($t->waktu_transaksi)->format('W/Y');
            return $t->details->map(fn($d) => [
                'week' => $week,
                'kategori' => $d->produk?->kategori?->nama_kategori ?? 'Tanpa Kategori',
                'jumlah' => $d->jumlah_beli ?? 0,
                'subtotal' => $d->subtotal ?? 0,
            ]);
        });

        $grouped = $details->groupBy('week')->map(fn($items) => $items->groupBy('kategori'));

        foreach ($grouped->sortKeys() as $week => $categories) {
            foreach ($categories as $kategori => $items) {
                $sheet->setCellValue('A' . $startRow, 'Minggu ' . $week);
                $sheet->setCellValue('B' . $startRow, $kategori);
                $sheet->setCellValue('C' . $startRow, $items->sum('jumlah'));
                $sheet->setCellValue('D' . $startRow, $items->sum('subtotal'));
                $startRow++;
            }
        }

        if ($startRow > $dataStartRow) {
            $this->applyDataStyle($sheet, 'A' . $dataStartRow . ':D' . ($startRow - 1));
            $sheet->getStyle('D' . $dataStartRow . ':D' . ($startRow - 1))->getNumberFormat()->setFormatCode('#,##0');
        }

        return $startRow;
    }

    protected function addMetodePembayaranPerMinggu($sheet, $transaksis, int $startRow): int
    {
        $sheet->setCellValue('A' . $startRow, 'METODE PEMBAYARAN PER MINGGU');
        $sheet->getStyle('A' . $startRow)->getFont()->setBold(true)->setSize(12);
        $startRow++;

        $headers = ['Minggu/Tahun', 'Tunai', 'Transfer BCA', 'Transfer BRI', 'Transfer Mandiri', 'QRIS', 'Total'];
        $sheet->fromArray($headers, null, 'A' . $startRow);
        $this->applyHeaderStyle($sheet, 'A' . $startRow . ':G' . $startRow);
        $startRow++;

        $dataStartRow = $startRow;

        $grouped = $transaksis->groupBy(fn($t) => Carbon::parse($t->waktu_transaksi)->format('W/Y'));

        foreach ($grouped->sortKeys() as $week => $items) {
            $tunai = $items->where('metode_pembayaran', 'tunai')->sum('total_bayar');
            $transfer_bca = $items->where('metode_pembayaran', 'transfer_bca')->sum('total_bayar');
            $transfer_bri = $items->where('metode_pembayaran', 'transfer_bri')->sum('total_bayar');
            $transfer_mandiri = $items->where('metode_pembayaran', 'transfer_mandiri')->sum('total_bayar');
            $qris = $items->where('metode_pembayaran', 'qris')->sum('total_bayar');

            $sheet->setCellValue('A' . $startRow, 'Minggu ' . $week);
            $sheet->setCellValue('B' . $startRow, $tunai);
            $sheet->setCellValue('C' . $startRow, $transfer_bca);
            $sheet->setCellValue('D' . $startRow, $transfer_bri);
            $sheet->setCellValue('E' . $startRow, $transfer_mandiri);
            $sheet->setCellValue('F' . $startRow, $qris);
            $sheet->setCellValue('G' . $startRow, $tunai + $transfer_bca + $transfer_bri + $transfer_mandiri + $qris);
            $startRow++;
        }

        if ($startRow > $dataStartRow) {
            $this->applyDataStyle($sheet, 'A' . $dataStartRow . ':G' . ($startRow - 1));
            $sheet->getStyle('B' . $dataStartRow . ':G' . ($startRow - 1))->getNumberFormat()->setFormatCode('#,##0');
        }

        return $startRow;
    }

    protected function addProdukTerlaris($sheet, $transaksis, int $startRow): int
    {
        $sheet->setCellValue('A' . $startRow, 'PRODUK TERLARIS');
        $sheet->getStyle('A' . $startRow)->getFont()->setBold(true)->setSize(12);
        $startRow++;

        $headers = ['Ranking', 'Nama Produk', 'Kategori', 'Jumlah Terjual', 'Total Penjualan'];
        $sheet->fromArray($headers, null, 'A' . $startRow);
        $this->applyHeaderStyle($sheet, 'A' . $startRow . ':E' . $startRow);
        $startRow++;

        $dataStartRow = $startRow;

        // Aggregate product sales
        $products = $transaksis->flatMap(fn($t) => $t->details)
            ->groupBy(fn($d) => $d->produk_id)
            ->map(function ($items) {
                $first = $items->first();
                return [
                    'nama' => $first->produk?->nama_barang ?? 'Produk Terhapus',
                    'kategori' => $first->produk?->kategori?->nama_kategori ?? '-',
                    'jumlah' => $items->sum('jumlah_beli'),
                    'total' => $items->sum('subtotal'),
                ];
            })
            ->sortByDesc('jumlah')
            ->values()
            ->take(20); // Top 20

        $rank = 1;
        foreach ($products as $product) {
            $sheet->setCellValue('A' . $startRow, $rank);
            $sheet->setCellValue('B' . $startRow, $product['nama']);
            $sheet->setCellValue('C' . $startRow, $product['kategori']);
            $sheet->setCellValue('D' . $startRow, $product['jumlah']);
            $sheet->setCellValue('E' . $startRow, $product['total']);
            $rank++;
            $startRow++;
        }

        if ($startRow > $dataStartRow) {
            $this->applyDataStyle($sheet, 'A' . $dataStartRow . ':E' . ($startRow - 1));
            $sheet->getStyle('E' . $dataStartRow . ':E' . ($startRow - 1))->getNumberFormat()->setFormatCode('#,##0');
        }

        return $startRow;
    }

    protected function applyHeaderStyle($sheet, string $range): void
    {
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4CAF50'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ];
        $sheet->getStyle($range)->applyFromArray($headerStyle);
    }

    protected function applyDataStyle($sheet, string $range): void
    {
        $dataStyle = [
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle($range)->applyFromArray($dataStyle);
    }
}