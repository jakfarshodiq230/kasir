<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpKas extends Model
{
    use HasFactory;

    protected $table = 'op_kas';

    protected $fillable = ['id_user', 'id_cabang', 'kode_transaksi', 'tanggal', 'keterangan', 'debit', 'kredit', 'saldo'];

    public function cabang()
    {
        return $this->belongsTo(OpCabang::class, 'id_cabang');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
