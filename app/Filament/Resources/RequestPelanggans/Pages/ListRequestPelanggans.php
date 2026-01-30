<?php

namespace App\Filament\Resources\RequestPelanggans\Pages;

use App\Filament\Resources\RequestPelanggans\RequestPelangganResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRequestPelanggans extends ListRecords
{
    protected static string $resource = RequestPelangganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambah Request Pelanggan'),
        ];
    }
}
