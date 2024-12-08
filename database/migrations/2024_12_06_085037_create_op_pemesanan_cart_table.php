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
        Schema::create('op_pemesanan_cart', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_barang');
            $table->unsignedBigInteger('id_cabang');
            $table->unsignedBigInteger('id_user');
            $table->string('kode_produk');
            $table->decimal('harga', 15, 0);
            $table->integer('jumlah_beli');
            $table->decimal('sub_total', 15, 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('op_pemesanan_cart');
    }
};
