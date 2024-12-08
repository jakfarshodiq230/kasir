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
        Schema::create('op_barang_gudang_stock', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_barang');
            $table->unsignedBigInteger('id_suplaier')->nullable();
            $table->unsignedInteger('id_gudang');
            $table->unsignedInteger('id_user');
            $table->integer('stock_masuk')->default(0);
            $table->integer('stock_keluar')->default(0);
            $table->integer('stock_akhir')->default(0);
            $table->string('jenis_transaksi_stock')->nullable();
            $table->string('keterangan_stock_gudang');
            $table->timestamps();

            $table->foreign('id_barang')->references('id')->on('op_barang')->onDelete('cascade');
            $table->foreign('id_suplaier')->references('id')->on('op_suplaier')->onDelete('set null');
            // $table->foreign('id_gudang')->references('id')->on('op_gudang')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('op_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('op_barang_gudang_stock');
    }
};
