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
use App\Models\OpStockGudang;
use App\Models\OpTransaksi;
use App\Models\OpTransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Exception;

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

            // Cari transaksi berdasarkan nomor transaksi
            $transaksi = OpTransaksi::where('nomor_transaksi', $nomorTransaksi)->first();

            if (!$transaksi) {
                throw new ModelNotFoundException("Transaksi tidak ditemukan.");
            }

            // Hitung biaya yang perlu dikurangi dari kas
            $biayaRubah = match ($transaksi->jenis_transaksi) {
                'hutang' => $transaksi->status_transaksi === 'lunas' ? $transaksi->total_beli : $transaksi->jumlah_bayar_dp,
                default => $transaksi->jumlah_bayar,
            };

            // Temukan kas terkait transaksi
            $kas = OpKas::where('kode_transaksi', $transaksi->nomor_transaksi)->first();

            if ($kas) {
                // Pastikan saldo cukup untuk pembatalan
                if ($kas->saldo < $biayaRubah) {
                    throw new Exception('Saldo kas tidak mencukupi untuk pembatalan.');
                }

                // Ambil saldo terakhir
                $saldoTerakhir = OpKas::where('kode_transaksi', $kas->kode_transaksi)
                    ->where('id_cabang', $idCabang)
                    ->where('id_user', Auth::user()->id)
                    ->orderBy('tanggal', 'desc')
                    ->orderBy('id', 'desc')
                    ->first();

                $saldoAkhir = ($saldoTerakhir?->saldo ?? 0) - $biayaRubah;

                // Buat catatan kas untuk pembatalan
                OpKas::create([
                    'id_cabang' => $idCabang,
                    'id_user' => Auth::user()->id,
                    'kode_transaksi' => $kas->kode_transaksi,
                    'tanggal' => now(),
                    'keterangan' => sprintf(
                        'Saldo berkurang dari transaksi dibatalkan sebesar %s dengan nomor transaksi %s',
                        number_format($biayaRubah, 2, ',', '.'),
                        $kas->kode_transaksi
                    ),
                    'debit' => 0,
                    'kredit' => $biayaRubah,
                    'saldo' => $saldoAkhir,
                ]);
            }

            // Temukan penjualan
            $penjualan = OpTransaksi::where('nomor_transaksi', $nomorTransaksi)
                ->where('id_cabang', $idCabang)
                ->first();

            if (!$penjualan) {
                throw new ModelNotFoundException("Penjualan tidak ditemukan.");
            }

            // Temukan detail penjualan
            $detailPenjualan = OpTransaksiDetail::where('nomor_transaksi', $nomorTransaksi)
                ->where('id_cabang', $idCabang)
                ->get();

            if ($detailPenjualan->isEmpty()) {
                throw new ModelNotFoundException("Detail penjualan tidak ditemukan.");
            }

            // Perbarui status detail penjualan
            foreach ($detailPenjualan as $detail) {
                $detail->status_pemesanan = 'dibatalkan';
                $detail->save();

                // Update stock for each detail
                $this->updateBarangCabangStock($detail, $nomorTransaksi);
            }

            // Perbarui status transaksi penjualan
            $penjualan->status_transaksi = 'dibatalkan';
            $penjualan->save();

            return response()->json(['message' => 'Penjualan, detail, dan catatan kas berhasil dibatalkan.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }



    private function updateBarangCabangStock($pesanan, $nomor)
    {
        $barang = null;

        if ($pesanan->pemesanan === 'ya') {
            $barang = OpStockGudang::where('id_barang', $pesanan->id_barang)
                ->where('id_gudang', $pesanan->id_gudang)
                ->first();

            if ($barang) {
                $barang->stock_akhir += $pesanan->jumlah_barang;
                $barang->stock_keluar -= $pesanan->jumlah_barang;
                $barang->jenis_transaksi_stock = 'Dibatalkan';
                $barang->keterangan_stock_gudang = 'Penambahan Stock ' . $pesanan->jumlah_barang . ' dari Pembatalan transaksi barang dengan nomor transaksi ' . $nomor;
                $barang->save();

                $this->insertStockGudangLog($barang);
            }
        } else {
            $barang = OpBarangCabangStock::where('id_barang', $pesanan->id_barang)
                ->where('id_cabang', $pesanan->id_cabang)
                ->first();

            if ($barang) {
                $barang->stock_akhir += $pesanan->jumlah_barang;
                $barang->stock_keluar -= $pesanan->jumlah_barang;
                $barang->jenis_transaksi_stock = 'Dibatalkan';
                $barang->keterangan_stock_cabang = 'Penambahan Stock ' . $pesanan->jumlah_barang . ' dari Pembatalan transaksi barang dengan nomor transaksi ' . $nomor;
                $barang->save();

                $this->insertStockCabangLog($barang);
            }
        }

        return $barang;
    }


    private function insertStockCabangLog($barangCabangStock)
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
            'keterangan_stock_cabang' => 'Stock updated due to Penjualan cencelion' . $barangCabangStock->nomor_transaksi, // Description of the update
        ]);
    }

    private function insertStockGudangLog($barangCabangStock)
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
            'keterangan_stock_gudang' => 'Stock updated due to Penjualan cencelion' . $barangCabangStock->nomor_transaksi, // Description of the update
        ]);
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
