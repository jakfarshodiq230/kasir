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
use App\Models\OpTransaksi;
use App\Models\OpTransaksiDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        $cabang = OpCabang::where('id_toko', Auth::user()->id_toko)->get();
        return view("master.laporan.penjualan", compact('cabang'));
    }

    public function GetDataLaporan(Request $request)
    {
        // Validate input
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'id_cabang' => 'required|exists:op_toko_cabang,id', // Ensure id_cabang exists
        ]);

        try {
            // Directly use the validated dates
            $startDate = $request->startDate;
            $endDate = $request->endDate;

            // Fetch sales data with aggregated values
            $penjualan = OpTransaksi::select(
                'op_transaksi.nomor_transaksi',
                'op_transaksi.jenis_transaksi',
                'op_transaksi.nama',
                'op_transaksi.tanggal_transaksi',
                'op_toko_cabang.nama_toko_cabang',
                'users.name',
                DB::raw('SUM(op_transaksi_detail.jumlah_barang) AS total_jumlah_barang'),
                DB::raw('SUM(op_transaksi_detail.sub_total_transaksi) AS total_sub_total_transaksi')
            )
                ->join('op_toko_cabang', 'op_transaksi.id_cabang', '=', 'op_toko_cabang.id')
                ->join('op_transaksi_detail', 'op_transaksi.nomor_transaksi', '=', 'op_transaksi_detail.nomor_transaksi')
                ->join('users', 'op_transaksi.id_user', '=', 'users.id')
                ->where('op_transaksi.id_cabang', $request->id_cabang)
                ->whereNotIn('op_transaksi.status_transaksi', ['dibatalkan'])
                ->whereIn('op_transaksi_detail.pemesanan', ['tidak'])
                ->whereBetween('op_transaksi.tanggal_transaksi', [$startDate, $endDate])
                ->groupBy(
                    'op_transaksi.nomor_transaksi',
                    'op_transaksi.jenis_transaksi',
                    'op_transaksi.nama',
                    'op_transaksi.tanggal_transaksi'
                )
                ->orderByDesc('op_transaksi.tanggal_transaksi')
                ->get();

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Data loaded successfully',
                'data' => $penjualan,
            ]);
        } catch (\Exception $e) {
            // Handle unexpected errors
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching data',
                'error' => $e->getMessage(),
            ], 500);
        }
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

        $pemesanan = OpTransaksi::select(
            'op_transaksi.nomor_transaksi',
            'op_transaksi.jenis_transaksi',
            'op_transaksi.nama',
            'op_transaksi.tanggal_transaksi',
            'op_toko_cabang.nama_toko_cabang',
            'op_transaksi_detail.status_pemesanan',
            'users.name',
            DB::raw('SUM(op_transaksi_detail.jumlah_barang) AS total_jumlah_barang'),
            DB::raw('SUM(op_transaksi_detail.sub_total_transaksi) AS total_sub_total_transaksi')
        )
            ->join('op_toko_cabang', 'op_transaksi.id_cabang', '=', 'op_toko_cabang.id')
            ->join('op_transaksi_detail', 'op_transaksi.nomor_transaksi', '=', 'op_transaksi_detail.nomor_transaksi')
            ->join('users', 'op_transaksi.id_user', '=', 'users.id')
            ->where('op_transaksi.id_cabang', $request->id_cabang)
            ->whereNotIn('op_transaksi.status_transaksi', ['dibatalkan'])
            ->whereNotIn('op_transaksi_detail.pemesanan', ['ya'])
            ->whereBetween('op_transaksi.tanggal_transaksi', [$startDate, $endDate])
            ->groupBy(
                'op_transaksi.nomor_transaksi',
                'op_transaksi.jenis_transaksi',
                'op_transaksi.nama',
                'op_transaksi.tanggal_transaksi'
            )
            ->orderByDesc('op_transaksi.tanggal_transaksi')
            ->get();
        return response()->json([
            'success' => true,
            'message' => 'Data loaded successfully',
            'data' => $pemesanan,
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

        $hutang = OpTransaksi::select(
            'op_transaksi.nomor_transaksi',
            'op_transaksi.pembayaran',
            'op_transaksi.nama',
            'op_transaksi.tanggal_transaksi',
            'op_toko_cabang.nama_toko_cabang',
            'op_transaksi.total_beli',
            'op_transaksi.jumlah_bayar_dp',
            'op_transaksi.jumlah_sisa_dp',
            'op_transaksi.jumlah_lunas_dp',
            'users.name',
            DB::raw('SUM(op_transaksi_detail.jumlah_barang) AS total_jumlah_barang'),
        )
            ->join('op_toko_cabang', 'op_transaksi.id_cabang', '=', 'op_toko_cabang.id')
            ->join('op_transaksi_detail', 'op_transaksi.nomor_transaksi', '=', 'op_transaksi_detail.nomor_transaksi')
            ->join('users', 'op_transaksi.id_user', '=', 'users.id')
            ->where('op_transaksi.status_transaksi', $request->status)
            ->where('op_transaksi.id_cabang', $request->id_cabang)
            ->whereNotIn('op_transaksi.status_transaksi', ['dibatalkan'])
            ->whereIn('op_transaksi.jenis_transaksi', ['hutang'])
            ->whereBetween('op_transaksi.tanggal_transaksi', [$startDate, $endDate])
            ->groupBy(
                'op_transaksi.nomor_transaksi',
            )
            ->orderByDesc('op_transaksi.tanggal_transaksi')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data loaded successfully',
            'data' => $hutang,
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
