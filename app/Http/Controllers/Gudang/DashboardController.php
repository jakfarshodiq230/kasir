<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\OpBarang;
use Illuminate\Http\Request;
use App\Models\OpKas;
use App\Models\OpPenjualan;
use App\Models\OpPenjualanDetail;
use App\Models\OpPesanan;
use App\Models\OpPesananDetail;
use App\Models\OpStockGudang;
use App\Models\OpTransaksi;
use App\Models\OpTransaksiDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $barangCount = OpStockGudang::where('id_gudang', Auth::user()->id_gudang)->count();
        $selesaiCount = OpTransaksiDetail::where('id_gudang', Auth::user()->id_gudang)
            ->where('status_pemesanan', 'selesai')
            ->where('pemesanan', 'ya')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $pesananCount = OpTransaksiDetail::where('id_gudang', Auth::user()->id_gudang)
            ->where('pemesanan', 'ya')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
        $topSellingItems = DB::table('op_transaksi_detail as opd')
            ->join('op_barang as b', 'opd.id_barang', '=', 'b.id')
            ->where('opd.id_cabang', Auth::check() ? Auth::user()->id_cabang : null)
            ->select('opd.id_barang', 'b.nama_produk', DB::raw('SUM(opd.jumlah_barang) as total_terjual'))
            ->groupBy('opd.id_barang', 'b.nama_produk')
            ->orderByDesc(DB::raw('SUM(opd.jumlah_barang)'))
            ->get();

        $lowestStockItems = DB::table('op_barang_cabang_stock as scs')
            ->join('op_barang as b', 'scs.id_barang', '=', 'b.id')
            ->select('scs.id', 'scs.id_barang', 'b.nama_produk', 'scs.stock_akhir', 'scs.id_cabang')
            ->where('scs.stock_akhir', '<', 10)
            ->where('scs.id_cabang', Auth::check() ? Auth::user()->id_cabang : null)
            ->orderBy('scs.stock_akhir', 'asc')
            ->get();
        return view("gudang.dashboard.dashboard", compact('barangCount', 'pesananCount', 'selesaiCount', 'topSellingItems', 'lowestStockItems'));
    }
}
