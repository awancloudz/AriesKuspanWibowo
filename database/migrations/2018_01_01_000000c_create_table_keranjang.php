<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableKeranjang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keranjang', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_users')->unsigned();
            $table->integer('id_produk')->unsigned();
            $table->integer('jumlah');
            $table->integer('diskonrp');
            $table->integer('diskon');
            $table->enum('jenis', ['pembelian','retail','grosir','kirimcabang']);
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
        Schema::drop('keranjang');
    }
}
