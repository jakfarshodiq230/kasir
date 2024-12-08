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
        Schema::create('op_suplaier', function (Blueprint $table) {
            $table->id();
            $table->string('nama_suplaier', 100);
            $table->string('nama_instansi_suplaier', 100);
            $table->string('kontak_suplaier', 50)->nullable();
            $table->string('alamat_suplaier', 255)->nullable();
            $table->text('keterangan_suplaier')->nullable();
            $table->enum('status_suplaier', [1, 0])->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('op_suplaier');
    }
};
