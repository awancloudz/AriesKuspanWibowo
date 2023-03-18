<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransaksipenjualan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksipenjualan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kodepenjualan', 100)->unique();
            $table->string('noinvoice', 100)->unique();
            $table->integer('id_users')->unsigned();
            $table->integer('id_customer')->unsigned();
            $table->integer('id_profile')->unsigned();
            $table->date('tanggal');
            $table->double('totaldiskon');
            $table->double('totalbelanja');
            $table->double('subtotal');
            $table->enum('jenis', ['pembelian','retail','grosir','kirimcabang']);
            $table->enum('status', ['lunas','belum']);
            $table->enum('statusdiskon', ['ya','tidak']);
            $table->double('bayar');
            $table->double('kembali');
            $table->enum('statustoko', ['pusat','cabang']);
            $table->enum('statusorder', ['order','check','verifikasi']);
            $table->timestamps();
        });
        Schema::table('detailpenjualan', function(Blueprint $table) {
            $table->foreign('id_transaksipenjualan')
                ->references('id')
                ->on('transaksipenjualan')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('pengiriman', function(Blueprint $table) {
            $table->foreign('id_transaksipenjualan')
                ->references('id')
                ->on('transaksipenjualan')
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
        Schema::table('detailpenjualan', function(Blueprint $table) {
            $table->dropForeign('detailpenjualan_id_transaksipenjualan_foreign');
        });
        Schema::table('pengiriman', function(Blueprint $table) {
            $table->dropForeign('pengiriman_id_transaksipenjualan_foreign');
        });
        Schema::drop('transaksipenjualan');
    }
}
