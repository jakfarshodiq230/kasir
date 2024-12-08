<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OpBarang;
use App\Models\OpBarangCabangStock;
use App\Models\OpBarangCabangStockLog;
use App\Models\OpKategori;
use App\Models\OpPenjualan;
use App\Models\OpPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index()
    {
        return view("admin.laporan.penjualan");
    }

    public function GetDataLaporan(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);
        $startDate = Carbon::parse($request->startDate)->toDateString();
        $endDate = Carbon::parse($request->endDate)->toDateString();

        $penjualan = OpPenjualan::where('id_cabang', Auth::user()->id_cabang)
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->orderBy('tanggal_transaksi', 'DESC')
            ->with(['user', 'cabang', 'penjualanDetails'])
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data loaded successfully',
            'data' => $penjualan,
        ]);
    }

    public function pemesanan()
    {
        return view("admin.laporan.pemesanan");
    }

    public function GetDataPesanan(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);
        $startDate = Carbon::parse($request->startDate)->toDateString();
        $endDate = Carbon::parse($request->endDate)->toDateString();

        $penjualan = OpPesanan::where('id_cabang', Auth::user()->id_cabang)
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->orderBy('tanggal_transaksi', 'DESC')
            ->with(['user', 'cabang', 'pemesanandetail'])
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data loaded successfully',
            'data' => $penjualan,
        ]);
    }

    public function utang()
    {
        return view("admin.laporan.utang");
    }

    public function GetDataUtang(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'status' => 'required',
        ]);
        $startDate = Carbon::parse($request->startDate)->toDateString();
        $endDate = Carbon::parse($request->endDate)->toDateString();
        $status = $request->status;

        $penjualan = OpPenjualan::where('id_cabang', Auth::user()->id_cabang)
            ->where('status_penjualan', '=', $status)
            ->where('jenis_transaksi', '=', 'hutang')
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->orderBy('tanggal_transaksi', 'DESC')
            ->with(['user', 'cabang', 'penjualanDetails'])
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data loaded successfully',
            'data' => $penjualan,
        ]);
    }

    public function stock()
    {
        $kategori = OpKategori::all();
        return view("admin.laporan.stock", compact('kategori'));
    }

    public function GetDataStock(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'kategori' => 'required',
        ]);

        // Convert start and end dates to 'YYYY-MM-DD' format
        $startDate = Carbon::parse($request->startDate)->toDateString();
        $endDate = Carbon::parse($request->endDate)->toDateString();
        $kategori = $request->kategori;

        $stocks = OpBarangCabangStockLog::where('id_cabang', Auth::user()->id_cabang)
            ->whereHas('barang', function ($query) use ($kategori) {
                $query->where('id_kategori', $kategori);
            })
            // Using whereDate to compare only the date part
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->with(['barang']) // Eager load the related OpBarang data
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data loaded successfully',
            'data' => $stocks,
        ]);
    }
}
