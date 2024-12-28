<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OpTransaksi;
use App\Models\OpTransaksiDetail;
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
        $penjualan = OpTransaksi::join('op_transaksi_detail', 'op_transaksi.id', '=', 'op_transaksi_detail.id_transaksi')
            ->where('op_transaksi.id_cabang', Auth::user()->id_cabang)
            ->where('op_transaksi_detail.pemesanan', 'tidak'); // Ensure you use the correct table alias

        // Apply filters if they exist
        if ($request->has('tanggal_transaksi') && $request->tanggal_transaksi != '') {
            $penjualan = $penjualan->whereDate('op_transaksi.tanggal_transaksi', $request->tanggal_transaksi);
        }
        if ($request->has('jenis_transaksi') && $request->jenis_transaksi != '') {
            $penjualan = $penjualan->where('op_transaksi.jenis_transaksi', $request->jenis_transaksi);
        }

        // Get the filtered total count
        $filteredRecords = $penjualan->count();

        // Apply ordering
        $penjualan = $penjualan->orderBy('op_transaksi.tanggal_transaksi', 'DESC');

        // Apply pagination
        $penjualan = $penjualan->with('user', 'cabang', 'transaksidetail')
            ->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data loaded successfully',
            'data' => $penjualan,
            'recordsTotal' => $filteredRecords, // This can be the total count before filters
            'recordsFiltered' => $filteredRecords, // Filtered count after applying the filters
        ]);
    }

    public function GetDataID($kode)
    {
        $penjualan = OpTransaksiDetail::where('nomor_transaksi', $kode)->where('pemesanan', 'tidak')->with('barang', 'transaksi')->get();
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

        $pesanan = OpTransaksiDetail::where('id_cabang', Auth::user()->id_cabang)
            ->where('pemesanan', 'ya');

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
        $pesanan = $pesanan->with('user', 'cabang', 'transaksi', 'gudang')
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
        $pesanan = OpTransaksiDetail::where('nomor_transaksi', $kode)->where('pemesanan', 'ya')->with('barang', 'transaksi')->get();
        return response()->json(['success' => true, 'message' => 'Item deleted successfully', 'data' => $pesanan]);
    }
}
