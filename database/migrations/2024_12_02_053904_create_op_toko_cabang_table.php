<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the table
        Schema::create('op_toko_cabang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_toko_cabang', 100);
            $table->text('alamat_cabang');
            $table->string('phone_cabang', 15)->nullable();
            $table->string('email_cabang', 100)->nullable();
            $table->unsignedBigInteger('id_toko');
            $table->enum('status_cabang', [1, 0])->default(1);
            $table->timestamps();

            $table->foreign('id_toko')->references('id')->on('op_toko')->onDelete('cascade');
        });

        // Insert the data after the table is created
        DB::table('op_toko_cabang')->insert([
            'nama_toko_cabang' => 'Main Branch',
            'alamat_cabang' => '456 Elm Street, Springfield',
            'phone_cabang' => '987654321',
            'email_cabang' => 'mainbranch@example.com',
            'id_toko' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('op_toko_cabang');
    }
};
