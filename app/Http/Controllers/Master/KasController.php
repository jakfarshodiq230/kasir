<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OpCabang;
use App\Models\OpKas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasController extends Controller
{
    public function index()
    {
        $cabang = OpCabang::where('id_toko', Auth::user()->id_toko)->get();
        return view("master.kas.kas", compact('cabang'));
    }

    public function GatDataKas(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'id_cabang' => 'required',
        ]);

        $startDate = Carbon::parse($request->startDate)->startOfDay()->toDateTimeString();
        $endDate = Carbon::parse($request->endDate)->endOfDay()->toDateTimeString();

        $kas = OpKas::where('id_cabang', $request->id_cabang)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'asc')
            ->with(['users', 'cabang'])
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data loaded successfully',
            'data' => $kas,
        ]);
    }

    public function Rekap()
    {
        $cabang = OpCabang::where('id_toko', Auth::user()->id_toko)->get();
        return view("master.kas.rekap", compact('cabang'));
    }

    public function getFinancialDataByBranchAndYear(Request $request)
    {
        // Validate request parameters
        $validated = $request->validate([
            'id_cabang' => 'required|integer',
            'tahun' => 'required|integer|min:2000|max:2100',
        ]);

        $idCabang = $validated['id_cabang'];
        $tahun = $validated['tahun'];

        // Retrieve data from database
        $data = OpKas::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('SUM(debit) as total_debit'),
            DB::raw('SUM(kredit) as total_kredit'),
            DB::raw('SUM(saldo) as total_saldo'),
            DB::raw('MAX(id) as max_id'), // Get the max id for each month
            DB::raw('MAX(created_at) as latest_created_at') // Get the latest created_at for each month
        )
            ->where('id_cabang', $idCabang)
            ->whereYear('tanggal', $tahun)
            ->groupBy(DB::raw('MONTH(tanggal)'))
            ->orderBy(DB::raw('MONTH(tanggal)'))
            ->get();

        // Format the data
        $formattedData = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthData = $data->firstWhere('bulan', $month);

            $formattedData[] = [
                'bulan' => $month,
                'total_debit' => $monthData->total_debit ?? 0,
                'total_kredit' => $monthData->total_kredit ?? 0,
                'total_saldo' => $monthData->total_saldo ?? 0,
                'max_id' => $monthData->max_id ?? null,
                'latest_created_at' => $monthData->latest_created_at ?? null,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Data loaded successfully',
            'data' => $formattedData,
        ]);
    }

    public function RekapPenjualan()
    {
        $cabang = OpCabang::where('id_toko', Auth::user()->id_toko)->get();
        return view("master.kas.penjualan", compact('cabang'));
    }

    public function getSalesAndProductDataByYearAndBranch(Request $request)
    {
        // Validate the request parameters
        $validated = $request->validate([
            'id_cabang' => 'required|integer',
            'tahun' => 'required|integer|min:2000|max:2100',
            'jenis_transaksi' => 'required|string',
        ]);

        $idCabang = $validated['id_cabang'];
        $tahun = $validated['tahun'];
        $jenis = $validated['jenis_transaksi'];

        // Get sales and product data grouped by month
        $data = DB::table('op_penjualan_detail as opd')
            ->join('op_barang_harga as obh', 'opd.id_barang', '=', 'obh.id')
            ->join('op_penjualan as op', 'opd.nomor_transaksi', '=', 'op.nomor_transaksi') // Fix join condition
            ->select(
                DB::raw('MONTH(opd.created_at) as bulan'),
                DB::raw('SUM(obh.harga_modal * opd.jumlah_barang) as total_harga_modal'),
                DB::raw('SUM(opd.harga_barang * opd.jumlah_barang) as total_harga_barang'),
                DB::raw('SUM(opd.jumlah_barang) as total_jumlah_beli'),
                DB::raw('SUM(opd.harga_barang * opd.jumlah_barang) - SUM(obh.harga_modal * opd.jumlah_barang) as laba_kotor'),
                DB::raw('SUM(op.jumlah_bayar_dp) as jumlah_bayar_dp'),
                DB::raw('SUM(op.jumlah_sisa_dp) as jumlah_sisa_dp'),
                DB::raw('SUM(op.jumlah_lunas_dp) as jumlah_lunas_dp'),
                DB::raw('SUM(op.total_beli) as jumlah_pembelian')
            )
            ->whereYear('opd.created_at', $tahun)
            ->where('opd.id_cabang', $idCabang)
            ->where('op.jenis_transaksi', $jenis)
            ->groupBy(DB::raw('MONTH(opd.created_at)'))
            ->orderBy(DB::raw('MONTH(opd.created_at)'))
            ->get();


        // Month names in Indonesian
        $bulanIndo = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        // Prepare an array to store all 12 months data
        $formattedData = [];

        // Initialize the formatted data array for all 12 months
        for ($month = 1; $month <= 12; $month++) {
            // Find the data for the current month (if any)
            $monthData = $data->firstWhere('bulan', $month);

            // Add the data for the month (or zero values if no data)
            if ($jenis == 'hutang') {
                $jumlah_sisa_dp = ($monthData && $monthData->jumlah_sisa_dp !== null) ? $monthData->jumlah_sisa_dp : 0;
                $laba_kotor_utang = ($monthData && $monthData->laba_kotor !== null) ? $monthData->laba_kotor : 0;

                $total_laba_koto_hutang = $laba_kotor_utang - $jumlah_sisa_dp;
                $formattedData[] = [
                    'bulan' => $bulanIndo[$month - 1],
                    'total_harga_modal' => $monthData ? $monthData->total_harga_modal : 0,
                    'total_harga_barang' => $monthData ? $monthData->total_harga_barang : 0,
                    'total_jumlah_beli' => $monthData ? $monthData->total_jumlah_beli : 0,
                    'total_laba_koto_hutang' => $total_laba_koto_hutang = $laba_kotor_utang ? 0 : $total_laba_koto_hutang,
                    'laba_kotor' => $monthData ? $monthData->laba_kotor : 0,
                    'harga_modal' => $monthData ? $monthData->total_harga_modal : 0,
                    'jumlah_bayar_dp' => $monthData ? $monthData->jumlah_bayar_dp : 0,
                    'jumlah_sisa_dp' => $monthData ? $monthData->jumlah_sisa_dp : 0,
                    'jumlah_lunas_dp' => $monthData ? $monthData->jumlah_lunas_dp : 0,
                    'jumlah_pembelian' => $monthData ? $monthData->jumlah_pembelian : 0,
                ];
            } else {
                $formattedData[] = [
                    'bulan' => $bulanIndo[$month - 1],
                    'total_harga_modal' => $monthData ? $monthData->total_harga_modal : 0,
                    'total_harga_barang' => $monthData ? $monthData->total_harga_barang : 0,
                    'total_jumlah_beli' => $monthData ? $monthData->total_jumlah_beli : 0,
                    'laba_kotor' => $monthData ? $monthData->laba_kotor : 0,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Data loaded successfully',
            'data' => $formattedData,
        ]);
    }
}
