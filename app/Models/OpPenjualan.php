<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpPenjualan extends Model
{
    use HasFactory;

    protected $table = 'op_penjualan';

    protected $fillable = [
        'nomor_transaksi',
        'nama',
        'alamat',
        'id_user',
        'id_cabang',
        'phone_transaksi',
        'diameter',
        'warna',
        'tanggal_transaksi',
        'tanggal_selesai',
        'tanggal_ambil',
        'pembayaran',
        'jenis_transaksi',
        'total_beli',
        'diskon',
        'jumlah_bayar',
        'sisa_bayar',
        'jumlah_bayar_dp',
        'jumlah_sisa_dp',
        'jumlah_lunas_dp',
        'status_penjualan'
    ];

    public function penjualanDetails()
    {
        return $this->hasMany(OpPenjualanDetail::class, 'nomor_transaksi', 'nomor_transaksi');
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
