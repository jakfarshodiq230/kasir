<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpTransaksiDetail extends Model
{
    use HasFactory;

    protected $table = 'op_transaksi_detail';

    protected $fillable = ['id_transaksi', 'nomor_transaksi', 'id_barang', 'id_cabang', 'id_user', 'id_gudang', 'kode_produk', 'harga_barang', 'jumlah_barang', 'sub_total_transaksi', 'pemesanan', 'status_pemesanan'];

    public function transaksi()
    {
        return $this->belongsTo(OpTransaksi::class, 'id_transaksi', 'id');
    }

    public function barang()
    {
        return $this->belongsTo(OpBarang::class, 'id_barang');
    }

    public function gudang()
    {
        return $this->belongsTo(OpGudang::class, 'id_gudang');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function cabang()
    {
        return $this->belongsTo(OpCabang::class, 'id_cabang');
    }
}
