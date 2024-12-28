<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpTransaksiCart extends Model
{
    use HasFactory;

    protected $table = 'op_transaksi_keranjang';

    protected $fillable = ['id_barang', 'id_cabang', 'id_user', 'id_gudang', 'kode_produk', 'pesanan', 'harga', 'jumlah_beli', 'sub_total',];

    public function barang()
    {
        return $this->belongsTo(OpBarang::class, 'id_barang');
    }

    public function gudang()
    {
        return $this->belongsTo(OpGudang::class, 'id_gudang');
    }
}
