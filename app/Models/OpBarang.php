<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpBarang extends Model
{
    use HasFactory;

    protected $table = 'op_barang';

    protected $fillable = [
        'kode_produk',
        'id_kategori',
        'id_gudang',
        'id_user',
        'nama_produk',
        'keterangan_produk',
        'barcode',
    ];

    public function kategori()
    {
        return $this->belongsTo(OpKategori::class, 'id_kategori');
    }

    public function opBarangDetails()
    {
        return $this->hasMany(OpDetailBarang::class, 'id_barang');
    }

    public function gudang()
    {
        return $this->belongsTo(OpGudang::class, 'id_gudang');
    }

    public function stokGudang()
    {
        return $this->hasMany(OpStockGudang::class, 'id_barang');
    }

    public function harga()
    {
        return $this->hasOne(OpBarangHarga::class, 'id_barang');
    }

    public function stokCabang()
    {
        return $this->belongsTo(OpBarangCabangStock::class, 'id_barang');
    }

    public function penjualanCart()
    {
        return $this->hasMany(OpPenjualanCart::class, 'id_barang');
    }

    public function penjualandetail()
    {
        return $this->hasMany(OpPenjualanDetail::class, 'id_barang');
    }

    public function stokCabangLog()
    {
        return $this->hasMany(OpBarangCabangStockLog::class, 'id_barang');
    }
}
