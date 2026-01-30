<?php

namespace App\Filament\Resources\Penggunas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Hash;
use Filament\Schemas\Schema;

class PenggunaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Akun')
                    ->description('Lengkapi data autentikasi pengguna di bawah ini.')
                    ->schema([
                        TextInput::make('nama')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Lengkap'),

                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->label('Alamat Email'),

                        TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->required(fn(string $context): bool => $context === 'create')
                            ->dehydrated(fn($state) => filled($state))
                            ->label('Kata Sandi'),

                        Select::make('peran')
                            ->options([
                                'pemilik' => 'Pemilik (Full Access)',
                                'karyawan' => 'Karyawan (Kasir)',
                            ])
                            ->required()
                            ->native(false)
                            ->label('Hak Akses'),
                    ])->columns(2),
            ]);
    }
}