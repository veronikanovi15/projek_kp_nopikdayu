<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MKunjungan extends Model
{
    use HasFactory;
    // Nama tabel jika berbeda dari default
    protected $table = 'm_kunjungans';

    // Nama primary key jika tidak menggunakan 'id'
    protected $primaryKey = 'kun_id';

    // Primary key auto-increment
    public $incrementing = true;

    // Tipe primary key
    protected $keyType = 'int';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'tanggal_kunjungan',
        'pengunjung',
        'kota_asal',
        'penerima',
        'gambar'
    ];

    // Cast kolom tanggal untuk memformatnya
    protected $dates = ['tanggal_kunjungan'];

    // Opsional: jika ingin mengatur format tanggal
    protected $casts = [
        'tanggal_kunjungan' => 'date:Y-m-d',
    ];
}
