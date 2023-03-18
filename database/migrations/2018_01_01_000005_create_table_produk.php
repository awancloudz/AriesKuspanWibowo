<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kodeproduk',50)->unique();
            $table->integer('id_kategoriproduk')->unsigned();
            $table->integer('id_merk')->unsigned();
            $table->string('namaproduk',50);
            $table->double('hargajual');
            $table->double('hargagrosir');
            $table->double('hargadistributor');
            $table->double('diskon');
            $table->integer('stok');
            $table->string('foto')->nullable;
            $table->timestamps();
        });
        Schema::table('keranjang', function(Blueprint $table) {
            $table->foreign('id_produk')
                ->references('id')
                ->on('produk')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('detailpenjualan', function(Blueprint $table) {
            $table->foreign('id_produk')
                ->references('id')
                ->on('produk')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('produkcabang', function(Blueprint $table) {
            $table->foreign('id_produk')
                ->references('id')
                ->on('produk')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('keranjang', function(Blueprint $table) {
            $table->dropForeign('keranjang_id_produk_foreign');
        });
        Schema::table('detailpenjualan', function(Blueprint $table) {
            $table->dropForeign('detailpenjualan_id_produk_foreign');
        });
        Schema::table('produkcabang', function(Blueprint $table) {
            $table->dropForeign('produkcabang_id_produk_foreign');
        });
        Schema::drop('produk');
    }
}
