<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpSuplaier extends Model
{
    use HasFactory;

    protected $table = 'op_suplaier';

    protected $fillable = ['nama_suplaier', 'nama_instansi_suplaier', 'kontak_suplaier', 'alamat_suplaier', 'keterangan_suplaier', 'status_suplaier'];

    public function stokGudang()
    {
        return $this->hasMany(OpStockGudang::class, 'id_suplaier');
    }
}
