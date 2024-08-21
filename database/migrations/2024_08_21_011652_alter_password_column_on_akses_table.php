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
        $table->text('password')->change(); // Mengubah kolom password menjadi tipe TEXT
    });
}

public function down()
{
    Schema::table('akses', function (Blueprint $table) {
        $table->string('password', 255)->change(); // Mengembalikan ke VARCHAR(255) jika rollback
    });
}

};
