<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpBarangCabangStock extends Model
{
    use HasFactory;

    protected $table = 'op_barang_cabang_stock';

    protected $fillable = ['id_barang', 'id_suplaier', 'id_gudang', 'id_toko', 'id_cabang', 'id_user', 'stock_masuk', 'stock_keluar', 'stock_akhir', 'jenis_transaksi_stock', 'keterangan_stock_cabang'];

    public function barang()
    {
        return $this->hasMany(OpBarang::class, 'id_barang');
    }

    /**
     * Relasi ke tabel Suplaier.
     * Setiap stok terkait dengan satu suplaier (opsional).
     */
    public function suplaier()
    {
        return $this->belongsTo(OpSuplaier::class, 'id_suplaier');
    }

    public function gudang()
    {
        return $this->belongsTo(OpGudang::class, 'id_gudang', 'id');
    }

    public function toko()
    {
        return $this->belongsTo(OpToko::class, 'id_toko', 'id');
    }

    public function logs()
    {
        return $this->hasMany(OpBarangCabangStockLog::class, 'id_barang');
    }
}
