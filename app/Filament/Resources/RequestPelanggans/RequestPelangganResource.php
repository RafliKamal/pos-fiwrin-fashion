<?php

namespace App\Filament\Resources\RequestPelanggans;

use App\Filament\Resources\RequestPelanggans\Pages\CreateRequestPelanggan;
use App\Filament\Resources\RequestPelanggans\Pages\EditRequestPelanggan;
use App\Filament\Resources\RequestPelanggans\Pages\ListRequestPelanggans;
use App\Filament\Resources\RequestPelanggans\Schemas\RequestPelangganForm;
use App\Filament\Resources\RequestPelanggans\Tables\RequestPelanggansTable;
use App\Models\RequestPelanggan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RequestPelangganResource extends Resource
{
    protected static ?string $model = RequestPelanggan::class;

    protected static ?string $navigationLabel = 'Request Pelanggan';
    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Request Pelanggan';
    protected static ?string $pluralModelLabel = 'Request Pelanggan';

    protected static ?string $breadcrumb = null;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'nama_barang_dicari';

    public static function getNavigationGroup(): ?string
    {
        return 'Penjualan';
    }

    public static function form(Schema $schema): Schema
    {
        return RequestPelangganForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RequestPelanggansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRequestPelanggans::route('/'),
            'create' => CreateRequestPelanggan::route('/create'),
            'edit' => EditRequestPelanggan::route('/{record}/edit'),
        ];
    }
}
