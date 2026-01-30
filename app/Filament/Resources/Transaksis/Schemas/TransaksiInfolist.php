<?php

namespace App\Filament\Resources\Transaksis\Schemas;

use App\Models\Transaksi;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;

class TransaksiInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Header Transaksi')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('id')
                            ->label('No. Invoice')
                            ->weight(FontWeight::Bold)
                            ->copyable(),

                        TextEntry::make('waktu_transaksi')
                            ->dateTime('d F Y, H:i'),

                        TextEntry::make('pengguna.nama')
                            ->label('Kasir Bertugas')
                            ->icon('heroicon-m-user'),

                        TextEntry::make('metode_pembayaran')
                            ->badge()
                            ->formatStateUsing(fn(string $state): string => strtoupper($state))
                            ->color(fn(string $state): string => match ($state) {
                                'tunai' => 'success',
                                'transfer' => 'info',
                                'qris' => 'warning',
                                default => 'gray',
                            }),
                    ]),

                Section::make('Daftar Produk Dibeli')
                    ->schema([
                        RepeatableEntry::make('details')
                            ->label('')
                            ->schema([
                                TextEntry::make('produk.nama_barang')
                                    ->label('Produk')
                                    ->weight(FontWeight::Bold),

                                TextEntry::make('jumlah_beli')
                                    ->label('Qty')
                                    ->suffix(' pcs'),

                                TextEntry::make('harga_satuan_deal')
                                    ->label('Harga Satuan')
                                    ->money('IDR'),

                                TextEntry::make('nominal_diskon')
                                    ->label('Diskon')
                                    ->money('IDR')
                                    ->color('danger')
                                    ->visible(fn($state) => $state > 0),

                                TextEntry::make('subtotal')
                                    ->label('Subtotal')
                                    ->money('IDR')
                                    ->weight(FontWeight::Bold),
                            ])
                            ->columns(5),
                    ]),

                Section::make('Ringkasan Keuangan')
                    ->columns(2)
                    ->schema([
                        Group::make()
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Dibuat Pada')
                                    ->dateTime('d M Y, H:i:s'),

                                TextEntry::make('deleted_at')
                                    ->label('Dihapus Pada')
                                    ->dateTime('d M Y, H:i:s')
                                    ->color('danger')
                                    ->visible(fn(Transaksi $record): bool => $record->trashed()),
                            ]),

                        Group::make()
                            ->columns(3)
                            ->schema([
                                TextEntry::make('total_bayar')
                                    ->label('GRAND TOTAL')
                                    ->money('IDR')
                                    ->size(TextSize::Large)
                                    ->weight(FontWeight::Bold)
                                    ->color('success'),

                                TextEntry::make('bayar_diterima')
                                    ->label('Uang Diterima')
                                    ->money('IDR'),

                                TextEntry::make('kembalian')
                                    ->label('Kembalian')
                                    ->money('IDR'),
                            ]),
                    ]),
            ]);
    }
}