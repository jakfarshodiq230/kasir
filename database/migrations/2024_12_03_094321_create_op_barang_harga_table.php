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
        Schema::create('op_barang_harga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_barang')->constrained('op_barang')->onDelete('cascade');
            $table->decimal('harga_modal', 10, 2);
            $table->decimal('harga_jual', 10, 2);
            $table->decimal('harga_grosir_1', 10, 2);
            $table->decimal('harga_grosir_2', 10, 2);
            $table->decimal('harga_grosir_3', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('op_barang_harga');
    }
};
