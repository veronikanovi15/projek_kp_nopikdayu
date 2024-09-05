<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aksess extends Model
{
    protected $table = 'akses'; 

    // Daftar atribut yang dapat diisi secara massal
    protected $fillable = ['nama', 'url', 'username', 'password', 'keterangan'];

    public $timestamps = true;
}
