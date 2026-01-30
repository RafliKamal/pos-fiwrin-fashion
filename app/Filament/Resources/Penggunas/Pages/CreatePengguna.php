<?php

namespace App\Filament\Resources\Penggunas\Pages;

use App\Filament\Resources\Penggunas\PenggunaResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePengguna extends CreateRecord
{
    protected static string $resource = PenggunaResource::class;

    public function getTitle(): string
    {
        return 'Tambah Pengguna';
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
