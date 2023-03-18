<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Distributor;
use App\Kategoriproduk;
use App\Merk;
use App\Customer;
use App\User;
use App\Profile;

class FormProdukServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('user.form', function($view){
        $view->with('list_profile', Profile::lists('nama', 'id'));
        });
        view()->composer('produk.form', function($view){
        $view->with('list_kategoriproduk', Kategoriproduk::lists('nama', 'id'));
        $view->with('list_merk', Merk::lists('nama', 'id'));
        });
        view()->composer('produk.form2', function($view){
        $view->with('list_kategoriproduk', Kategoriproduk::lists('nama', 'id'));
        $view->with('list_merk', Merk::lists('nama', 'id'));
        });
        view()->composer('transaksi.keranjang', function($view){
        $view->with('list_customer', Customer::where('id','!=',1)->where('jenis','customer')->lists('nama', 'id'));
        $view->with('list_distributor', Customer::where('id','!=',1)->where('jenis','distributor')->lists('nama', 'id'));
        $view->with('list_cabang', Profile::where('status','cabang')->lists('nama', 'id'));
        });
        view()->composer('laporan.form_pencarian_laporan', function($view){
        $view->with('list_distributor', Customer::where('id','!=',1)->where('jenis','distributor')->lists('nama', 'id'));
        $view->with('list_customer', Customer::where('id','!=',1)->where('jenis','customer')->lists('nama', 'id'));
        $view->with('list_kasir', User::where('level','kasir')->lists('name', 'id'));
        $view->with('list_kasirgrosir', User::where('level','admin')->orWhere('level','grosir')->lists('name', 'id'));
        $view->with('list_cabang', Profile::lists('nama', 'id'));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
