<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Gudang\BarangGudangController;
use App\Http\Controllers\Gudang\BatalController;
use App\Http\Controllers\Gudang\StockController;
use App\Http\Controllers\Gudang\PermintaanController;
use App\Http\Controllers\Gudang\SelesaiController;
use App\Http\Controllers\Gudang\DashboardController;

Route::middleware('auth', 'verified', 'cek_level:gudang')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('gudang-dashboard.index');
    });
    Route::prefix('gudang-barang')->group(function () {
        Route::get('/', [BarangGudangController::class, 'index'])->name('gudang-barang.index');
        Route::get('data-gudang-barang-all', [BarangGudangController::class, 'DataBarangJson'])->name('gudang-barang.data');

        Route::get('kode-gudang-barang', [BarangGudangController::class, 'KodeBarangJson'])->name('gudang-kode-barang.add');
        Route::get('add-gudang-barang', [BarangGudangController::class, 'addBarang'])->name('gudang-barang.add');
        Route::post('save-gudang-barang', [BarangGudangController::class, 'store'])->name('gudang-barang.save');

        Route::get('get-gudang-data/{id}', [BarangGudangController::class, 'viewData'])->name('gudang-barang.view');

        Route::get('edit-gudang-barang/{id}', [BarangGudangController::class, 'editBarang'])->name('gudang-barang.edit');
        Route::put('update-gudang-barang/{id}', [BarangGudangController::class, 'update'])->name('gudang-barang.update');
        Route::delete('delete-gudang-barang/{id}', [BarangGudangController::class, 'destroy'])->name('gudang-barang.delete');

        Route::get('/cetak-barcode-barang', [BarangGudangController::class, 'CetakBarcode'])->name('gudang-barang-barcode.CetakBarcode');
        Route::get('/sercing-barcode-barang/{kode_produk}', [BarangGudangController::class, 'DataGetBarang'])->name('gudang-sercing-barang.barcode');
        Route::post('/pdf-barcode-barang', [BarangGudangController::class, 'generateBarcodePdf'])->name('gudang-pdf-barang.barcode');
    });

    Route::prefix('gudang-stock')->group(function () {
        Route::get('/', [StockController::class, 'index'])->name('gudang-stock.index');
        Route::get('data-gudang-stock-all', [StockController::class, 'DataStockJson'])->name('gudang-stock.data');

        Route::get('sercing-gudang-stock/{kode_produk}', [StockController::class, 'DataGetBarang'])->name('gudang-sercing-stock.add');
        Route::get('add-gudang-stock', [StockController::class, 'addStock'])->name('gudang-stock.add');
        Route::post('save-gudang-stock', [StockController::class, 'store'])->name('gudang-stock.save');

        Route::get('gudang-stock-log', [StockController::class, 'viewLog'])->name('gudang-stock.log');
        Route::get('gudang-stock-log-all', [StockController::class, 'DataStockRiwayatJson'])->name('gudang-stock-data-log.data');
        Route::delete('gudang-stock-log-delete/{id}', [StockController::class, 'destroy'])->name('gudang-stock-data-log.delete');
        Route::get('get-gudang-stock-data/{id}', [StockController::class, 'viewData'])->name('gudang-stock.view');
        Route::delete('gudang-stock-barang-delete/{id}', [StockController::class, 'destroyStock'])->name('gudang-stock-data-stock.delete');
    });

    Route::prefix('gudang-permintaan')->group(function () {
        Route::get('/permintaan-barang', [PermintaanController::class, 'index'])->name('gudang-permintaan.index');
        Route::get('/permintaan-data-all', [PermintaanController::class, 'GetDataPermintaan'])->name('gudang-permintaan.GetDataPermintaan');
        Route::get('/permintaan-data-detail/{id}', [PermintaanController::class, 'GetDataIDPermintaan'])->name('gudang-permintaan.GetDataIDPermintaan');
        Route::post('/permintaan-status-update', [PermintaanController::class, 'TindakanPermintaan'])->name('gudang-permintaan.TindakanPermintaan');
        Route::get('/permintaan-ceatk-kirim/{id}/{cabang}', [PermintaanController::class, 'CetakKirim'])->name('gudang-permintaan.CetakKirim');
    });

    Route::prefix('gudang-permintaan-selesai')->group(function () {
        Route::get('/permintaan-selesai-barang', [SelesaiController::class, 'index'])->name('gudang-selesai.index');
        Route::get('/permintaan-selesai-data-all', [SelesaiController::class, 'GetDataPermintaan'])->name('gudang-selesai.GetDataPermintaan');
        Route::get('/permintaan-selesai-data-detail/{id}', [SelesaiController::class, 'GetDataIDPermintaan'])->name('gudang-selesai.GetDataIDPermintaan');
        Route::post('/permintaan-selesai-status-update', [SelesaiController::class, 'TindakanPermintaan'])->name('gudang-selesai.TindakanPermintaan');
        Route::get('/permintaan-selesai-ceatk-kirim/{id}/{cabang}', [SelesaiController::class, 'CetakKirim'])->name('gudang-selesai.CetakKirim');
    });

    Route::prefix('gudang-permintaan-batal')->group(function () {
        Route::get('/permintaan-batal-barang', [BatalController::class, 'index'])->name('gudang-batal.index');
        Route::get('/permintaan-batal-data-all', [BatalController::class, 'GetDataPermintaanBatal'])->name('gudang-batal.GetDataPermintaanBatal');
        Route::get('/permintaan-batal-data-detail/{id}', [BatalController::class, 'GetDataIDPermintaanBatal'])->name('gudang-batal.GetDataIDPermintaanBatal');
    });
});
