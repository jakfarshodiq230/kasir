<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Kasir\TransaksiController;

Route::middleware('auth', 'verified',  'cek_level:kasir')->group(function () {
    Route::prefix('kasir')->group(function () {
        Route::get('/harga-barang-transaksi/{id}/{kode}', [TransaksiController::class, 'hargaBarang'])->name('kasir.hargabarang');

        Route::get('/transaksi-langsung', [TransaksiController::class, 'index'])->name('kasir.index');
        Route::post('/simpan-penjualan-cart', [TransaksiController::class, 'simpanPembelian'])->name('kasir.simpancart');
        Route::get('/data-penjualan-cart', [TransaksiController::class, 'getCartData'])->name('kasir.datajson');
        Route::delete('/delete-penjualan-cart/{id}', [TransaksiController::class, 'deleteCartData'])->name('kasir.deletedatajson');
        Route::post('/simpan-penjualan-final', [TransaksiController::class, 'simpanPenjualan'])->name('kasir.simpancart-final');
        Route::get('/transaksi-langsung-cetak/{id}', [TransaksiController::class, 'cetakPrint'])->name('kasir.cetak-langsung');

        Route::get('/transaksi-pemesanan', [TransaksiController::class, 'transaksiPesanan'])->name('kasir.pesanan');
        Route::get('/transaksi-pemesanan-data-barang', [TransaksiController::class, 'getBarang'])->name('kasir.getBarang');
        Route::get('/transaksi-pemesanan-data-harga', [TransaksiController::class, 'getHarga'])->name('kasir.getHarga');
        Route::get('/data-pemesanan-cart', [TransaksiController::class, 'DataPesananCart'])->name('kasir.DataPesananCart');
        Route::post('/simpan-pemesanan-cart', [TransaksiController::class, 'simpanPemesanan'])->name('kasir.simpanPemesanan');
        Route::delete('/delete-pemesanan-cart/{id}', [TransaksiController::class, 'deleteCartPesanan'])->name('kasir.deleteCartPesanan');
        Route::post('/simpan-pemesanan-final', [TransaksiController::class, 'simpanPemesananFinal'])->name('kasir.simpanPemesananFinal');
        Route::get('/transaksi-pemesanan-cetak/{id}', [TransaksiController::class, 'cetakPrintPemesanan'])->name('kasir.cetak-pemesanan');

        Route::get('/transaksi-list', [TransaksiController::class, 'transaksiListPesanan'])->name('kasir.list');
        Route::get('/data-penjualan-langsung/{jenis_transaksi}', [TransaksiController::class, 'getDataAll'])->name('kasir.dataAlljson');
        Route::get('/detail-penjualan-langsung/{id}', [TransaksiController::class, 'DetailDataAll'])->name('kasir.DetailDataAllJson');
        Route::get('/data-pemesanan', [TransaksiController::class, 'DataPemesananAll'])->name('kasir.DataPemesananAll');
        Route::get('/detail-pemesanan/{id}', [TransaksiController::class, 'DetailDataPemesanan'])->name('kasir.DetailDataPemesanan');
        Route::put('/update-status-pemesanan/{id}', [TransaksiController::class, 'updateStatusPesnan'])->name('kasir.updateStatusPesnan');
        Route::get('/update-pembayaran-hutang/{id}', [TransaksiController::class, 'DetailDataHutang'])->name('kasir.DetailDataHutang');
        Route::put('/simpan-pembayaran-hutang/{id}', [TransaksiController::class, 'BayarHutang'])->name('kasir.BayarHutang');
    });
});
