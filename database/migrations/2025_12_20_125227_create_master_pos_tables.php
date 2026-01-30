<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('peran', ['pemilik', 'karyawan']);
            $table->timestamps();
        });

        Schema::create('kategori', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('nama_kategori');
            $table->timestamps();
        });

        Schema::create('produk', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('kategori_id', 20);
            $table->string('nama_barang');
            $table->integer('stok_saat_ini')->default(0);
            $table->decimal('harga_modal', 12, 0);
            $table->decimal('harga_bandrol', 12, 0);
            $table->string('gambar')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
        });

        Schema::create('transaksi', function (Blueprint $table) {
            $table->string('id', 30)->primary();
            $table->string('pengguna_id', 20);
            $table->dateTime('waktu_transaksi');
            $table->decimal('total_bayar', 12, 0);
            $table->enum('metode_pembayaran', ['tunai', 'transfer', 'qris']);
            $table->timestamps();

            $table->foreign('pengguna_id')->references('id')->on('pengguna');
        });

        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->string('id', 30)->primary();
            $table->string('transaksi_id', 30);
            $table->string('produk_id', 20);
            $table->integer('jumlah_beli');
            $table->decimal('harga_satuan_deal', 12, 0);
            $table->decimal('nominal_diskon', 12, 0);
            $table->timestamps();

            $table->foreign('transaksi_id')->references('id')->on('transaksi')->onDelete('cascade');
            $table->foreign('produk_id')->references('id')->on('produk');
        });

        Schema::create('request_pelanggan', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('nama_barang_dicari');
            $table->integer('jumlah_pencari')->default(1);
            $table->enum('status', ['menunggu', 'sudah_restock', 'diabaikan'])->default('menunggu');
            $table->date('tanggal_request')->nullable();
            $table->timestamps();
        });

        Schema::create('prediksi_penjualan', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('kategori_id', 20);
            $table->date('tanggal_target');
            $table->integer('jumlah_prediksi');
            $table->enum('status_stok', ['aman', 'waspada', 'kritis']);
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('prediksi_penjualan');
        Schema::dropIfExists('request_pelanggan');
        Schema::dropIfExists('detail_transaksi');
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('produk');
        Schema::dropIfExists('kategori');
        Schema::dropIfExists('pengguna');
    }
};