<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpBarangHarga extends Model
{
    use HasFactory;

    protected $table = 'op_barang_harga';

    protected $fillable = [
        'id_barang',
        'harga_modal',
        'harga_jual',
        'harga_grosir_1',
        'harga_grosir_2',
        'harga_grosir_3'
    ];

    public function barang()
    {
        return $this->belongsTo(OpBarang::class, 'id_barang');
    }
}
