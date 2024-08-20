<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_kunjungans', function (Blueprint $table) {
            $table->bigIncrements('kun_id'); // membuat kolom 'kun_id' sebagai primary key auto-increment
            $table->date('tanggal_kunjungan');
            $table->string('pengunjung');
            $table->string('kota_asal');
            $table->string('penerima');
            $table->string('gambar')->nullable(); // Default NULL
            $table->timestamps(); //  membuat kolom 'created_at' dan 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_kunjungans');
    }
};
