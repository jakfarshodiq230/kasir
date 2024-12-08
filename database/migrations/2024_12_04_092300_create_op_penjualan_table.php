<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('op_penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_transaksi')->unique();
            $table->string('nama');
            $table->text('alamat')->nullable();
            $table->unsignedBigInteger('id_user');
            $table->string('phone_transaksi')->nullable();
            $table->integer('diameter')->nullable();
            $table->string('warna')->nullable();
            $table->date('tanggal_transaksi');
            $table->date('tanggal_selesai')->nullable();
            $table->date('tanggal_ambil')->nullable();
            $table->string('pembayaran');
            $table->string('jenis_transaksi');
            $table->decimal('total_beli', 15, 0);
            $table->decimal('diskon', 15, 2)->nullable();
            $table->decimal('jumlah_bayar', 15, 0);
            $table->decimal('sisa_bayar', 15, 0)->nullable();
            $table->decimal('jumlah_bayar_dp', 15, 0)->nullable();
            $table->decimal('jumlah_sisa_dp', 15, 0)->nullable();
            $table->decimal('jumlah_lunas_dp', 15, 0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('op_penjualan');
    }
};
