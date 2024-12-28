<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OpBarang;
use App\Models\OpBarangCabangStock;
use App\Models\OpBarangCabangStockLog;
use App\Models\OpKas;
use App\Models\OpKategori;
use App\Models\OpPenjualan;
use App\Models\OpPenjualanDetail;
use App\Models\OpPesanan;
use App\Models\OpTransaksi;
use App\Models\OpTransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

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

        // Fetch data, grouped by 'id_transaksi' and sum the 'jumlah_barang'
        $penjualan = OpTransaksiDetail::select([
            'op_transaksi_detail.id_transaksi',
            'op_transaksi.nomor_transaksi',
            'op_transaksi.tanggal_transaksi',
            'op_transaksi.total_beli',
            'users.name as user_name',
            DB::raw('SUM(op_transaksi_detail.jumlah_barang) as total_jumlah_barang'), // Sum of jumlah_barang
        ])
            ->join('op_transaksi', 'op_transaksi.id', '=', 'op_transaksi_detail.id_transaksi')
            ->join('users', 'users.id', '=', 'op_transaksi.id_user') // Assuming this is the correct relation
            ->where('op_transaksi.id_cabang', Auth::user()->id_cabang)
            ->where('op_transaksi_detail.pemesanan', 'tidak')
            ->whereNotIn('op_transaksi_detail.status_pemesanan', ['dibatalkan'])
            ->whereBetween('op_transaksi.tanggal_transaksi', [$startDate, $endDate])
            ->groupBy('op_transaksi_detail.id_transaksi', 'op_transaksi.nomor_transaksi', 'op_transaksi.tanggal_transaksi', 'users.name')
            ->orderBy('op_transaksi.tanggal_transaksi', 'DESC')
            ->get();

        // Format data for response
        $formattedData = $penjualan->map(function ($item, $index) {
            return [
                'index' => $index + 1,
                'nomor_transaksi' => $item->nomor_transaksi,
                'user_name' => $item->user_name ?? "-",
                'tanggal_transaksi' => $item->tanggal_transaksi,
                'jumlah_barang' => $item->total_jumlah_barang ?? "-",
                'total_beli' => $item->total_beli ?? "-",
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Data loaded successfully',
            'data' => $formattedData,
        ]);
    }



    public function hapusPenjualan($nomorTransaksi)
    {
        try {
            $idCabang = Auth::user()->id_cabang;
            // Find the Penjualan record by nomor_transaksi
            $penjualan = OpTransaksi::where('nomor_transaksi', $nomorTransaksi)->where('id_cabang', $idCabang)->first();

            if (!$penjualan) {
                throw new ModelNotFoundException("Penjualan not found.");
            }

            // Delete related PenjualanDetails and update stock
            $this->updateBarangCabangStock($penjualan);

            // Delete related PenjualanDetails
            $penjualan->penjualanDetails()->delete();

            // Delete the Penjualan record
            $penjualan->delete();

            // Get all related OpKas records based on id_cabang
            $opKasRecords = OpKas::where('kode_transaksi', $penjualan->nomor_transaksi)->where('id_cabang', $idCabang)->get();

            // Delete each related OpKas record
            foreach ($opKasRecords as $opKas) {
                $opKas->delete();
            }

            // Update OpKas saldo_akhir based on cabang
            $this->updateSaldoAkhir($idCabang);

            return response()->json(['message' => 'Penjualan, its details, and related OpKas have been deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    private function updateBarangCabangStock($penjualan)
    {
        foreach ($penjualan->penjualanDetails as $penjualanDetail) {
            // Fetch the current stock for the barang (item) in the cabang (branch)
            $barangCabangStock = OpBarangCabangStock::where('id_barang', $penjualanDetail->id_barang)
                ->where('id_cabang', $penjualan->id_cabang)
                ->first();

            if ($barangCabangStock) {
                // Store the old stock values before making any updates
                $oldStockMasuk = $barangCabangStock->stock_masuk;
                $oldStockKeluar = $barangCabangStock->stock_keluar;
                $oldStockAkhir = $barangCabangStock->stock_akhir;

                // Update the stock details
                $barangCabangStock->stock_keluar -= $penjualanDetail->jumlah_barang;
                $barangCabangStock->stock_akhir = $barangCabangStock->stock_masuk - $barangCabangStock->stock_keluar;
                $barangCabangStock->save();

                // Insert a log entry to record the stock changes
                $this->insertStockLog($barangCabangStock, $oldStockMasuk, $oldStockKeluar, $oldStockAkhir);
            }
        }
    }

    private function insertStockLog($barangCabangStock, $oldStockMasuk, $oldStockKeluar, $oldStockAkhir)
    {
        // Insert the log entry into op_barang_cabang_stock_log
        OpBarangCabangStockLog::create([
            'id_barang' => $barangCabangStock->id_barang,
            'id_suplaier' => $barangCabangStock->id_suplaier,
            'id_gudang' => $barangCabangStock->id_gudang,
            'id_toko' => $barangCabangStock->id_toko,
            'id_cabang' => $barangCabangStock->id_cabang,
            'id_user' => $barangCabangStock->id_user,
            'stock_masuk' => $barangCabangStock->stock_masuk,
            'stock_keluar' => $barangCabangStock->stock_keluar,
            'stock_akhir' => $barangCabangStock->stock_akhir,
            'jenis_transaksi_stock' => 'update', // Type of transaction
            'keterangan_stock_cabang' => 'Stock updated due to Penjualan deletion' . $barangCabangStock->nomor_transaksi, // Description of the update
            'old_stock_masuk' => $oldStockMasuk, // Log the previous stock values
            'old_stock_keluar' => $oldStockKeluar,
            'old_stock_akhir' => $oldStockAkhir,
        ]);
    }

    private function updateSaldoAkhir($idCabang)
    {
        $opKasRecords = OpKas::where('id_cabang', $idCabang)->get();

        foreach ($opKasRecords as $opKas) {
            $newSaldoAkhir = $opKas->debit - $opKas->kredit;
            $opKas->saldo = $newSaldoAkhir;
            $opKas->save();
        }
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

        $penjualan = OpTransaksiDetail::select([
            'op_transaksi_detail.id_transaksi',
            'op_transaksi.nomor_transaksi',
            'op_transaksi.tanggal_transaksi',
            'op_transaksi_detail.sub_total_transaksi',
            'op_transaksi.status_transaksi',
            'op_transaksi.jumlah_bayar_dp',
            'users.name as user_name',
            DB::raw('SUM(op_transaksi_detail.jumlah_barang) as total_jumlah_barang'), // Sum of jumlah_barang
        ])
            ->join('op_transaksi', 'op_transaksi.id', '=', 'op_transaksi_detail.id_transaksi')
            ->join('users', 'users.id', '=', 'op_transaksi.id_user') // Assuming this is the correct relation
            ->where('op_transaksi.id_cabang', Auth::user()->id_cabang)
            ->where('op_transaksi_detail.pemesanan', 'ya')
            ->whereNotIn('op_transaksi_detail.status_pemesanan', ['dibatalkan'])
            ->whereBetween('op_transaksi.tanggal_transaksi', [$startDate, $endDate])
            ->groupBy('op_transaksi_detail.id_transaksi', 'op_transaksi.nomor_transaksi', 'op_transaksi.tanggal_transaksi', 'users.name')
            ->orderBy('op_transaksi.tanggal_transaksi', 'DESC')
            ->get();

        // Format data for response
        $formattedData = $penjualan->map(function ($item, $index) {
            return [
                'index' => $index + 1,
                'nomor_transaksi' => $item->nomor_transaksi,
                'user_name' => $item->user_name ?? "-",
                'tanggal_transaksi' => $item->tanggal_transaksi,
                'pembayaran' => $item->jumlah_bayar_dp,
                'jumlah_barang' => $item->total_jumlah_barang ?? "-",
                'sub_total_transaksi' => $item->sub_total_transaksi ?? "-",
                'keterangan' => $item->status_transaksi ?? "-",
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Data loaded successfully',
            'data' => $formattedData,
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

        $penjualan = OpTransaksi::where('id_cabang', Auth::user()->id_cabang)
            ->where('status_transaksi', '=', $status)
            ->where('jenis_transaksi', '=', 'hutang')
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->orderBy('tanggal_transaksi', 'DESC')
            ->with(['user', 'cabang', 'transaksidetail'])
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
