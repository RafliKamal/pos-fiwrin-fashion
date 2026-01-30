<?php

namespace App\Filament\Resources\Transaksis\Pages;

use App\Exports\TransaksiExport;
use App\Filament\Resources\Transaksis\TransaksiResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListTransaksis extends ListRecords
{
    protected static string $resource = TransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label('Ekspor Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    $query = $this->getFilteredTableQuery();
                    $filename = $this->generateExportFilename();
                    $exporter = new TransaksiExport($query);
                    return $exporter->download($filename);
                }),
        ];
    }

    protected function generateExportFilename(): string
    {
        $filters = $this->tableFilters ?? [];

        $tahun = $filters['tahun']['value'] ?? null;
        $bulan = $filters['bulan']['value'] ?? null;

        $namaBulan = [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        $parts = ['Data Transaksi'];

        if ($bulan && isset($namaBulan[$bulan])) {
            $parts[] = 'Bulan ' . $namaBulan[$bulan];
        }

        if ($tahun) {
            $parts[] = $tahun;
        }

        $filename = implode(' ', $parts);

        return $filename . '.xlsx';
    }
}