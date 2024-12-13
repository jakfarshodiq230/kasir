<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OpKategori;
use Illuminate\Http\Request;
use App\Models\OpPenjualan;
use App\Models\OpPenjualanDetail;
use App\Models\OpPesanan;
use App\Models\OpPesananDetail;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function Pemesanan()
    {
        $kategori = OpKategori::where('status', 1)->get();
        return view("admin.history.transaksi-pemesanan", compact('kategori'));
    }

    public function GetDataPesanan(Request $request)
    {
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);

        $pesanan = OpPesanan::where('id_cabang', Auth::user()->id_cabang);

        if ($request->has('tanggal_transaksi') && $request->tanggal_transaksi != '') {
            $pesanan = $pesanan->whereDate('tanggal_transaksi', $request->tanggal_transaksi);
        }
        if ($request->has('jenis_transaksi') && $request->jenis_transaksi != '') {
            $pesanan = $pesanan->where('jenis_transaksi', $request->jenis_transaksi);
        }
        if ($request->has('nomor_transaksi') && $request->nomor_transaksi != '') {
            $pesanan = $pesanan->where('nomor_transaksi', $request->nomor_transaksi);
        }

        $totalRecords = $pesanan->count();
        $pesanan->orderBy('created_at', 'DESC');
        // Apply pagination
        $pesanan = $pesanan->with('user', 'cabang', 'pemesanandetail', 'gudang')
            ->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // You can adjust this to reflect filtered count
            'data' => $pesanan,
        ]);
    }


    public function GetDataIDPesanan($kode)
    {
        $pesanan = OpPesananDetail::where('nomor_transaksi', $kode)->with('barang', 'pesanan')->get();
        return response()->json(['success' => true, 'message' => 'Item deleted successfully', 'data' => $pesanan]);
    }
}
