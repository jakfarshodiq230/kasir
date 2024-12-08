<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpPesananDetail extends Model
{
    use HasFactory;

    protected $table = 'op_pemesanan_detail';

    protected $fillable = ['nomor_transaksi', 'id_barang', 'id_cabang', 'id_user', 'kode_produk', 'harga_barang', 'jumlah_barang', 'sub_total_transaksi'];

    public function pesanan()
    {
        return $this->belongsTo(OpPesanan::class, 'nomor_transaksi', 'nomor_transaksi');
    }

    public function barang()
    {
        return $this->belongsTo(OpBarang::class, 'id_barang');
    }

    public function gudang()
    {
        return $this->belongsTo(OpGudang::class, 'id_gudang');
    }
}
