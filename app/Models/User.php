<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable implements MustVerifyEmail
{

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>a
     */
    protected $fillable = [
        'id_toko',
        'id_cabang',
        'id_gudang',
        'name',
        'email',
        'password',
        'level_user',
        'status_user'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    public function getProfilePhotoUrlAttribute(): string
    {
        // Assuming 'profile_photo' stores the file path or URL
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }

        return asset('images/user.png');
    }
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function toko(): BelongsTo
    {
        return $this->belongsTo(OpToko::class, 'id_toko');
    }

    public function cabang(): BelongsTo
    {
        return $this->belongsTo(OpCabang::class, 'id_cabang');
    }

    public function gudang(): BelongsTo
    {
        return $this->belongsTo(OpGudang::class, 'id_gudang');
    }

    public function penjualan()
    {
        return $this->hasMany(OpPenjualan::class, 'id_user');
    }

    public function kas()
    {
        return $this->hasMany(OpKas::class, 'id_user');
    }
}
