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
        $sheet->getStyle('A1:M1')->applyFromArray($headerStyle);

        $query = $this->query ?? Transaksi::query();
        $transaksis = $query->with(['pengguna', 'details.produk'])->get();

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
            $dataStyle = [
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ];
            $sheet->getStyle('A2:M' . $lastRow)->applyFromArray($dataStyle);

           
            $sheet->getStyle('G2:M' . $lastRow)->getNumberFormat()
                ->setFormatCode('#,##0');
        }

        foreach (range('A', 'M') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }
}