<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OpTransaksiDetail;
use App\Models\OpTransaksiDetailDetail;
use App\Models\OpTransaksiDetailLog;
use App\Models\OpStockGudang;
use App\Models\OpStockGudangLog;
use App\Models\OpTransaksi;
use App\Models\OpTransaksiLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SelesaiController extends Controller
{
    public function index()
    {
        return view("gudang.selesai.selesai-barang");
    }

    public function GetDataPermintaan(Request $request)
    {
        $start = $request->input('start', 0); // starting index for pagination
        $length = $request->input('length', 10); // number of records per page

        // Start building the query
        $permintaan = OpTransaksiDetail::where('id_gudang', Auth::user()->id_gudang)->where('pemesanan', '=', 'ya')->where('status_pemesanan', '=', 'selesai');

        // Apply filters if they exist
        if ($request->has('tanggal_transaksi') && $request->tanggal_transaksi != '') {
            $permintaan = $permintaan->whereDate('tanggal_transaksi', $request->tanggal_transaksi);
        }
        if ($request->has('jenis_transaksi') && $request->jenis_transaksi != '') {
            $permintaan = $permintaan->where('jenis_transaksi', $request->jenis_transaksi);
        }

        // Get the total count before applying pagination
        $totalRecords = $permintaan->count();

        // Apply pagination
        $permintaan = $permintaan->with('user', 'cabang', 'transaksi')
            ->skip($start)
            ->take($length)
            ->get();

        // Check if there is any data
        if ($permintaan->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No data found for the given filters',
                'data' => [],
            ]);
        }

        // Return data along with the total record count
        return response()->json([
            'success' => true,
            'message' => 'Items retrieved successfully',
            'data' => $permintaan,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // Adjust if you want to reflect filtered count
        ]);
    }

    public function GetDataIDPermintaan($kode)
    {
        $permintaan_barang = OpTransaksi::where('nomor_transaksi', $kode)->first();
        $permintaan_detail = OpTransaksiDetail::where('nomor_transaksi', $kode)->with('barang')->get();
        return view("gudang.selesai.selesai-detail", compact('permintaan_barang', 'permintaan_detail'));
    }

    public function CetakKirim($id, $idCabang)
    {
        $penjualan = OpTransaksi::with('user', 'cabang')->where('nomor_transaksi', $id)->where('id_cabang', $idCabang)->first();
        $detailenjulan = OpTransaksiDetail::with('barang', 'gudang')->where('nomor_transaksi', $id)->get();
        return view("gudang.pesanan.nota-pemesanan", compact('penjualan', 'detailenjulan'));
    }
}
