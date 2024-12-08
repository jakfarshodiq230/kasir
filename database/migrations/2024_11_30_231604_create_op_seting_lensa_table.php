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
        Schema::create('op_seting_lensa', function (Blueprint $table) {
            $table->id();
            $table->string('sph_dari', 10);
            $table->string('sph_sampai', 10);
            $table->string('cyl_dari', 10);
            $table->string('cyl_sampai', 10);
            $table->string('axs_dari', 10);
            $table->string('axs_sampai', 10);
            $table->string('add_dari', 10);
            $table->string('add_sampai', 10);
            $table->timestamps();
        });

        DB::table('op_seting_lensa')->insert([
            'sph_dari' => '-1.00',
            'sph_sampai' => '1.00',
            'cyl_dari' => '-0.50',
            'cyl_sampai' => '0.50',
            'axs_dari' => '0',
            'axs_sampai' => '180',
            'add_dari' => '0.75',
            'add_sampai' => '3.00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('op_seting_lensa');
    }
};
