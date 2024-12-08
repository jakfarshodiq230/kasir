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
        Schema::create('op_barang', function (Blueprint $table) {
            $table->id();
            $table->char('kode_produk', 50);
            $table->foreignId('id_kategori')->constrained('op_kategori', 'id')->onDelete('cascade');
            $table->string('nama_produk');
            $table->text('keterangan_produk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('op_barang');
    }
};
