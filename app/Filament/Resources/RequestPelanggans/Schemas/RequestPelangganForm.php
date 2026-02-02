<?php

namespace App\Filament\Resources\RequestPelanggans\Schemas;

use App\Models\Pengguna;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;

class RequestPelangganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('pengguna_id')
                    ->label('Dicatat oleh')
                    ->relationship('pengguna', 'nama')
                    ->searchable()
                    ->preload()
                    ->default(fn() => auth()->id()),
                TextInput::make('nama_barang_dicari')
                    ->required(),
                TextInput::make('jumlah_pencari')
                    ->required()
                    ->numeric()
                    ->default(1),
                Select::make('status')
                    ->options(['menunggu' => 'Menunggu', 'proses' => 'Proses', 'sudah_restock' => 'Sudah restock', 'diabaikan' => 'Diabaikan'])
                    ->default('menunggu')
                    ->required(),
                DatePicker::make('tanggal_request'),
                Textarea::make('catatan')
                    ->label('Catatan')
                    ->placeholder('Nomor telepon atau nama pelanggan')
                    ->rows(2),
            ]);
    }
}
