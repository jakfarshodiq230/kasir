<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpSetingLensa extends Model
{
    use HasFactory;

    protected $table = 'op_seting_lensa';

    protected $fillable = ['sph_dari', 'sph_sampai', 'cyl_dari', 'cyl_sampai', 'axs_dari', 'axs_sampai', 'add_dari', 'add_sampai'];
}
