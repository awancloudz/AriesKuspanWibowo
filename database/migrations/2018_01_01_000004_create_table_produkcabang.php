<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProdukcabang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produkcabang', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_profile')->unsigned();
            $table->integer('id_produk')->unsigned();
            $table->double('hargajual');
            $table->integer('stok');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('produkcabang');
    }
}
