<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Master\JenisController;
use App\Http\Controllers\Master\KategoriController;
use App\Http\Controllers\Master\lensaController;
use App\Http\Controllers\Master\BarangController;
use App\Http\Controllers\Master\GudangController;
use App\Http\Controllers\Master\SuplaierController;
use App\Http\Controllers\Master\TypeController;
use App\Http\Controllers\Master\KaryawanController;
use App\Http\Controllers\Master\CabangController;
use App\Http\Controllers\Master\DashboardController;
use App\Http\Controllers\Master\LaporanController;
use App\Http\Controllers\Master\PasswordResetLinkController;

Route::middleware('auth', 'verified', 'cek_level:owner')->group(function () {
    Route::prefix('owner-dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('owner-dashboard.index');
    });

    // reset password
    Route::prefix('owner-reset-password')->group(function () {
        Route::post('/', [PasswordResetLinkController::class, 'store'])->name('owner-reset-password.index');
    });

    Route::prefix('type')->group(function () {
        Route::get('/', [TypeController::class, 'index'])->name('type.index');
        Route::get('data-type-all', [TypeController::class, 'DatatypeJson'])->name('type.data');
        Route::post('save-type', [TypeController::class, 'store'])->name('type.save');
        Route::put('update-type/{id}', [TypeController::class, 'update'])->name('type.update');
        Route::delete('delete-type/{id}', [TypeController::class, 'destroy'])->name('type.delete');
        Route::put('status-type/{id}', [TypeController::class, 'updateStatus'])->name('type.status');
    });

    Route::prefix('jenis')->group(function () {
        Route::get('/', [JenisController::class, 'index'])->name('jenis.index');
        Route::get('data-jenis-all', [JenisController::class, 'DataJenisJson'])->name('jenis.data');
        Route::post('save-jenis', [JenisController::class, 'store'])->name('jenis.save');
        Route::put('update-jenis/{id}', [JenisController::class, 'update'])->name('jenis.update');
        Route::delete('delete-jenis/{id}', [JenisController::class, 'destroy'])->name('jenis.delete');
        Route::put('status-jenis/{id}', [JenisController::class, 'updateStatus'])->name('jenis.status');
    });

    Route::prefix('kategori')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
        Route::get('data-kategori-all', [KategoriController::class, 'DatakategoriJson'])->name('kategori.data');
        Route::post('save-kategori', [KategoriController::class, 'store'])->name('kategori.save');
        Route::get('get-data/{id}', [KategoriController::class, 'viewData'])->name('kategori.view');
        Route::put('update-kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('delete-kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.delete');
        Route::put('status-kategori/{id}', [KategoriController::class, 'updateStatus'])->name('kategori.status');
    });

    Route::prefix('seting-lensa')->group(function () {
        Route::get('/', [LensaController::class, 'index'])->name('lensa.index');
        Route::get('data-seting-lensa-all', [LensaController::class, 'DataSetingLensaJson'])->name('lensa.data');
        Route::post('save-seting-lensa', [LensaController::class, 'saveData'])->name('lensa.save');
    });

    Route::prefix('produk')->group(function () {
        Route::get('/', [BarangController::class, 'index'])->name('produk.index');
        Route::get('data-produk-all', [BarangController::class, 'DatabarangJson'])->name('produk.data');
        Route::post('save-produk', [BarangController::class, 'store'])->name('produk.save');
        Route::get('get-data/{id}', [BarangController::class, 'viewData'])->name('produk.view');
        Route::put('update-produk/{id}', [BarangController::class, 'update'])->name('produk.update');
        Route::delete('delete-produk/{id}', [BarangController::class, 'destroy'])->name('produk.delete');
        Route::put('status-produk/{id}', [BarangController::class, 'updateStatus'])->name('produk.status');
    });

    Route::prefix('gudang')->group(function () {
        Route::get('/', [GudangController::class, 'index'])->name('gudang.index');
        Route::get('data-gudang-all', [GudangController::class, 'DataGudangJson'])->name('gudang.data');
        Route::post('save-gudang', [GudangController::class, 'store'])->name('gudang.save');
        Route::get('get-data/{id}', [GudangController::class, 'viewData'])->name('kategori.view');
        Route::put('update-gudang/{id}', [GudangController::class, 'update'])->name('gudang.update');
        Route::delete('delete-gudang/{id}', [GudangController::class, 'destroy'])->name('gudang.delete');
        Route::put('status-gudang/{id}', [GudangController::class, 'updateStatus'])->name('gudang.status');
    });

    Route::prefix('suplaier')->group(function () {
        Route::get('/', [SuplaierController::class, 'index'])->name('suplaier.index');
        Route::get('data-suplaier-all', [SuplaierController::class, 'DataSuplaierJson'])->name('suplaier.data');
        Route::post('save-suplaier', [SuplaierController::class, 'store'])->name('suplaier.save');
        Route::get('get-data/{id}', [SuplaierController::class, 'viewData'])->name('suplaier.view');
        Route::put('update-suplaier/{id}', [SuplaierController::class, 'update'])->name('suplaier.update');
        Route::delete('delete-suplaier/{id}', [SuplaierController::class, 'destroy'])->name('suplaier.delete');
        Route::put('status-suplaier/{id}', [SuplaierController::class, 'updateStatus'])->name('suplaier.status');
    });

    Route::prefix('cabang')->group(function () {
        Route::get('/', [CabangController::class, 'index'])->name('cabang.index');
        Route::get('data-cabang-all', [CabangController::class, 'DatacabangJson'])->name('cabang.data');
        Route::post('save-cabang', [CabangController::class, 'store'])->name('cabang.save');
        Route::get('get-data/{id}', [CabangController::class, 'viewData'])->name('cabang.view');
        Route::put('update-cabang/{id}', [CabangController::class, 'update'])->name('cabang.update');
        Route::delete('delete-cabang/{id}', [CabangController::class, 'destroy'])->name('cabang.delete');
        Route::put('status-cabang/{id}', [CabangController::class, 'updateStatus'])->name('cabang.status');
    });

    Route::prefix('karyawan')->group(function () {
        Route::get('/', [KaryawanController::class, 'index'])->name('karyawan.index');
        Route::get('data-karyawan-all', [KaryawanController::class, 'DataKaryawanJson'])->name('karyawan.data');
        Route::post('save-karyawan', [KaryawanController::class, 'store'])->name('karyawan.save');
        Route::get('get-data/{id}', [KaryawanController::class, 'viewData'])->name('karyawan.view');
        Route::put('update-karyawan/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');
        Route::delete('delete-karyawan/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.delete');
        Route::put('status-karyawan/{id}', [KaryawanController::class, 'updateStatus'])->name('karyawan.status');
    });

    Route::prefix('laporan')->group(function () {
        Route::get('/penjualan', [LaporanController::class, 'index'])->name('owner-laporan.penjualan');
        Route::post('/penjualan/data', [LaporanController::class, 'GetDataLaporan'])->name('owner-laporan.data-penjualan');
        Route::get('/pemesanan', [LaporanController::class, 'pemesanan'])->name('owner-laporan.pemesanan');
        Route::post('/pemesanan/data', [LaporanController::class, 'GetDataPesanan'])->name('owner-laporan.data-pemesanan');
        Route::get('/utang', [LaporanController::class, 'utang'])->name('owner-laporan.utang');
        Route::post('/utang/data', [LaporanController::class, 'GetDataUtang'])->name('owner-laporan.data-utang');
        Route::get('/stock', [LaporanController::class, 'stock'])->name('owner-laporan.stock');
        Route::post('/stock/data', [LaporanController::class, 'GetDataStock'])->name('owner-laporan.data-stock');
    });
});
