<?php

namespace App\Filament\Resources\RequestPelanggans\Pages;

use App\Filament\Resources\RequestPelanggans\RequestPelangganResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRequestPelanggan extends CreateRecord
{
    protected static string $resource = RequestPelangganResource::class;

    public function getTitle(): string
    {
        return 'Tambah Request Pelanggan';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreateFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateFormAction()->label('Simpan');
    }

    protected function getCreateAnotherFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateAnotherFormAction()->label('Simpan & Tambah Lagi');
    }

    protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()->label('Batal');
    }
}
