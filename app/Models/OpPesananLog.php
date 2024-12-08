<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpPesananLog extends Model
{
    use HasFactory;

    protected $table = 'op_pemesanan_log';

    protected $fillable = ['nomor_transaksi', 'status_log', 'keterangan_log', 'id_user', 'id_cabang'];
}
