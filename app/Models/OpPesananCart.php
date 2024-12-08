<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpPesananCart extends Model
{
    use HasFactory;

    protected $table = 'op_pemesanan_cart';

    protected $fillable = ['id_barang', 'id_cabang', 'id_user', 'kode_produk', 'harga', 'jumlah_beli', 'sub_total'];

    public function barang()
    {
        return $this->belongsTo(OpBarang::class, 'id_barang');
    }
}
