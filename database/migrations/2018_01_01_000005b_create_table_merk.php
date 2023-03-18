<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMerk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merk', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 50);
            $table->text('keterangan');
            $table->timestamps();
        });
        Schema::table('produk', function(Blueprint $table) {
            $table->foreign('id_merk')
                ->references('id')
                ->on('merk')
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
        Schema::table('produk', function(Blueprint $table) {
            $table->dropForeign('produk_id_merk_foreign');
        });
        Schema::drop('merk');
    }
}
