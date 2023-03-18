<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_profile')->unsigned();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->enum('level', ['admin','grosir','kasir','kasircabang','gudang']);
            $table->timestamps();
        });
        Schema::table('keranjang', function(Blueprint $table) {
            $table->foreign('id_users')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('transaksipenjualan', function(Blueprint $table) {
            $table->foreign('id_users')
                ->references('id')
                ->on('users')
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
            $table->dropForeign('keranjang_id_users_foreign');
        });
        Schema::table('transaksipenjualan', function(Blueprint $table) {
            $table->dropForeign('transaksipenjualan_id_users_foreign');
        });
        Schema::drop('users');
    }
}
