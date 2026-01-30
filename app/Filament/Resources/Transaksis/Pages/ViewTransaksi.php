<?php

namespace App\Filament\Resources\Transaksis\Pages;

use App\Filament\Resources\Transaksis\TransaksiResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTransaksi extends ViewRecord
{
    protected static string $resource = TransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('cetak_struk')
                ->label('Cetak Struk')
                ->icon('heroicon-o-printer')
                ->url(fn($record) => route('cetak.struk', $record->id))
                ->openUrlInNewTab(),
        ];
    }
}