<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OpKas;
use App\Models\OpPenjualan;
use App\Models\OpPenjualanDetail;
use App\Models\OpPesanan;
use App\Models\OpPesananDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $user = User::where('id_toko', Auth::user()->id_toko)->count();
        $kas = OpKas::groupBy('id_cabang')
            ->select('id_cabang', DB::raw('SUM(saldo) as total_saldo'))
            ->get();
        $totalSaldo = $kas->sum('total_saldo');

        $penjualan = OpPenjualan::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->select([
                DB::raw('SUM(jumlah_bayar) as total_penjualan'),
                DB::raw("SUM(CASE
                    WHEN status_penjualan = 'belum_lunas' AND jenis_transaksi = 'hutang' THEN jumlah_sisa_dp
                    ELSE 0
                END) as total_sisa_dp")
            ])
            ->first();

        $countBarang = OpPenjualanDetail::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->select([
                DB::raw('SUM(jumlah_barang) as total_penjualan_barang'),
            ])
            ->first();
        $countPesanan = OpPesananDetail::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->select([
                DB::raw('SUM(jumlah_barang) as total_pesanan_barang'),
                DB::raw('SUM(sub_total_transaksi) as total_pesanan'),
            ])
            ->first();
        $countSelesai = OpPesanan::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('status_pemesanan', 'selesai')
            ->count();

        $topSellingItems = DB::table('op_penjualan_detail as opd')
            ->join('op_barang as b', 'opd.id_barang', '=', 'b.id')
            ->select('opd.id_barang', 'b.nama_produk', DB::raw('SUM(opd.jumlah_barang) as total_terjual'))
            ->groupBy('opd.id_barang', 'b.nama_produk')
            ->orderByDesc(DB::raw('SUM(opd.jumlah_barang)'))
            ->get();

        $lowestStockItems = DB::table('op_barang_cabang_stock as scs')
            ->join('op_barang as b', 'scs.id_barang', '=', 'b.id')
            ->select('scs.id', 'scs.id_barang', 'b.nama_produk', 'scs.stock_akhir', 'scs.id_cabang')
            ->where('scs.stock_akhir', '<', 10)
            ->orderBy('scs.stock_akhir', 'asc')
            ->get();




        return view("master.dashboard.dashboard", compact('user', 'totalSaldo', 'penjualan', 'countBarang', 'countPesanan', 'countSelesai', 'topSellingItems', 'lowestStockItems'));
    }
}
