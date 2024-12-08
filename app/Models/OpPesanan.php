<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpPesanan extends Model
{
    use HasFactory;

    protected $table = 'op_pemesanan';

    protected $fillable = [
        'nomor_transaksi',
        'nama',
        'alamat',
        'id_user',
        'id_cabang',
        'id_gudang',
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
        'R_SPH',
        'L_SPH',
        'R_CYL',
        'L_CYL',
        'R_AXS',
        'L_AXS',
        'R_ADD',
        'L_ADD',
        'PD',
        'PD2',
        'status_pemesanan',
    ];

    public function pemesanandetail()
    {
        return $this->hasMany(OpPesananDetail::class, 'nomor_transaksi', 'nomor_transaksi');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function cabang()
    {
        return $this->belongsTo(OpCabang::class, 'id_cabang');
    }

    public function gudang()
    {
        return $this->belongsTo(OpGudang::class, 'id_gudang');
    }
}
