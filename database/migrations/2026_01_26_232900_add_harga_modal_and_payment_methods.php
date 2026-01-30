<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->decimal('harga_modal', 12, 0)->nullable()->after('harga_satuan_deal');
        });

        DB::statement("ALTER TABLE transaksi MODIFY COLUMN metode_pembayaran ENUM('tunai', 'transfer', 'qris', 'transfer_bca', 'transfer_bri', 'transfer_mandiri')");

        DB::statement("UPDATE transaksi SET metode_pembayaran = 'transfer_bca' WHERE metode_pembayaran = 'transfer'");

        DB::statement("
            UPDATE detail_transaksi dt
            JOIN produk p ON dt.produk_id = p.id
            SET dt.harga_modal = p.harga_modal
            WHERE dt.harga_modal IS NULL
        ");
    }

    public function down(): void
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->dropColumn('harga_modal');
        });

        DB::statement("ALTER TABLE transaksi MODIFY COLUMN metode_pembayaran ENUM('tunai', 'transfer', 'qris')");
    }
};
