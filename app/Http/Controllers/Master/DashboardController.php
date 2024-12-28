<?php

namespace App\Http\Controllers\Master;

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
        $user = User::where('id_toko', Auth::user()->id_toko)
            ->whereNotIn('level_user', ['owner'])
            ->whereNotNull('created_at')
            ->count();

        $kas = OpKas::select('id_cabang', 'saldo')
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)') // Get the latest id for each id_cabang
                    ->from('op_kas as sub')
                    ->whereColumn('sub.id_cabang', 'op_kas.id_cabang')
                    ->groupBy('sub.id_cabang'); // Group by id_cabang to get the most recent entry
            })
            ->orderBy('created_at', 'desc') // Order by created_at in descending order
            ->get();

        $totalSaldo = $kas->sum('saldo');

        $penjualan = OpTransaksi::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->select([
                DB::raw('SUM(jumlah_bayar) as total_penjualan'),
                DB::raw("SUM(CASE
                    WHEN status_transaksi = 'belum_lunas' AND jenis_transaksi = 'hutang' THEN jumlah_sisa_dp
                    ELSE 0
                END) as total_sisa_dp")
            ])
            ->first();

        $countBarang = OpTransaksiDetail::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('pemesanan', 'tidak')
            ->select([
                DB::raw('SUM(jumlah_barang) as total_penjualan_barang'),
            ])
            ->first();
        $countPesanan = OpTransaksiDetail::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('pemesanan', 'ya')
            ->select([
                DB::raw('SUM(jumlah_barang) as total_pesanan_barang'),
                DB::raw('SUM(sub_total_transaksi) as total_pesanan'),
            ])
            ->first();
        $countSelesai = OpTransaksiDetail::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('pemesanan', 'ya')
            ->where('status_pemesanan', 'selesai')
            ->count();

        $topSellingItems = DB::table('op_transaksi_detail as opd')
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
