<?php

namespace App\Filament\Resources\Transaksis\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class TransaksiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('Informasi Utama')
                            ->schema([
                                TextInput::make('id')
                                    ->label('ID Transaksi')
                                    ->disabled()
                                    ->dehydrated(false),

                                Select::make('pengguna_id')
                                    ->label('Kasir')
                                    ->relationship('pengguna', 'nama')
                                    ->required()
                                    ->searchable()
                                    ->preload(),

                                DateTimePicker::make('waktu_transaksi')
                                    ->label('Waktu Transaksi')
                                    ->required(),

                                Select::make('metode_pembayaran')
                                    ->options([
                                        'tunai' => 'Tunai',
                                        'transfer' => 'Transfer',
                                        'qris' => 'QRIS',
                                    ])
                                    ->required(),
                            ])->columns(2),

                        Section::make('Detail Belanja')
                            ->schema([
                                Repeater::make('details')
                                    ->relationship()
                                    ->schema([
                                        Select::make('produk_id')
                                            ->label('Produk')
                                            ->relationship('produk', 'nama_barang')
                                            ->disabled(),

                                        TextInput::make('jumlah_beli')
                                            ->label('Qty')
                                            ->numeric(),

                                        TextInput::make('harga_satuan_deal')
                                            ->label('Harga Deal')
                                            ->prefix('Rp')
                                            ->numeric(),

                                        TextInput::make('subtotal')
                                            ->label('Subtotal')
                                            ->prefix('Rp')
                                            ->numeric(),
                                    ])
                                    ->columns(4)
                                    ->addable(false)
                                    ->deletable(false)
                            ]),
                    ])->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make('Total Pembayaran')
                            ->schema([
                                TextInput::make('total_bayar')
                                    ->label('GRAND TOTAL')
                                    ->prefix('Rp')
                                    ->required()
                                    ->numeric()
                                    ->extraInputAttributes(['class' => 'text-xl font-bold']),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }
}