<?php

namespace App\Http\Controllers\Gudang;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OpBarang;
use App\Models\OpDetailBarang;
use App\Models\OpSuplaier;
use App\Models\OpStockGudang;
use App\Models\OpStockGudangLog;

class StockController extends Controller
{
    public function index()
    {
        return view("gudang.stock.barang");
    }

    public function addStock()
    {
        $suplaier = OpSuplaier::all();
        return view('gudang.stock.add', compact('suplaier'));
    }

    public function DataStockJson()
    {
        $id_gudang = Auth::user()->id_gudang;
        $barang = OpStockGudang::where('id_gudang', $id_gudang)->with(['barang', 'suplaier'])->get();
        return response()->json(['message' => 'Data get successfully', 'data' => $barang]);
    }

    public function DataGetBarang($KodeBarang)
    {
        $id_gudang = Auth::user()->id_gudang;

        $barang = OpBarang::where('id_gudang', $id_gudang)
            ->where('kode_produk', $KodeBarang)
            ->with(['opBarangDetails', 'kategori', 'gudang'])
            ->first();

        if (!$barang) {
            return response()->json([
                'message' => 'Barang tidak ditemukan',
                'data' => null,
                'detail' => null
            ], 404);
        }

        $detail_barang = OpDetailBarang::with(['jenis', 'type'])
            ->where('id_barang', $barang->id)
            ->first();

        return response()->json([
            'message' => 'Data retrieved successfully',
            'data' => $barang,
            'detail' => $detail_barang
        ]);
    }


    public function store(Request $request)
    {

        // tabel op_stock_gudang
        $request->validate([
            // tabel produk
            'id_barang' => 'required|string',
            'id_suplaier' => 'required|string|max:255',
            'id_gudang' => 'required',
            'jenis_transaksi_stock' => 'required|string',
            'jumlah_barang' => 'required|integer',
            'id_user' => 'required|string',
        ]);

        // Retrieve the current stock of the product
        $currentStock = OpStockGudang::where('id_barang', $request->id_barang)
            ->where('id_gudang', $request->id_gudang)
            ->first();

        if ($currentStock) {
            if ($request->jenis_transaksi_stock == 'masuk') {
                $currentStock->stock_masuk += $request->jumlah_barang;
                $currentStock->keterangan_stock_gudang = 'Masuk stock barang masuk: ' . $request->jumlah_barang;
            } else if ($request->jenis_transaksi_stock == 'pengiriman') {
                $currentStock->stock_keluar += $request->jumlah_barang;
                $currentStock->keterangan_stock_gudang = 'Pengiriman stock barang keluar: ' . $request->jumlah_barang;
            }

            $currentStock->stock_akhir = $currentStock->stock_masuk - $currentStock->stock_keluar;

            $currentStock->save();
        } else {
            OpStockGudang::create([
                'id_barang' => $request->id_barang,
                'id_suplaier' => $request->id_suplaier,
                'id_gudang' => $request->id_gudang,
                'stock_masuk' => $request->jenis_transaksi_stock == 'masuk' ? $request->jumlah_barang : 0,
                'stock_keluar' => $request->jenis_transaksi_stock == 'pengiriman' ? $request->jumlah_barang : 0,
                'stock_akhir' => ($request->jenis_transaksi_stock == 'masuk' ? $request->jumlah_barang : 0) - ($request->jenis_transaksi_stock == 'pengiriman' ? $request->jumlah_barang : 0),
                'jenis_transaksi_stock' => $request->jenis_transaksi_stock,
                'keterangan_stock_gudang' => $request->jenis_transaksi_stock == 'masuk' ?
                    'Masuk stock barang masuk: ' . $request->jumlah_barang :
                    'Pengiriman stock barang keluar: ' . $request->jumlah_barang,
                'id_user' => $request->id_user,
            ]);
        }


        // tabel log
        $latestStock = OpStockGudangLog::where('id_barang', $request->id_barang)
            ->where('id_gudang', $request->id_gudang)
            ->orderBy('created_at', 'desc')
            ->first();

        $stockAkhir = 0;
        if ($latestStock) {
            $stockAkhir = $latestStock->stock_akhir;

            if ($request->jenis_transaksi_stock == 'masuk') {
                $stockAkhir += $request->jumlah_barang;
            } elseif ($request->jenis_transaksi_stock == 'pengiriman') {
                $stockAkhir -= $request->jumlah_barang;
            }
        } else {
            if ($request->jenis_transaksi_stock == 'masuk') {
                $stockAkhir = $request->jumlah_barang;
            } else {
                $stockAkhir = 0;
            }
        }

        $barang = OpStockGudangLog::create([
            'id_barang' => $request->id_barang,
            'id_suplaier' => $request->id_suplaier,
            'id_gudang' => $request->id_gudang,
            'stock_masuk' => $request->jenis_transaksi_stock == 'masuk' ? $request->jumlah_barang : 0,
            'stock_keluar' => $request->jenis_transaksi_stock == 'pengiriman' ? $request->jumlah_barang : 0,
            'stock_akhir' => $stockAkhir, // Set the calculated stock_akhir
            'jenis_transaksi_stock' => $request->jenis_transaksi_stock,
            'keterangan_stock_gudang' => $request->jenis_transaksi_stock == 'masuk' ?
                'Masuk stock barang masuk: ' . $request->jumlah_barang :
                'Pengiriman stock barang keluar: ' . $request->jumlah_barang,
            'id_user' => $request->id_user,
        ]);

        return response()->json(['success' => true, 'message' => 'Data recorded successfully', 'data' => $barang]);
    }

