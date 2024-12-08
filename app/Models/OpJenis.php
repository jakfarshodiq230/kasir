<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpJenis extends Model
{
    use HasFactory;

    protected $table = 'op_jenis';

    protected $fillable = ['jenis', 'status_jenis'];
}
