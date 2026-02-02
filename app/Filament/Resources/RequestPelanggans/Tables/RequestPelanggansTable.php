<?php

namespace App\Filament\Resources\RequestPelanggans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RequestPelanggansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('pengguna.nama')
                    ->label('Dicatat oleh')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nama_barang_dicari')
                    ->searchable(),
                TextColumn::make('jumlah_pencari')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'menunggu' => 'gray',
                        'proses' => 'warning',
                        'sudah_restock' => 'success',
                        'diabaikan' => 'danger',
                        default => 'info',
                    }),
                TextColumn::make('tanggal_request')
                    ->date()
                    ->sortable(),
                TextColumn::make('catatan')
                    ->label('Catatan')
                    ->searchable()
                    ->limit(9)
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
