<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpSession extends Model
{
    use HasFactory;

    protected $table = 'sessions';

    protected $fillable = ['user_id', 'ip_address', 'user_agent', 'payload', 'last_activity'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
