<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/login', function () {
    return redirect()->route('login');
});

Route::get('/temp-fix-db', function() {
    try {
        // Double check if column exists first to avoid exception spam
        $hasColumn = \Illuminate\Support\Facades\Schema::hasColumn('tbl_stok', 'catatan');
        if (!$hasColumn) {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE tbl_stok ADD COLUMN catatan TEXT NULL AFTER status');
            return '<h1 style="color:green">SUCCESS: Column "catatan" added to tbl_stok.</h1><p>Silahkan coba lagi input stok.</p>'; 
        } else {
            return '<h1 style="color:blue">INFO: Column "catatan" already exists.</h1><p>Silahkan coba lagi input stok.</p>';
        }
    } catch (\Exception $e) {
        return '<h1 style="color:red">ERROR: ' . $e->getMessage() . '</h1>';
    }
});

Route::post('login/submit', 'Auth\LoginController@login')->name('login.submit');

Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::get('/logout', 'Auth\LoginController@logout');

// Group for Authenticated Users (Owner & Karyawan)
Route::group(['middleware' => ['auth', 'checkrole:owner,karyawan']], function () {
    Route::get('/admin', function () {
        return view('admin.index');
    });

    Route::get('/home', function () {
        return view('admin.index');
    });

    // CRUD ORDERAN //
    Route::get('/input_orderan', 'OrderController@index');
    Route::POST('/input_orderan', 'OrderController@store');
    Route::get('/lihat_orderan', 'OrderController@lihat_orderan');
    Route::get('/lihat_orderan/detail/{id}', 'OrderController@show');
    Route::get('/edit_orderan/{id}', 'OrderController@edit');
    Route::PATCH('/edit_orderan/{id}', 'OrderController@update');
    Route::get('/api/bahan/{jenis_id}', 'OrderController@getBahanByJenis');
    Route::get('/api/get-vendor-qty', 'MasterDataController@getVendorTotalQty');

    // CRUD STOK BARANG //
    Route::get('/stok', 'StokController@index');
    Route::get('/show_stok/{id}', 'StokController@show');
    Route::get('/print_stok/{nama_loker}', 'StokController@print_stok');
    Route::get('/siap_kirim_stok/{id}', 'StokController@updateStatusSiapKirim');
    Route::POST('/input_master_stok', 'MasterDataController@input_master_stok');
    Route::POST('/simpan_loker', 'StokController@store_loker');

    // ORDER STATUS ROUTES //
    Route::get('/orderan/order_masuk', 'OrderController@order_masuk');
    Route::get('/orderan/belum_proses', 'OrderController@belum_proses');
    Route::get('/on_proses', 'OrderController@on_proses');
    Route::get('/produksi_selesai', 'OrderController@produksi_selesai');
    Route::get('/siap_kirim', 'OrderController@siap_kirim');
    Route::get('/orderan_selesai', 'OrderController@orderan_selesai');
    Route::get('/orderan/konfirmasi/{id}', 'OrderController@konfirmasi_order');
    Route::get('/orderan/mulai_produksi/{id}', 'OrderController@mulai_produksi');
    Route::get('/orderan/selesai_produksi/{id}', 'OrderController@selesai_produksi');
    Route::post('/orderan/masuk_stok/{id}', 'OrderController@masuk_stok');
    Route::get('/orderan/langsung_siap_kirim/{id}', 'OrderController@langsung_siap_kirim');
    Route::get('/stok_barang', 'OrderController@stok_barang');
    Route::get('/orderan/siap_kirim_dari_stok/{id}', 'OrderController@siap_kirim_dari_stok');
    Route::get('/orderan/kirim_selesai/{id}', 'OrderController@kirim_selesai');
    Route::get('/orderan/cetak_invoice/{id}', 'OrderController@cetak_invoice');
    Route::get('/orderan/confirm_validation/{id}', 'OrderController@confirm_validation');

    // SUDAH DAN BELUM DIBYAR PENGGAJIAN KARYAWAN (Regular Lists) //
    Route::get('/sudah_di_bayar', 'GajiKaryawanController@sudah_di_bayar');
    Route::get('/belum_di_bayar', 'GajiKaryawanController@belum_di_bayar');
    Route::get('/all_list', 'GajiKaryawanController@history');

    // UPDATE DATA ONLY (Allowed for Karyawan as requested)
    Route::get('/penggajian/masterdata/edit_pembayaran/{id}', 'MasterDataController@edit_pembayaran');
    Route::PATCH('/penggajian/masterdata/edit_pembayaran/{id}', 'MasterDataController@update_pembayaran');
    Route::get('/penggajian/ubah_status_pembayaran/{id}', 'MasterDataController@ubah_status_pembayaran');
    
    Route::get('/edit_stok/{id}', 'MasterDataController@edit_stok');
    Route::PATCH('/edit_stok/{id}', 'MasterDataController@update_stok');

    //PROFILE
    Route::get('/profile/{id}', 'AkunController@index');
    Route::PATCH('/update_profile/{id}', 'AkunController@update');
});

