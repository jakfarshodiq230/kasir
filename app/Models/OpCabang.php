<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OpCabang extends Model
{
    use HasFactory;

    protected $table = 'op_toko_cabang';

    protected $fillable = ['nama_toko_cabang', 'alamat_cabang', 'phone_cabang', 'email_cabang', 'id_toko', 'status_cabang'];

    public function toko(): belongsTo
    {
        return $this->belongsTo(OpToko::class, 'id_toko');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_cabang');
    }

    public function penjualan()
    {
        return $this->hasMany(OpPenjualan::class, 'id_cabang'); // Foreign key: id_cabang
    }
}
