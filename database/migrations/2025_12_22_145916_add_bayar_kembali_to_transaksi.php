<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->decimal('bayar_diterima', 15, 0)->default(0)->after('total_bayar');
            $table->decimal('kembalian', 15, 0)->default(0)->after('bayar_diterima');
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn(['bayar_diterima', 'kembalian']);
        });
    }
};
