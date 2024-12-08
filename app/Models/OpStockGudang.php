<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpStockGudang extends Model
{
    use HasFactory;

    protected $table = 'op_barang_gudang_stock';

    protected $fillable = ['id_barang', 'id_suplaier', 'id_gudang', 'id_user', 'stock_masuk', 'stock_keluar', 'stock_akhir', 'jenis_transaksi_stock', 'keterangan_stock_gudang'];

    public function barang()
    {
        return $this->belongsTo(OpBarang::class, 'id_barang');
    }

    /**
     * Relasi ke tabel Suplaier.
     * Setiap stok terkait dengan satu suplaier (opsional).
     */
    public function suplaier()
    {
        return $this->belongsTo(OpSuplaier::class, 'id_suplaier');
    }
}
