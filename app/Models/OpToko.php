<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OpToko extends Model
{
    use HasFactory;

    protected $table = 'op_toko';

    protected $fillable = ['nama_toko', 'nama_pemilik', 'phone_toko', 'email_toko', 'alamat_toko'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_toko');
    }

    public function cabangs(): HasMany
    {
        return $this->hasMany(OpCabang::class, 'id_toko');
    }
}
