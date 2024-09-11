<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes; // Tambahkan trait SoftDeletes
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes; // Gunakan trait SoftDeletes

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'name',
        'email',
        'password',
        'original_password',
        'role',
    ];

    // Kolom yang disembunyikan saat serialisasi
    protected $hidden = [
        'password',
        'original_password',
        'remember_token',
    ];

    // Tentukan bahwa kolom deleted_at diatur sebagai kolom tanggal
    protected $dates = ['deleted_at'];

    // Setter untuk password (hashing)
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // Setter untuk original_password (enkripsi)
    public function setOriginalPasswordAttribute($value)
    {
        $this->attributes['original_password'] = Crypt::encryptString($value);
    }

    // Getter untuk original_password (dekripsi)
    public function getOriginalPasswordAttribute()
    {
        try {
            return Crypt::decryptString($this->attributes['original_password']);
        } catch (DecryptException $e) {
            return null;
        }
    }
}
