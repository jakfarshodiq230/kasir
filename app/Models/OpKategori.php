<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpKategori extends Model
{
    use HasFactory;

    protected $table = 'op_kategori';

    protected $fillable = ['nama_kategori', 'status', 'pesanan'];

    public function barang()
    {
        return $this->hasMany(OpBarang::class, 'id_kategori');
    }
}
