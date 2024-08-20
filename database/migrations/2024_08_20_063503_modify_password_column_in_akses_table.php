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
        Schema::table('akses', function (Blueprint $table) {
              // Mengubah tipe kolom 'password' menjadi TEXT
              $table->text('password')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('akses', function (Blueprint $table) {
              // Mengembalikan tipe kolom 'password' ke VARCHAR dengan panjang default
              $table->string('password', 255)->change();
        });
    }
};
