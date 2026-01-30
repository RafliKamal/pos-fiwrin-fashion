<?php

namespace App\Filament\Resources\Produks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use App\Models\Produk;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;

class ProduksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable(),

                ImageColumn::make('gambar')
                    ->label('Foto')
                    ->disk('public')
                    ->visibility('public')
                    ->square()
                    ->size(40)
                    ->extraImgAttributes(['style' => 'object-fit: cover; border-radius: 8px;']),

                TextColumn::make('nama_barang')
                    ->searchable()
                    ->weight('bold')
                    ->label('Nama Produk'),

                TextColumn::make('kategori.nama_kategori')
                    ->label('Kategori')
                    ->badge()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('stok_saat_ini')
                    ->numeric()
                    ->sortable()
                    ->label('Stok')
                    ->color(fn(string $state): string => $state <= 5 ? 'danger' : 'success'),

                TextColumn::make('tipe_size')
                    ->searchable()
                    ->label('Size')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'normal' => 'info',
                        'jumbo' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => ucfirst($state))
                    ->sortable(),

                TextColumn::make('harga_modal')
                    ->money('IDR')
                    ->label('Modal')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('harga_bandrol')
                    ->money('IDR')
                    ->label('Harga Jual')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
                    ->using(function (Produk $record) {
                        if ($record->details()->exists()) {
                            return $record->delete();
                        }

                        return $record->forceDelete();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}