<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OpCabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GrafikController extends Controller
{
    public function Index()
    {
        $cabang = OpCabang::where('id_toko', Auth::user()->id_toko)->get();
        return view("master.dashboard.grafik", compact('cabang'));
    }

    public function getJumlahBarang(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_cabang' => 'required|integer',
            'tahun' => 'required|integer',
        ]);

        // Ambil input dari request
        $idCabang = $request->input('id_cabang');
        $tahun = $request->input('tahun');

        // Query untuk menghitung jumlah barang
        $data = DB::table('op_transaksi_detail')
            ->selectRaw('
                MONTH(created_at) AS bulan,
                SUM(CASE WHEN pemesanan = "ya" THEN jumlah_barang ELSE 0 END) AS pemesanan_ya,
                SUM(CASE WHEN pemesanan = "tidak" THEN jumlah_barang ELSE 0 END) AS pemesanan_tidak
            ')
            ->where('id_cabang', $idCabang)
            ->whereYear('created_at', $tahun)
            ->where('status_pemesanan', '!=', 'dibatalkan')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        // Inisialisasi array dengan semua bulan (1-12)
        $result = array_fill(1, 12, [
            'pemesanan_ya' => 0,
            'pemesanan_tidak' => 0,
        ]);

        // Map data query ke dalam array bulan
        foreach ($data as $item) {
            $result[$item->bulan]['pemesanan_ya'] = $item->pemesanan_ya;
            $result[$item->bulan]['pemesanan_tidak'] = $item->pemesanan_tidak;
        }

        // Format array menjadi dua dataset
        $pemesananYa = [];
        $pemesananTidak = [];
        $labels = [];
        foreach ($result as $bulan => $values) {
            $pemesananYa[] = $values['pemesanan_ya'];
            $pemesananTidak[] = $values['pemesanan_tidak'];
            $labels[] = $this->getMonthName($bulan); // Get the month name or number
        }

        // Kembalikan data dalam format JSON
        return response()->json([
            'success' => true,
            'data' => [
                'labels' => $labels,
                'dataset1' => $pemesananYa,
                'dataset2' => $pemesananTidak,
            ],
        ]);
    }

    // Helper function to get month name or number
    private function getMonthName($month)
    {
        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];
        return $months[$month] ?? '';
    }
    public function getSaldoPerMonth(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_cabang' => 'required|integer',
            'tahun' => 'required|integer',
        ]);

        // Ambil input dari request
        $idCabang = $request->input('id_cabang');
        $tahun = $request->input('tahun');

        // Daftar bulan 1-12
        $months = range(1, 12);

        // Query untuk mendapatkan saldo per bulan
        $query = DB::table('op_kas');

        // Tambahkan kolom saldo untuk setiap bulan
        foreach ($months as $month) {
            $query->addSelect(DB::raw("MAX(CASE WHEN MONTH(tanggal) = $month THEN saldo ELSE 0 END) AS saldo_$month"));
        }

        // Filter berdasarkan tahun dan id_cabang
        $query->whereYear('tanggal', $tahun)
            ->where('id_cabang', $idCabang);

        // Subquery untuk mendapatkan id terbaru per bulan
        $query->whereIn('id', function ($subQuery) use ($tahun, $idCabang) {
            $subQuery->select(DB::raw('MAX(id)'))
                ->from('op_kas')
                ->whereYear('tanggal', $tahun)
                ->where('id_cabang', $idCabang)
                ->groupBy(DB::raw('MONTH(tanggal)'));
        });

        // Eksekusi query
        $results = $query->get();

        // Inisialisasi array dengan semua bulan (1-12)
        $result = array_fill(1, 12, 0);

        // Map data query ke dalam array bulan
        foreach ($results as $item) {
            foreach ($months as $month) {
                $result[$month] = $item->{'saldo_' . $month};
            }
        }

        // Format array menjadi satu dataset
        $saldo = [];
        $labels = [];
        foreach ($months as $month) {
            $saldo[] = $result[$month];
            $labels[] = $this->getMonthName($month);
        }

        // Kembalikan data dalam format JSON
        return response()->json([
            'success' => true,
            'data' => [
                'labels' => $labels,
                'dataset1' => $saldo,
            ],
        ]);
    }

    public function getJumlahUtang(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_cabang' => 'required|integer',
            'tahun' => 'required|integer',
        ]);

        // Ambil input dari request
        $idCabang = $request->input('id_cabang');
        $tahun = $request->input('tahun');

        // Query untuk menghitung jumlah hutang dan non-hutang berdasarkan kondisi jenis_transaksi dan status_transaksi
        $data = DB::table('op_transaksi')
            ->selectRaw('
            MONTH(created_at) AS bulan,
            SUM(CASE
                    WHEN jenis_transaksi = "non_hutang" AND status_transaksi = "lunas" THEN total_beli
                    WHEN jenis_transaksi = "hutang" AND status_transaksi = "lunas" THEN (jumlah_sisa_dp + jumlah_lunas_dp)
                    ELSE 0
                END) AS non_hutang,
            SUM(CASE
                    WHEN jenis_transaksi = "hutang" AND status_transaksi != "lunas" THEN jumlah_sisa_dp
                    ELSE 0
                END) AS hutang
        ')
            ->where('id_cabang', $idCabang)
            ->whereYear('created_at', $tahun)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        // Inisialisasi array dengan semua bulan (1-12)
        $result = array_fill(1, 12, [
            'non_hutang' => 0,
            'hutang' => 0,
        ]);

        // Map data query ke dalam array bulan
        foreach ($data as $item) {
            $result[$item->bulan]['non_hutang'] = $item->non_hutang;
            $result[$item->bulan]['hutang'] = $item->hutang;
        }

        // Format array menjadi dua dataset
        $nonHutang = [];
        $hutang = [];
        $labels = [];
        foreach ($result as $bulan => $values) {
            $nonHutang[] = $values['non_hutang'];
            $hutang[] = $values['hutang'];
            $labels[] = $this->getMonthName($bulan); // Get the month name or number
        }

        // Kembalikan data dalam format JSON
        return response()->json([
            'success' => true,
            'data' => [
                'labels' => $labels,
                'dataset1' => $nonHutang,
                'dataset2' => $hutang,
            ],
        ]);
    }
}
