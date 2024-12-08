<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpDetailBarang extends Model
{
    use HasFactory;

    protected $table = 'op_barang_detail';

    protected $fillable = [
        'id_barang',
        'id_jenis',
        'id_type',
        'R_SPH',
        'L_SPH',
        'R_CYL',
        'L_CYL',
        'R_AXS',
        'L_AXS',
        'R_ADD',
        'L_ADD',
        'PD',
        'PD2'
    ];

    public function opBarang(): BelongsTo
    {
        return $this->belongsTo(OpBarang::class, 'id_barang');
    }

    public function jenis()
    {
        return $this->belongsTo(OpJenis::class, 'id_jenis', 'id');
    }

    public function type()
    {
        return $this->belongsTo(OpType::class, 'id_type', 'id');
    }
}
