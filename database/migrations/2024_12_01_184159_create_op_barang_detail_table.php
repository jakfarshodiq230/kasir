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
        Schema::create('op_barang_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_barang');
            $table->unsignedBigInteger('id_jenis'); // Match the data type
            $table->unsignedBigInteger('id_type');
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
        Schema::dropIfExists('op_barang_detail');
    }
};
