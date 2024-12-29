<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Kasir\TransaksiController;

Route::middleware('auth', 'verified',  'cek_level:kasir')->group(function () {
    Route::prefix('kasir')->group(function () {

        Route::get('/transaksi', [TransaksiController::class, 'transaksi'])->name('kasir.index');
        Route::get('/harga-barang-transaksi/{id}/{kode}', [TransaksiController::class, 'hargaBarang'])->name('kasir.hargaBarang');
        Route::get('/data-transaksi-cart', [TransaksiController::class, 'DataTransaksiCart'])->name('kasir.DataTransaksiCart');
        Route::post('/simpan-transaksi-cart', [TransaksiController::class, 'simpanTransaksi'])->name('kasir.simpanTransaksi');
        Route::delete('/delete-transaksi-cart/{id}', [TransaksiController::class, 'deleteCartTransaksi'])->name('kasir.deleteCartTransaksi');
        Route::post('/simpan-transaksi-final', [TransaksiController::class, 'simpanTransaksiFinal'])->name('kasir.simpanTransaksiFinal');

        Route::get('/transaksi-pesan-cetak/{id}', [TransaksiController::class, 'cetakPrintPemesanan'])->name('kasir.cetak-pemesanan');

        Route::get('/transaksi-list', [TransaksiController::class, 'transaksiListPesanan'])->name('kasir.list');
        Route::get('/data-penjualan-langsung/{jenis_transaksi}', [TransaksiController::class, 'getDataAll'])->name('kasir.dataAlljson');
        Route::get('/detail-penjualan-langsung/{id}', [TransaksiController::class, 'DetailDataAll'])->name('kasir.DetailDataAllJson');
        Route::get('/data-pemesanan', [TransaksiController::class, 'DataPemesananAll'])->name('kasir.DataPemesananAll');
        Route::get('/detail-pemesanan/{id}', [TransaksiController::class, 'DetailDataPemesanan'])->name('kasir.DetailDataPemesanan');
        Route::put('/update-status-pemesanan/{id}', [TransaksiController::class, 'updateStatusPesnan'])->name('kasir.updateStatusPesnan');
        Route::put('/batal-status-pemesanan/{id}', [TransaksiController::class, 'batalkanPesanan'])->name('kasir.batalkanPesanan');

        Route::get('/batal-transaksi-pemesanan/{id}', [TransaksiController::class, 'batalkanTransaksiAll'])->name('kasir.batalkanTransaksiAll');

        Route::get('/update-pembayaran-hutang/{id}', [TransaksiController::class, 'DetailDataHutang'])->name('kasir.DetailDataHutang');
        Route::put('/simpan-pembayaran-hutang/{id}', [TransaksiController::class, 'BayarHutang'])->name('kasir.BayarHutang');
    });
});
