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
        Schema::create('op_penjualan_detail', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_transaksi');
            $table->unsignedBigInteger('id_barang');
            $table->decimal('harga_barang', 15, 2);
            $table->integer('jumlah_barang');
            $table->decimal('sub_total_transaksi', 15, 2);
            $table->timestamps();

            $table->foreign('nomor_transaksi')->references('nomor_transaksi')->on('penjualan')->onDelete('cascade');
            $table->foreign('id_barang')->references('id')->on('op_barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('op_penjualan_detail');
    }
};
