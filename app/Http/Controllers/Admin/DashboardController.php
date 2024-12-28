<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OpKas;
use App\Models\OpPenjualan;
use App\Models\OpPenjualanDetail;
use App\Models\OpPesanan;
use App\Models\OpPesananDetail;
use App\Models\OpTransaksi;
use App\Models\OpTransaksiDetail;
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
        $user = User::where('id_cabang', Auth::user()->id_cabang)->count();
        $kas = OpKas::where('id_cabang', Auth::user()->id_cabang)
            //->whereDate('created_at', Carbon::today())
            ->orderBy('id', 'DESC')
            ->first();


        $penjualan = OpTransaksi::where('id_cabang', Auth::user()->id_cabang)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->select([
                DB::raw("SUM(CASE
                    WHEN status_transaksi = 'belum_lunas' AND jenis_transaksi = 'hutang' THEN jumlah_sisa_dp
                    ELSE 0
                END) as total_sisa_dp"),
                DB::raw("SUM(CASE
                    WHEN status_transaksi = 'lunas' AND jenis_transaksi = 'non_hutang' THEN total_beli
                    ELSE 0
                END) as total_penjualan")
            ])
            ->first();

        $countBarang = OpTransaksiDetail::where('id_cabang', Auth::user()->id_cabang)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->select([
                DB::raw("SUM(CASE
                    WHEN pemesanan = 'tidak' AND status_pemesanan !='dibatalkan' THEN jumlah_barang
                    ELSE 0
                END) as total_penjualan_barang")
            ])
            ->first();
        $countPesanan = OpTransaksiDetail::where('id_cabang', Auth::user()->id_cabang)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->select([
                DB::raw("SUM(CASE
                    WHEN pemesanan = 'iya' AND status_pemesanan != 'dibatalkan' THEN jumlah_barang
                    ELSE 0
                END) as total_pesan_barang"),
                DB::raw("SUM(CASE
                    WHEN pemesanan = 'iya' AND status_pemesanan != 'dibatalkan' THEN sub_total_transaksi
                    ELSE 0
                END) as total_pesanan")
            ])
            ->first();
        $countSelesai = OpTransaksi::where('id_cabang', Auth::user()->id_cabang)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('status_transaksi', 'lunas')
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




        return view("admin.dashboard.dashboard", compact('user', 'kas', 'penjualan', 'countBarang', 'countPesanan', 'countSelesai', 'topSellingItems', 'lowestStockItems'));
    }
}
