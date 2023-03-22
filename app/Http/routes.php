<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Requested-With, x-csrf-token');

Route::get('landingpage', 'HomePageController@index');
//Validator
Route::group(['middleware' => ['web']], function(){
    //Controller Untuk Cek Login
    Route::auth();
    Route::get('/', 'HomeController@index');
    Route::resource('user','UserController');
    //Customer
    Route::get('customer/cari','CustomerController@cari');
    Route::resource('customer','CustomerController');
    //Distributor
    Route::get('distributor/cari','DistributorController@cari');
    Route::resource('distributor','DistributorController');
    //Kategori
    Route::get('kategoriproduk/cari','KategoriprodukController@cari');
    Route::resource('kategoriproduk','KategoriprodukController');
    //Merk
    Route::get('merk/cetakharga/{idmerk}',[
    'uses' => 'MerkController@getPdf',
    'as' => 'merk.print',
    ]);
    Route::get('merk/cari','MerkController@cari');
    Route::resource('merk','MerkController');
    //Produk
    Route::get('produk/cetakharga/',[
    'uses' => 'ProdukController@getPdf',
    'as' => 'produk.print',
    ]);
    Route::get('produk/cetakbarcode/{id}',[
    'uses' => 'ProdukController@getPdf2',
    'as' => 'produk.printbarcode',
    ]);
    Route::get('produk/cari','ProdukController@cari');
    Route::get('produk/caribarcode','ProdukController@caribarcode');
    Route::get('produk/create/{cat}','ProdukController@input');
    Route::resource('produk','ProdukController');
    Route::get('kategori/{cat}',[
    'uses' => 'ProdukController@kategori',
    'as'   => 'kategori'
    ]);
    Route::post('importExcel', 'ProdukController@importExcel');
    Route::get('produk/history/{idproduk}','ProdukController@history');
    //Transaksi
    Route::post('transaksi/editinvoice','TransaksiPenjualanController@editinvoice');
    Route::post('transaksi/cari','TransaksiPenjualanController@cari');
    Route::post('transaksi/caribarcode','TransaksiPenjualanController@caribarcode');
    Route::get('transaksi/cari2','TransaksiPenjualanController@cari2');
    Route::get('transaksi/caribarcode2','TransaksiPenjualanController@caribarcode2');
    Route::get('transaksi/item/{idproduk}/jenis/{jenis}','TransaksiPenjualanController@inputkeranjang');
    Route::get('transaksi/item2/{idproduk}/jenis/{jenis}','TransaksiPenjualanController@inputkeranjang2');
    Route::get('transaksi/lunas/{idtransaksi}','TransaksiPenjualanController@lunas');
    Route::get('transaksi/check/{idtransaksi}','TransaksiPenjualanController@checkgudang');
    Route::get('transaksi/ready/{iddetail}/status/{status}','TransaksiPenjualanController@ready');
    Route::get('transaksi/verifikasi/{idtransaksi}','TransaksiPenjualanController@verifikasistok');
    Route::get('transaksi/verifikasijson/{idtransaksi}','TransaksiPenjualanController@verifikasijson');
    Route::get('transaksi/verifikasitransaksijson/{idtransaksi}','TransaksiPenjualanController@verifikasitransaksijson');
    Route::get('transaksi/history/{idtransaksi}','TransaksiPenjualanController@history');
    Route::put('transaksi/keranjang','TransaksiPenjualanController@updatekeranjang');
    Route::put('transaksi/view/updatepembelian','TransaksiPenjualanController@updatepembelian');
    Route::get('transaksi/create/{jenis}','TransaksiPenjualanController@createkeranjang');
    Route::get('transaksi/keranjangjson/{jenis}/iduser/{iduser}','TransaksiPenjualanController@keranjangjson');
    Route::get('transaksi/view/{transaksi}','TransaksiPenjualanController@viewtransaksi');
    Route::delete('transaksi/keranjang/{item}', 'TransaksiPenjualanController@hapusitemkeranjang');
    Route::get('transaksi/strukharian/','TransaksiPenjualanController@getPdf3');
    Route::get('transaksi/migrasiharga/tgl_awal/{tgl_awal}/tgl_akhir/{tgl_akhir}','TransaksiPenjualanController@migrasiharga');
    Route::resource('transaksi','TransaksiPenjualanController');
    Route::get('transaksi/print/{transaksi}',[
    'uses' => 'TransaksiPenjualanController@getPdf',
    'as' => 'transaksi.print',
    ]);
    Route::get('transaksi/printstruk/{transaksi}',[
    'uses' => 'TransaksiPenjualanController@getPdf2',
    'as' => 'transaksi.printstruk',
    ]);
    /*Route::get('transaksi/strukharian/',[
        'uses' => 'TransaksiPenjualanController@getPdf3',
        'as' => 'transaksi.printstrukharian',
        ]);*/
    Route::get('jenistransaksi/{jenis}',[
    'uses' => 'TransaksiPenjualanController@jenistrans',
    'as'   => 'jenistransaksi'
    ]);
    Route::delete('transaksi/cabang/{item}', 'TransaksiPenjualanController@destroy2');
    Route::delete('transaksi/batal/{item}', 'TransaksiPenjualanController@bataltransaksi');
    //Profile
    Route::resource('profile','ProfileController');
    //Laporan
    //Route::resource('laporan','LaporanController');
    Route::get('laporan/cari','LaporanController@carilaporan');
    Route::get('jenislaporan/{jenis}',[
    'uses' => 'LaporanController@jenislap',
    'as'   => 'jenislaporan'
    ]);
    Route::get('laporan/cetak/{jenis}/tgl_awal/{tgl_awal}/tgl_akhir/{tgl_akhir}/id_pengguna/{id_pengguna}/id_profile/{id_profile}',[
    'uses' => 'LaporanController@getPdf',
    'as' => 'laporan.print',
    ]);
    Route::get('laporan/cetakgrosir/{jenis}/tgl_awal/{tgl_awal}/tgl_akhir/{tgl_akhir}/id_pengguna/{id_pengguna}/id_profile/{id_profile}/id_customer/{id_customer}',[
        'uses' => 'LaporanController@getPdfGrosir',
        'as' => 'laporan.print',
        ]);
    Route::get('exportExcel/{jenis}/tgl_awal/{tgl_awal}/tgl_akhir/{tgl_akhir}/id_pengguna/{id_pengguna}/id_profile/{id_profile}',[
        'uses' => 'LaporanController@exportExcel',
        'as' => 'laporan.export',
        ]);
    //Route::get('exportExcel/{jenis}/tgl_awal/{tgl_awal}/tgl_akhir/{tgl_akhir}', 'LaporanController@exportExcel');
    
    //CABANG
    Route::get('cabang/produk/{idcabang}','CabangController@indexproduk');
    Route::get('cabang/{idcabang}/produk/{idproduk}/edit','CabangController@editproduk');
    Route::patch('produkcabang','CabangController@update');
    Route::get('cabang/transaksi/{idcabang}','CabangController@indextransaksi');

    //Update Detail penjualan
    Route::get('updatedetailpenjualan','TransaksiPenjualanController@updatedetailpenjualan');

    //Notifikasi
    Route::get('notifikasi','HomePageController@notifikasi');
    Route::get('notifikasi/read','HomePageController@notifikasiread');
});




