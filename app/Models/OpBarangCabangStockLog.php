<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpBarangCabangStockLog extends Model
{
    use HasFactory;

    protected $table = 'op_barang_cabang_stock_log';

    protected $fillable = ['id_barang', 'id_suplaier', 'id_gudang', 'id_toko', 'id_cabang', 'id_user', 'stock_masuk', 'stock_keluar', 'stock_akhir', 'jenis_transaksi_stock', 'keterangan_stock_cabang'];

    public function barang()
    {
        return $this->belongsTo(OpBarang::class, 'id_barang');
    }


    public function suplaier()
    {
        return $this->belongsTo(OpSuplaier::class, 'id_suplaier');
    }
}
