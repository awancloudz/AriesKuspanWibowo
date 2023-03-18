<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\KategoriProduk;
use App\Profile;
class NavbarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('navbar', function($view){
        $view->with('list_kategori', KategoriProduk::lists('nama', 'id'));
        $view->with('list_toko', Profile::lists('nama', 'id'));
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
