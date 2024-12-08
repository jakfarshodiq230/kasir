<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OpBarang;
use App\Models\OpBarangCabangStock;
use App\Models\OpBarangCabangStockLog;
use App\Models\OpCabang;
use App\Models\OpKategori;
use App\Models\OpPenjualan;
use App\Models\OpPesanan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index()
    {
        $cabang = OpCabang::where('id_toko', Auth::user()->id_toko)->get();
        return view("master.laporan.penjualan", compact('cabang'));
    }

    public function GetDataLaporan(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'id_cabang' => 'required',
        ]);

        $startDate = Carbon::parse($request->startDate)->toDateString();
        $endDate = Carbon::parse($request->endDate)->toDateString();

        $penjualan = OpPenjualan::where('id_cabang', $request->id_cabang)
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
        $cabang = OpCabang::where('id_toko', Auth::user()->id_toko)->get();
        return view("master.laporan.pemesanan", compact('cabang'));
    }

    public function GetDataPesanan(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'id_cabang' => 'required',
        ]);
        $startDate = Carbon::parse($request->startDate)->toDateString();
        $endDate = Carbon::parse($request->endDate)->toDateString();

        $penjualan = OpPesanan::where('id_cabang', $request->id_cabang)
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
        $cabang = OpCabang::where('id_toko', Auth::user()->id_toko)->get();
        return view("master.laporan.utang", compact('cabang'));
    }

    public function GetDataUtang(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'status' => 'required',
            'id_cabang' => 'required',
        ]);
        $startDate = Carbon::parse($request->startDate)->toDateString();
        $endDate = Carbon::parse($request->endDate)->toDateString();
        $status = $request->status;

        $penjualan = OpPenjualan::where('id_cabang', $request->id_cabang)
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
        $cabang = OpCabang::where('id_toko', Auth::user()->id_toko)->get();
        return view("master.laporan.stock", compact('kategori', 'cabang'));
    }

    public function GetDataStock(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'kategori' => 'required',
            'id_cabang' => 'required',
        ]);

        // Convert start and end dates to 'YYYY-MM-DD' format
        $startDate = Carbon::parse($request->startDate)->toDateString();
        $endDate = Carbon::parse($request->endDate)->toDateString();
        $kategori = $request->kategori;

        $stocks = OpBarangCabangStockLog::where('id_cabang', $request->id_cabang)
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