    public function viewLog()
    {
        return view("gudang.stock.log");
    }

    public function DataStockRiwayatJson()
    {
        $id_gudang = Auth::user()->id_gudang;
        $barang = OpStockGudangLog::where('id_gudang', $id_gudang)->with(['barang', 'suplaier'])->get();
        return response()->json(['message' => 'Data get successfully', 'data' => $barang]);
    }

    public function destroy($id)
    {
        $log = OpStockGudangLog::find($id);

        if (!$log) {
            return response()->json(['success' => false, 'message' => 'Data not found.'], 404);
        }

        // Hapus log yang dipilih
        $log->delete();

        // Ambil semua log yang relevan (dengan id_barang dan id_gudang yang sama)
        $logsToUpdate = OpStockGudangLog::where('id_barang', $log->id_barang)
            ->where('id_gudang', $log->id_gudang)
            ->orderBy('id', 'asc')
            ->get();

        $currentStockAkhir = 0;

        // Hitung ulang stock_akhir untuk setiap log
        foreach ($logsToUpdate as $updateLog) {
            if ($updateLog->jenis_transaksi_stock == 'masuk') {
                $currentStockAkhir += $updateLog->stock_masuk;
            } elseif ($updateLog->jenis_transaksi_stock == 'pengiriman') {
                $currentStockAkhir -= $updateLog->stock_keluar;
            }
            $updateLog->stock_akhir = $currentStockAkhir;
            $updateLog->save();
        }

        // Update OpStockGudang berdasarkan log terakhir
        $lastLog = $logsToUpdate->last();

        $stockGudang = OpStockGudang::where('id_barang', $log->id_barang)
            ->where('id_gudang', $log->id_gudang)
            ->first();

        if ($stockGudang) {
            $stockGudang->stock_masuk = $logsToUpdate->where('jenis_transaksi_stock', 'masuk')->sum('stock_masuk');
            $stockGudang->stock_keluar = $logsToUpdate->where('jenis_transaksi_stock', 'pengiriman')->sum('stock_keluar');
            $stockGudang->stock_akhir = $lastLog ? $lastLog->stock_akhir : 0;
            $stockGudang->keterangan_stock_gudang = "Data telah diperbarui setelah penghapusan log.";
            $stockGudang->save();
        }

        return response()->json(['success' => true, 'message' => 'Data deleted and stock_akhir recalculated.']);
    }



    public function destroyStock($id)
    {
        $stock = OpStockGudang::find($id);

        if (!$stock) {
            return response()->json(['success' => false, 'message' => 'Data not found.'], 404);
        }

        // Hapus semua log terkait
        $stock->logs()->delete();

        // Hapus data OpStockGudang
        $stock->delete();

        return response()->json(['success' => true, 'message' => 'Data and related logs deleted successfully.']);
    }
}
