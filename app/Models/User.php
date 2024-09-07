<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'original_password',
        'role',
    ];
    
    protected $hidden = [
        'password',
        'original_password',
        'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function setOriginalPasswordAttribute($value)
    {
        $this->attributes['original_password'] = Crypt::encryptString($value);
    }

    public function getOriginalPasswordAttribute()
    {
        try {
            return Crypt::decryptString($this->attributes['original_password']);
        } catch (DecryptException $e) {
            return null;
        }
    }
}

