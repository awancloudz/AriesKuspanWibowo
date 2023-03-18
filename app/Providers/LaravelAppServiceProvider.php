<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Request;

class LaravelAppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //MASTER
        $halaman = '';
        if(Request::segment(1) == 'customer'){
            $halaman = 'customer';
        }
        if(Request::segment(1) == 'distributor'){
            $halaman = 'distributor';
        }
        if(Request::segment(1) == 'kategoriproduk'){
            $halaman = 'kategoriproduk';
        }
        if(Request::segment(1) == 'merk'){
            $halaman = 'merk';
        }
        if(Request::segment(1) == 'produk'){
            $halaman = 'produk';
        }

        //TRANSAKSI
        if(Request::segment(1) == 'transaksi'){
            $halaman = 'transaksi';
        }
        if((Request::segment(1) == 'jenistransaksi') && (Request::segment(2) == 'pembelian')){
            $halaman = 'pembelian';
        }
        if((Request::segment(1) == 'jenistransaksi') && (Request::segment(2) == 'retail')){
            $halaman = 'retail';
        }
        if((Request::segment(1) == 'jenistransaksi') && (Request::segment(2) == 'grosir')){
            $halaman = 'grosir';
        }

        //LAPORAN
        if((Request::segment(1) == 'jenislaporan') && (Request::segment(2) == 'semua')){
            $halaman = 'semua';
        }
        if((Request::segment(1) == 'jenislaporan') && (Request::segment(2) == 'pembelian')){
            $halaman = 'pembelian';
        }
        if((Request::segment(1) == 'jenislaporan') && (Request::segment(2) == 'retail')){
            $halaman = 'retail';
        }
        if((Request::segment(1) == 'jenislaporan') && (Request::segment(2) == 'grosir')){
            $halaman = 'grosir';
        }
        if((Request::segment(1) == 'jenislaporan') && (Request::segment(2) == 'labarugi')){
            $halaman = 'labarugi';
        }
        if((Request::segment(1) == 'jenislaporan') && (Request::segment(2) == 'produk')){
            $halaman = 'produk';
        }
        
        //PENGATURAN
        if(Request::segment(1) == 'user'){
            $halaman = 'user';
        }
        if(Request::segment(1) == 'profile'){
            $halaman = 'profile';
        }
        view()->share('halaman', $halaman);
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
