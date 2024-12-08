<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpGudang extends Model
{
    use HasFactory;

    protected $table = 'op_gudang';

    protected $fillable = ['nama_gudang', 'lokasi_gudang', 'deskripsi_gudang', 'status_gudang'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_gudang');
    }

    public function OpBarang(): HasMany
    {
        return $this->HasMany(OpBarang::class, 'id_gudang');
    }
}
