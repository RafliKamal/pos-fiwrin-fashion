<?php

namespace App\Filament\Resources\Transaksis\Tables;

use App\Models\Transaksi;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TransaksisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('waktu_transaksi', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('pengguna_id')
                    ->searchable(),
                TextColumn::make('waktu_transaksi')
                    ->searchable()
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('total_bayar')
                    ->label('Total Bayar')
                    ->money('IDR')
                    ->sortable()
                    ->summarize(Sum::make()->money('IDR')->label('Total Pendapatan')),
                TextColumn::make('profit')
                    ->label('Pendapatan Bersih')
                    ->money('IDR')
                    ->state(fn(Transaksi $record) => $record->profit)
                    ->summarize(
                        Summarizer::make()
                            ->label('Total Laba')
                            ->using(
                                fn(\Illuminate\Database\Query\Builder $query): string =>
                                'IDR ' . number_format(
                                    Transaksi::with('details.produk')
                                        ->whereIn('id', $query->pluck('id'))
                                        ->get()
                                        ->sum(fn($t) => $t->profit),
                                    0,
                                    ',',
                                    '.'
                                )
                            )
                    ),
                TextColumn::make('metode_pembayaran')
                    ->searchable()
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('tahun')
                    ->label('Tahun')
                    ->options(function () {
                        return Transaksi::query()
                            ->selectRaw('YEAR(waktu_transaksi) as year')
                            ->distinct()
                            ->orderByDesc('year')
                            ->pluck('year', 'year')
                            ->toArray();
                    })
                    ->query(
                        fn(Builder $query, array $data) =>
                        $query->when(
                            $data['value'],
                            fn($q, $year) =>
                            $q->whereYear('waktu_transaksi', $year)
                        )
                    ),
                SelectFilter::make('bulan')
                    ->label('Bulan')
                    ->options([
                        '1' => 'Januari',
                        '2' => 'Februari',
                        '3' => 'Maret',
                        '4' => 'April',
                        '5' => 'Mei',
                        '6' => 'Juni',
                        '7' => 'Juli',
                        '8' => 'Agustus',
                        '9' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                    ])
                    ->query(
                        fn(Builder $query, array $data) =>
                        $query->when(
                            $data['value'],
                            fn($q, $month) =>
                            $q->whereMonth('waktu_transaksi', $month)
                        )
                    ),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}