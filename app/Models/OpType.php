<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpType extends Model
{
    use HasFactory;

    protected $table = 'op_type';

    protected $fillable = ['type', 'status_type'];
}