// Group for Owner Only
Route::group(['middleware' => ['auth', 'checkrole:owner']], function () {
    //CRUD MASTER DATA ORDERAN
    Route::get('/master_orderan', 'MasterDataController@master_orderan');
    Route::post('/master-bahan/store-ajax', 'MasterDataController@store_bahan_ajax');
    Route::post('/master-bahan/delete-ajax', 'MasterDataController@destroy_bahan_ajax');
    Route::get('/orderan/hapus_orderan/{id}', 'MasterDataController@destroy_orderan');

    //CRUD MASTER DATA ACCOUNT
    Route::get('/master_akun', 'MasterDataController@master_akun');
    Route::get('/master_akun/edit/{id}', 'MasterDataController@edit_akun');
    Route::get('/master_akun/hapus_akun/{id}', 'MasterDataController@destroy_akun');
    Route::PATCH('/master_akun/update/{id}', 'MasterDataController@update_akun');
    Route::post('/master_akun/add', 'MasterDataController@add_akun');

    //OMSET
    Route::get('/omset_bulanan', 'OmsetContoller@index');
    Route::POST('/omset_bulanan', 'OmsetContoller@cari_omset');
    Route::get('/omset_tahunan', 'OmsetContoller@omset_tahunan');
    Route::POST('/omset_tahunan', 'OmsetContoller@cari_omset_tahunan');

    // MASTER DATA PENGGAJIAN (Input & Master Lists)
    Route::get('/penggajian/dashboard', 'MasterDataController@master_gaji');
    Route::get('/penggajian/masterdata/sudah_di_bayar', 'MasterDataController@sudah_di_bayar');
    Route::get('/penggajian/masterdata/belum_di_bayar', 'MasterDataController@belum_di_bayar');
    Route::get('/penggajian/masterdata/all_list', 'MasterDataController@all_list');
    Route::get('/penggajian/masterdata/hapus_pembayaran/{id}', 'MasterDataController@destroy_pembayaran');
    
    // INPUT GAJI
    Route::get('/penggajian/add_potong', 'MasterDataController@add_potong');
    Route::POST('/penggajian/add_potong', 'MasterDataController@store_potong');
    Route::get('/penggajian/add_jahit', 'MasterDataController@add_jahit');
    Route::POST('/penggajian/add_jahit', 'MasterDataController@store_jahit');
    Route::get('/penggajian/add_sablon', 'MasterDataController@add_sablon');
    Route::POST('/penggajian/add_sablon', 'MasterDataController@store_sablon');
    Route::get('/penggajian/add_packaging', 'MasterDataController@add_packaging');
    Route::POST('/penggajian/add_packaging', 'MasterDataController@store_packaging');

    // MASTER STOK (Input & Master List)
    Route::get('/master_stok', 'MasterDataController@master_stok');
    Route::get('/lihat_stok/{nama_loker}', 'MasterDataController@show_stok');
    Route::get('/hapus_stok/{id}', 'MasterDataController@destroy_stok');
    Route::get('/hapus_stok_dashboard/{id}', 'StokController@destroy');
    Route::get('/hapus_loker/{id}', 'StokController@destroy_loker');
});
