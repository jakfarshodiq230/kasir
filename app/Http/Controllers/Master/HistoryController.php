<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OpCabang;
use App\Models\OpKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    public function Pemesanan()
    {
        $kategori = OpKategori::where('status', 1)->get();
        $cabang    = OpCabang::where('status_cabang', 1)->get();
        return view("master.history.transaksi-pemesanan", compact('kategori', 'cabang'));
    }

    public function GetDataPesanan(Request $request)
    {
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);

        // Query dasar menggunakan join
        $query = DB::table('op_transaksi_detail as opd')
            ->join('op_barang as b', 'opd.id_barang', '=', 'b.id')
            ->join('op_kategori as k', 'b.id_kategori', '=', 'k.id')
            ->join('op_transaksi as p', 'opd.nomor_transaksi', '=', 'p.nomor_transaksi')
            ->join('op_gudang as g', 'opd.id_gudang', '=', 'g.id')
            ->select(
                'opd.*',
                'b.*',
                'g.*',
                'p.*'
            )
            ->whereIn('opd.pemesanan', ['ya']);

        // Filter berdasarkan tanggal_transaksi jika tersedia
        if ($request->filled('tanggal_transaksi')) {
            $query->whereDate('p.tanggal_transaksi', $request->input('tanggal_transaksi'));
        }

        // Filter berdasarkan jenis_transaksi jika tersedia
        if ($request->filled('jenis_transaksi')) {
            $query->where('b.id_kategori', $request->input('jenis_transaksi'));
        }

        // Filter berdasarkan jenis_transaksi jika tersedia
        if ($request->filled('cabang_transaksi')) {
            $query->where('opd.id_cabang', $request->input('cabang_transaksi'));
        }

        // Hitung total data sebelum paginasi
        $totalRecords = $query->count();

        // Ambil data dengan paginasi
        $pesanan = $query
            ->orderBy('opd.created_at', 'DESC')
            //->groupBy('p.nomor_transaksi')
            ->skip($start)
            ->take($length)
            ->get();

        // Hitung total data yang difilter (jika filter diterapkan)
        $filteredRecords = $query->count();

        // Return response JSON
        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $pesanan,
        ]);
    }

    public function penjualan()
    {
        $kategori = OpKategori::where('status', 1)->get();
        $cabang    = OpCabang::where('status_cabang', 1)->get();
        return view("master.history.transaksi-penjualan", compact('kategori', 'cabang'));
    }

    public function GetDataPenjualan(Request $request)
    {
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);

        // Query dasar menggunakan join
        $query = DB::table('op_transaksi_detail as opd')
            ->join('op_barang as b', 'opd.id_barang', '=', 'b.id')
            ->join('op_kategori as k', 'b.id_kategori', '=', 'k.id')
            ->join('op_transaksi as p', 'opd.nomor_transaksi', '=', 'p.nomor_transaksi')
            ->select(
                'opd.*',
                'b.*',
                'p.*',
                'k.*'
            )->whereIn('opd.pemesanan', ['tidak']);

        // Filter berdasarkan tanggal_transaksi jika tersedia
        if ($request->filled('tanggal_transaksi')) {
            $query->whereDate('p.tanggal_transaksi', $request->input('tanggal_transaksi'));
        }

        // Filter berdasarkan jenis_transaksi jika tersedia
        if ($request->filled('jenis_transaksi')) {
            $query->where('b.id_kategori', $request->input('jenis_transaksi'));
        }

        // Filter berdasarkan jenis_transaksi jika tersedia
        if ($request->filled('cabang_transaksi')) {
            $query->where('opd.id_cabang', $request->input('cabang_transaksi'));
        }

        // Hitung total data sebelum paginasi
        $totalRecords = $query->count();

        // Ambil data dengan paginasi
        $pesanan = $query
            ->orderBy('opd.created_at', 'DESC')
            ->skip($start)
            ->take($length)
            ->get();

        // Hitung total data yang difilter (jika filter diterapkan)
        $filteredRecords = $query->count();

        // Return response JSON
        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $pesanan,
        ]);
    }
}
