<?php

namespace App\Filament\Resources\Produks\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProdukForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kategori_id')
                    ->relationship('kategori', 'nama_kategori')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Kategori Barang'),

                Select::make('tipe_size')
                    ->options([
                        'normal' => 'Normal',
                        'jumbo' => 'Jumbo',
                    ])
                    ->required()
                    ->default('normal')
                    ->label('Tipe Ukuran'),

                TextInput::make('nama_barang')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Produk'),

                TextInput::make('stok_saat_ini')
                    ->required()
                    ->numeric()
                    ->label('Stok Fisik'),

                TextInput::make('harga_modal')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Harga Modal'),

                TextInput::make('harga_bandrol')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Harga Jual'),

                FileUpload::make('gambar')
                    ->image()
                    ->directory('produk')
                    ->visibility('public')
                    ->columnSpanFull()
                    ->label('Foto Produk'),
            ]);
    }
}