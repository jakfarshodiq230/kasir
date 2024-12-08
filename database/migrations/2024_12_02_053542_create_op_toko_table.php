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
        Schema::create('op_toko', function (Blueprint $table) {
            $table->id();
            $table->string('nama_toko', 100);
            $table->string('nama_pemilik', 100);
            $table->string('phone_toko', 15)->nullable();
            $table->string('email_toko', 100)->unique();
            $table->text('alamat_toko')->nullable();
            $table->timestamps();
        });

        DB::table('op_toko')->insert([
            'nama_toko' => 'Optik',
            'nama_pemilik' => 'John Doe',
            'phone_toko' => '123456789',
            'email_toko' => 'johndoe@example.com',
            'alamat_toko' => '123 Main Street, Springfield',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('op_toko');
    }
};
