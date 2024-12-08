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
        Schema::create('op_pemesanan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_transaksi');
            $table->string('nama');
            $table->string('alamat');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_cabang');
            $table->string('phone_transaksi');
            $table->string('diameter');
            $table->string('warna');
            $table->date('tanggal_transaksi');
            $table->date('tanggal_selesai');
            $table->date('tanggal_ambil');
            $table->string('pembayaran');
            $table->string('jenis_transaksi');
            $table->decimal('total_beli', 15, 0);
            $table->decimal('diskon', 15, 0);
            $table->decimal('jumlah_bayar', 15, 0);
            $table->decimal('sisa_bayar', 15, 0);
            $table->decimal('jumlah_bayar_dp', 15, 0);
            $table->decimal('jumlah_sisa_dp', 15, 0);
            $table->decimal('jumlah_lunas_dp', 15, 0);
            $table->string('R_SPH', 8);
            $table->string('L_SPH', 8);
            $table->string('R_CYL', 8);
            $table->string('L_CYL', 8);
            $table->string('R_AXS', 8);
            $table->string('L_AXS', 8);
            $table->string('R_ADD', 8);
            $table->string('L_ADD', 8);
            $table->string('PD', 8);
            $table->string('PD2', 8);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('op_pemesanan');
    }
};
