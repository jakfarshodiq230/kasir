<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpPenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 'op_penjualan_detail';

    protected $fillable = ['nomor_transaksi', 'id_barang', 'id_user', 'id_cabang', 'kode_produk', 'harga_barang', 'jumlah_barang', 'sub_total_transaksi'];

    public function penjualan()
    {
        return $this->belongsTo(OpPenjualan::class, 'nomor_transaksi', 'nomor_transaksi');
    }

    public function barang()
    {
        return $this->belongsTo(OpBarang::class, 'id_barang');
    }
}
