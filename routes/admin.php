<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\StockBarangController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\KasController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Admin\LaporanController;

// Middleware gabungan dengan 'cek_level:admin'
Route::middleware(['auth', 'verified', 'cek_level:admin'])->group(function () {
    // Admin Dashboard
    Route::prefix('admin-dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin-dashboard.index');
    });

    // Admin Stock
    Route::prefix('admin-stock')->group(function () {
        Route::get('/', [StockBarangController::class, 'index'])->name('admin-stock.index');
        Route::get('data-admin-stock-all', [StockBarangController::class, 'DataStockJson'])->name('admin-stock.data');
        Route::get('sercing-admin-stock/{kode_produk}', [StockBarangController::class, 'DataGetBarang'])->name('admin-sercing-stock.add');
        Route::get('add-admin-stock', [StockBarangController::class, 'addStock'])->name('admin-stock.add');
        Route::post('save-admin-stock', [StockBarangController::class, 'store'])->name('admin-stock.save');
        Route::get('admin-stock-log', [StockBarangController::class, 'viewLog'])->name('admin-stock.log');
        Route::get('admin-stock-log-all', [StockBarangController::class, 'DataStockRiwayatJson'])->name('admin-stock-data-log.data');
        Route::delete('admin-stock-log-delete/{id}', [StockBarangController::class, 'destroy'])->name('admin-stock-data-log.delete');
        Route::get('get-admin-stock-data/{id}', [StockBarangController::class, 'viewData'])->name('admin-stock.view');
        Route::delete('admin-stock-stock-delete/{id}', [StockBarangController::class, 'destroyStock'])->name('admin-stock-data-stock.delete');
    });

    // Admin Transaksi
    Route::prefix('admin-transaksi')->group(function () {
        Route::get('/penjualan', [TransaksiController::class, 'index'])->name('admin-penjualan.index');
        Route::get('/transaksi-data-all', [TransaksiController::class, 'GetDataAll'])->name('admin-penjualan.GetDataAll');
        Route::get('/transaksi-data-detail/{id}', [TransaksiController::class, 'GetDataID'])->name('admin-penjualan.GetDataID');
        Route::get('/pemesanan', [TransaksiController::class, 'Pemesanan'])->name('admin-pemesanan.index');
        Route::get('/pemesanan-data-all', [TransaksiController::class, 'GetDataPesanan'])->name('admin-pemesanan.GetDataAll');
        Route::get('/pemesanan-data-detail/{id}', [TransaksiController::class, 'GetDataIDPesanan'])->name('admin-pemesanan.GetDataID');
    });

    // Admin Kas
    Route::prefix('admin-kas')->group(function () {
        Route::get('/', [KasController::class, 'index'])->name('admin-kas.index');
        Route::get('/kas-data-all', [KasController::class, 'GetDataKas'])->name('admin-kas.GetDataKas');
        Route::delete('/kas-data-delete/{id}/{kode}', [KasController::class, 'deleteAndUpdateSaldo'])->name('admin-kas.deleteAndUpdateSaldo');
        Route::post('/kas-data-save', [KasController::class, 'store'])->name('admin-kas.store');
        Route::get('/kas-data-get/{id}/{kode}', [KasController::class, 'edit'])->name('admin-kas.edit');
        Route::put('/kas-data-update/{id}', [KasController::class, 'update'])->name('admin-kas.update');
    });

    // Admin Laporan
    Route::prefix('admin-laporan')->group(function () {
        Route::get('/penjualan', [LaporanController::class, 'index'])->name('admin-laporan.penjualan');
        Route::post('/penjualan/data', [LaporanController::class, 'GetDataLaporan'])->name('admin-laporan.data-penjualan');
        Route::delete('/penjualan/delete/{id}', [LaporanController::class, 'hapuspenjualan'])->name('admin-laporan.delete-penjualan');

        Route::get('/pemesanan', [LaporanController::class, 'pemesanan'])->name('admin-laporan.pemesanan');
        Route::post('/pemesanan/data', [LaporanController::class, 'GetDataPesanan'])->name('admin-laporan.data-pemesanan');

        Route::get('/utang', [LaporanController::class, 'utang'])->name('admin-laporan.utang');
        Route::post('/utang/data', [LaporanController::class, 'GetDataUtang'])->name('admin-laporan.data-utang');

        Route::get('/stock', [LaporanController::class, 'stock'])->name('admin-laporan.stock');
        Route::post('/stock/data', [LaporanController::class, 'GetDataStock'])->name('admin-laporan.data-stock');
    });

    // Admin History
    Route::prefix('admin-history')->group(function () {
        Route::get('/pemesanan-history', [HistoryController::class, 'pemesanan'])->name('admin-history.data-pemesanan');
        Route::post('/pemesanan-history-data', [HistoryController::class, 'GetDataPesanan'])->name('admin-history.data-history');
    });
});
