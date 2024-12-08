<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OpPenjualan;
use App\Models\OpPenjualanDetail;
use App\Models\OpPesanan;
use App\Models\OpPesananDetail;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        return view("admin.transaksi.transaksi-penjualan");
    }

    public function GetDataAll(Request $request)
    {
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        // Start building the query
        $penjualan = OpPenjualan::where('id_cabang', Auth::user()->id_cabang);

        // Apply filters if they exist
        if ($request->has('tanggal_transaksi') && $request->tanggal_transaksi != '') {
            $penjualan = $penjualan->whereDate('tanggal_transaksi', $request->tanggal_transaksi);
        }
        if ($request->has('jenis_transaksi') && $request->jenis_transaksi != '') {
            $penjualan = $penjualan->where('jenis_transaksi', $request->jenis_transaksi);
        }

        // Get the total count before applying pagination
        $totalRecords = $penjualan->count();
        $penjualan->orderBy('tanggal_transaksi', 'DESC');
        // Apply pagination
        $penjualan = $penjualan->with('user', 'cabang', 'penjualanDetails')
            ->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data loaded successfully',
            'data' => $penjualan,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // Adjust if needed for filtered count
        ]);
    }

    public function GetDataID($kode)
    {
        $penjualan = OpPenjualanDetail::where('nomor_transaksi', $kode)->with('barang', 'penjualan')->get();
        return response()->json(['success' => true, 'message' => 'Item deleted successfully', 'data' => $penjualan]);
    }


    public function Pemesanan()
    {
        return view("admin.transaksi.transaksi-pemesanan");
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
