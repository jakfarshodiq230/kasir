<?php

namespace App\Http\Controllers\Kasir;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OpBarang;
use App\Models\OpBarangCabangStock;
use App\Models\OpBarangCabangStockLog;
use App\Models\OpKas;
use App\Models\OpPenjualan;
use App\Models\OpPenjualanDetail;
use App\Models\OpPesanan;
use App\Models\OpPesananCart;
use App\Models\OpPesananDetail;
use App\Models\OpPesananLog;
use App\Models\OpSetingLensa;
use App\Models\OpStockGudang;
use App\Models\OpTransaksi;
use App\Models\OpTransaksiCart;
use App\Models\OpTransaksiDetail;
use App\Models\OpTransaksiLog;
use Illuminate\Support\Facades\DB;
use Exception;

class TransaksiController extends Controller
{
    public function generateNextProductCodePesnan($date)
    {
        $year = date('Y', strtotime($date));
        $day = date('d', strtotime($date));
        $month = date('m', strtotime($date));

        $highestCode = OpTransaksi::whereDate('created_at', '=', date('Y-m-d', strtotime($date)))
            ->orderByRaw('CAST(SUBSTRING(nomor_transaksi, -4) AS UNSIGNED) DESC')
            ->value('nomor_transaksi');
        if ($highestCode) {
            $serialNumber = (int)substr($highestCode, -4) + 1;
        } else {
            $serialNumber = 1;
        }

        $productCode = $year . $day . $month . '-' . Auth::user()->id_cabang . '-' . str_pad($serialNumber, 4, '0', STR_PAD_LEFT);
        return $productCode;
    }

    public function transaksi()
    {
        $id_toko = Auth::user()->id_toko;
        $date = now();
        $nomor_transaksi = $this->generateNextProductCodePesnan($date);
        $seting = OpSetingLensa::first();
        // $barang = OpBarangCabangStock::where('id_toko', $id_toko)->with(['barang', 'gudang'])->get();
        $barang = DB::table('op_barang_cabang_stock as obs')
            ->join('op_barang as ob', 'obs.id_barang', '=', 'ob.id')
            ->join('op_gudang as og', 'obs.id_gudang', '=', 'og.id')
            ->join('op_kategori as ok', 'ob.id_kategori', '=', 'ok.id')
            ->where('obs.id_toko', $id_toko)
            ->select(
                'obs.id_toko',
                'ob.kode_produk',
                'obs.id_barang',
                'obs.id_gudang',
                'obs.stock_akhir',
                'obs.id_cabang',
                'ob.nama_produk',
                'ok.pesanan',
                'og.nama_gudang',
            )
            ->get();
        //return response()->json(['success' => true, 'message' => 'Item deleted successfully', 'data' => $barang]);
        return view("kasir.transaksi-pesanan", compact('nomor_transaksi', 'seting', 'barang'));
    }

    public function hargaBarang($id, $KodeProduk)
    {
        $barang = OpBarang::where('id', $id)
            ->where('kode_produk', $KodeProduk)
            ->with('harga')
            ->first();

        if (!$barang) {
            return response()->json(['error' => 'Barang not found'], 404);
        }

        if (!$barang->harga) {
            return response()->json(['error' => 'Harga not found for this barang'], 404);
        }

        $harga = $barang->harga;

        // Format data harga
        $hargaOptions = [
            ['id' => 'harga_jual', 'Ket' => 'Harga Jual', 'price' => $harga->harga_jual],
            ['id' => 'harga_grosir_1', 'Ket' => 'Harga Grosir 1', 'price' => $harga->harga_grosir_1],
            ['id' => 'harga_grosir_2', 'Ket' => 'Harga Grosir 2', 'price' => $harga->harga_grosir_2],
            ['id' => 'harga_grosir_3', 'Ket' => 'Harga Grosir 3', 'price' => $harga->harga_grosir_3],
            ['id' => 'harga_lainya', 'Ket' => 'Lainya', 'price' => 0],
        ];
        return response()->json(['message' => 'Data get successfully', 'data' => $hargaOptions]);
    }

    public function DataTransaksiCart(Request $request)
    {
        $id_cabang = Auth::user()->id_cabang;
        $id_user = Auth::user()->id;
        $dataCart = OpTransaksiCart::where('id_cabang', $id_cabang)->where('id_user', $id_user)->with(['barang', 'gudang'])->get();
        return response()->json(['message' => 'Data get successfully', 'data' => $dataCart]);
    }

    public function simpanTransaksi(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|string|max:255',
            'jumlah_beli' => 'required|integer',
            'sub_total' => 'required|numeric',
            'id_gudang' => 'required|numeric',
            'jenis_pesan' => 'required|in:ya,tidak',
        ]);

        if ($request->harga == 0) {
            $harga = $request->harga_lainya;
        } else {
            $harga = $request->harga;
        }


        $dataCart = OpTransaksiCart::create([
            'id_barang' => $request->id,
            'id_cabang' => Auth::user()->id_cabang,
            'id_user' => Auth::user()->id,
            'id_gudang' => $request->id_gudang,
            'kode_produk' => $request->kode_produk,
            'pesanan' => $request->jenis_pesan,
            'harga' => $harga,
            'jumlah_beli' => $request->jumlah_beli,
            'sub_total' => $request->sub_total,
        ]);
        return response()->json(['success' => true, 'message' => 'Data get successfully', 'data' => $dataCart]);
    }

    public function deleteCartTransaksi($id, Request $request)
    {
        $item = OpTransaksiCart::findOrFail($id);
        $item->delete();
        return response()->json(['success' => true, 'message' => 'Item deleted successfully']);
    }

    public function simpanTransaksiFinal(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nomor_transaksi' => 'required|string|max:50|unique:op_transaksi,nomor_transaksi',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'id_user' => 'required|integer|exists:users,id',
            'phone_transaksi' => 'required|string|max:15',
            'diameter' => 'nullable|numeric',
            'warna' => 'nullable|string|max:50',
            'tanggal_transaksi' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_transaksi',
            'tanggal_ambil' => 'required|date|after_or_equal:tanggal_selesai',
            'pembayaran' => 'required|string|in:tunai,transfer',
            'jenis_transaksi' => 'required|string|in:non_hutang,hutang',
            'total_beli' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0|max:100',
            'jumlah_bayar' => 'required|numeric|min:0',
            'sisa_bayar' => 'required|numeric|min:0',
            'r_sph' => 'nullable|numeric',
            'l_sph' => 'nullable|numeric',
            'r_cyl' => 'nullable|numeric',
            'l_cyl' => 'nullable|numeric',
            'r_axs' => 'nullable|integer',
            'l_axs' => 'nullable|integer',
            'r_add' => 'nullable|numeric',
            'l_add' => 'nullable|numeric',
            'pd' => 'nullable|numeric',
            'pd2' => 'nullable|numeric',
        ]);

        try {
            // Simpan data transaksi
            $data = [
                'nomor_transaksi' => $validatedData['nomor_transaksi'],
                'nama' => $validatedData['nama'],
                'alamat' => $validatedData['alamat'],
                'id_user' => $validatedData['id_user'],
                'id_cabang' => Auth::user()->id_cabang,
                'phone_transaksi' => $validatedData['phone_transaksi'],
                'diameter' => $validatedData['diameter'] ?? null,
                'warna' => $validatedData['warna'] ?? null,
                'tanggal_transaksi' => $validatedData['tanggal_transaksi'],
                'tanggal_selesai' => $validatedData['tanggal_selesai'] ?? null,
                'tanggal_ambil' => $validatedData['tanggal_ambil'] ?? null,
                'pembayaran' => $validatedData['pembayaran'],
                'jenis_transaksi' => $validatedData['jenis_transaksi'],
                'total_beli' => $validatedData['total_beli'],
                'diskon' => $validatedData['diskon'] ?? 0,
                'R_SPH' => $validatedData['r_sph'] ?? null,
                'L_SPH' => $validatedData['l_sph'] ?? null,
                'R_CYL' => $validatedData['r_cyl'] ?? null,
                'L_CYL' => $validatedData['l_cyl'] ?? null,
                'R_AXS' => $validatedData['r_axs'] ?? null,
                'L_AXS' => $validatedData['l_axs'] ?? null,
                'R_ADD' => $validatedData['r_add'] ?? null,
                'L_ADD' => $validatedData['l_add'] ?? null,
                'PD' => $validatedData['pd'] ?? null,
                'PD2' => $validatedData['pd2'] ?? null,
            ];

            if ($validatedData['jenis_transaksi'] === 'non_hutang') {
                // For 'non_hutang' type, include 'jumlah_bayar' and 'sisa_bayar'
                $data['jumlah_bayar'] = $validatedData['jumlah_bayar'] ?? 0;
                $data['sisa_bayar'] = $validatedData['sisa_bayar'];
                $data['status_transaksi'] = 'lunas';
                if ($validatedData['pembayaran'] === 'tunai') {
                    $saldoTerakhir = OpKas::where('id_cabang', Auth::user()->id_cabang)
                        ->where('id_user', Auth::user()->id)
                        ->orderBy('tanggal', 'desc')
                        ->orderBy('id', 'desc')
                        ->first();

                    $saldoTerakhirKredit = 0; // Nilai kredit terakhir atau 0 jika null
                    // $saldoTerakhirKredit = $saldoTerakhir?->kredit ?? 0;
                    $saldo = ($saldoTerakhir?->saldo ?? 0) + $request->jumlah_bayar - $saldoTerakhirKredit; // Hitung saldo akhir

                    OpKas::create([
                        'id_cabang' => Auth::user()->id_cabang, // ID cabang pengguna saat ini
                        'id_user' => Auth::user()->id, // ID pengguna saat ini
                        'kode_transaksi' => $request->nomor_transaksi, // Kode transaksi dari request
                        'tanggal' => now(), // Tanggal sekarang
                        'keterangan' => 'Saldo tambahan dari transaksi penjualan ' . $request->pembayaran . ' dengan nomor transaksi ' . $request->nomor_transaksi,
                        'debit' => $request->jumlah_bayar, // Debit diisi dengan jumlah bayar
                        'kredit' => $saldoTerakhirKredit, // Kredit diisi dengan nilai kredit terakhir
                        'saldo' => $saldo, // Saldo diisi dengan hasil perhitungan
                    ]);
                }
            } else {
                // For other transaction types, include 'jumlah_bayar_dp', 'jumlah_sisa_dp', and 'jumlah_lunas_dp'
                $data['jumlah_bayar_dp'] = $validatedData['jumlah_bayar'] ?? 0;
                $data['jumlah_sisa_dp'] = $validatedData['sisa_bayar'] ?? 0;
                $data['jumlah_lunas_dp'] = $validatedData['jumlah_lunas_dp'] ?? 0;
                $data['status_transaksi'] = 'belum_lunas';
                if ($validatedData['pembayaran'] === 'tunai') {
                    $saldoTerakhir = OpKas::where('id_cabang', Auth::user()->id_cabang)
                        ->where('id_user', Auth::user()->id)
                        ->orderBy('tanggal', 'desc')
                        ->orderBy('id', 'desc')
                        ->first();

                    // $saldoTerakhirKredit = $saldoTerakhir?->kredit ?? 0; // Nilai kredit terakhir atau 0 jika null
                    $saldoTerakhirKredit = 0;
                    $saldo = ($saldoTerakhir?->saldo ?? 0) + $request->jumlah_bayar - $saldoTerakhirKredit; // Hitung saldo akhir

                    OpKas::create([
                        'id_cabang' => Auth::user()->id_cabang, // ID cabang pengguna saat ini
                        'id_user' => Auth::user()->id, // ID pengguna saat ini
                        'kode_transaksi' => $request->nomor_transaksi, // Kode transaksi dari request
                        'tanggal' => now(), // Tanggal sekarang
                        'keterangan' => 'Saldo tambahan dari transaksi penjualan dengan status utang ' . $request->pembayaran . ' dengan nomor transaksi ' . $request->nomor_transaksi,
                        'debit' => $request->jumlah_bayar, // Debit diisi dengan jumlah bayar
                        'kredit' => $saldoTerakhirKredit, // Kredit diisi dengan nilai kredit terakhir
                        'saldo' => $saldo, // Saldo diisi dengan hasil perhitungan
                    ]);
                }
            }

            $opTransaksi = OpTransaksi::create($data);
            $newId = $opTransaksi->id;
            // Kurangi stock barang
            $cartItems = OpTransaksiCart::where('id_user', Auth::user()->id)->where('id_cabang', Auth::user()->id_cabang)
                ->get();

            foreach ($cartItems as $cartItem) {
                // insert detail Penjualan
                $status_pemesanan = '';
                if ($cartItem->pesanan == 'ya') {
                    $status_pemesanan =  'pesan';
                } else {
                    $status_pemesanan = 'selesai';
                }
                OpTransaksiDetail::create([
                    'id_transaksi' => $newId,
                    'nomor_transaksi' => $request->nomor_transaksi,
                    'id_barang' => $cartItem->id_barang,
                    'id_cabang' => $cartItem->id_cabang,
                    'id_user' => $cartItem->id_user,
                    'id_gudang' => $cartItem->id_gudang,
                    'kode_produk' =>  $cartItem->kode_produk,
                    'harga_barang' =>  $cartItem->harga,
                    'jumlah_barang' =>  $cartItem->jumlah_beli,
                    'sub_total_transaksi' =>  $cartItem->sub_total,
                    'pemesanan' =>  $cartItem->pesanan,
                    'status_pemesanan' => $status_pemesanan,
                ]);

                $stockUpdate = '';
                if ($cartItem->pesanan == 'tidak') {
                    $stockUpdate = OpBarangCabangStock::where('id_barang', $cartItem->id_barang)->first();
                }


                if ($stockUpdate) {
                    $tock_akhir_draf = $stockUpdate->stock_akhir;
                    if ($stockUpdate->stock_akhir >= $cartItem->jumlah_beli) {
                        //$stockUpdate->stock_masuk = $stockUpdate->stock_akhir;
                        $stockUpdate->stock_keluar += $cartItem->jumlah_beli;
                        $stockUpdate->stock_akhir -= $cartItem->jumlah_beli;
                        $stockUpdate->jenis_transaksi_stock = 'Penjualan';
                        $stockUpdate->keterangan_stock_cabang = 'Penjualan barang dengan nomor transaksi ' . $request->nomor_transaksi;
                        $stockUpdate->save();

                        // save op_penjualan_stock_log
                        OpBarangCabangStockLog::create([
                            'id_barang' => $cartItem->id_barang,
                            'id_suplaier' => $stockUpdate->id_suplaier,
                            'id_gudang' => $stockUpdate->id_gudang,
                            'id_user' => $cartItem->id_user,
                            'id_toko' => Auth::user()->id_toko,
                            'id_cabang' => $stockUpdate->id_cabang,
                            'stock_masuk' => $tock_akhir_draf,
                            'stock_keluar' => $cartItem->jumlah_beli,
                            'stock_akhir' => $stockUpdate->stock_akhir,
                            'jenis_transaksi_stock' => 'Penjualan',
                            'keterangan_stock_cabang' => 'Penjualan barang dengan nomor transaksi ' . $request->nomor_transaksi,
                        ]);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Stok barang tidak mencukupi untuk barang dengan kode produk: ' . $cartItem->kode_produk
                        ], 400);
                    }
                    OpTransaksiLog::create([
                        'nomor_transaksi' => $request->nomor_transaksi,
                        'status_log' => 'pesan',
                        'keterangan_log' => 'pemesanan berhasil',
                        'id_user' => Auth::user()->id,
                        'id_cabang' => Auth::user()->id_cabang,
                        'id_gudang' => $stockUpdate->id_gudang
                    ]);

                    OpTransaksiCart::where('id_user', Auth::user()->id)->delete();
                }
            }


            OpTransaksiCart::where('id_user', Auth::user()->id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan',
                'data' => ''
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function cetakPrintPemesanan($id)
    {
        $penjualan = OpTransaksi::with('user', 'cabang')->where('nomor_transaksi', $id)->first();
        $detailenjulan = OpTransaksiDetail::with('barang')
            ->where('nomor_transaksi', $id)
            ->get();
        return view("kasir.nota-transaksi", compact('penjualan', 'detailenjulan'));
    }


    // batalkan pesanan barang
    public function batalkanPesanan($id)
    {
        $pesanan = OpTransaksiDetail::find($id);

        if (!$pesanan) {
            return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan.'], 404);
        }

        if ($pesanan->status_pemesanan !== 'pesan') {
            return response()->json(['success' => false, 'message' => 'Pesanan tidak dapat dibatalkan.'], 400);
        }

        $transaksi = OpTransaksi::where('nomor_transaksi', $pesanan->nomor_transaksi)->first();
        $biaya_rubah = 0;
        if ($transaksi->jenis_transaksi === 'hutang') {
            $biaya_rubah = $transaksi->jumlah_bayar_dp;
        } else {
            $biaya_rubah = $transaksi->jumlah_bayar;
        }

        // Temukan kas berdasarkan kode transaksi
        $kas = OpKas::where('kode_transaksi', $transaksi->nomor_transaksi)->first();

        if ($kas) {
            // Pastikan saldo cukup untuk transaksi
            if ($kas->saldo < $biaya_rubah) {
                throw new Exception('Saldo kas tidak mencukupi untuk pembatalan.');
            }

            // Kurangi saldo berdasarkan total beli
            $saldoTerakhir = OpKas::where('kode_transaksi', $kas->kode_transaksi)->where('id_cabang', Auth::user()->id_cabang)
                ->where('id_user', Auth::user()->id)
                ->orderBy('tanggal', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            $saldoTerakhirKredit = $biaya_rubah;
            $saldo = ($saldoTerakhir?->saldo ?? 0) - $biaya_rubah; // Hitung saldo akhir

            OpKas::create([
                'id_cabang' => Auth::user()->id_cabang, // ID cabang pengguna saat ini
                'id_user' => Auth::user()->id, // ID pengguna saat ini
                'kode_transaksi' => $kas->kode_transaksi, // Kode transaksi dari request
                'tanggal' => now(), // Tanggal sekarang
                'keterangan' => 'Saldo berkurang dari transaksi dibatalkan sebesar ' .
                    number_format($biaya_rubah, 2, ',', '.') .
                    ' dengan nomor transaksi ' . $kas->kode_transaksi,
                'debit' => 0,
                'kredit' => $saldoTerakhirKredit,
                'saldo' => $saldo,
            ]);
        }

        if (!$transaksi) {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan.'], 404);
        }

        $transaksi->total_beli -= $biaya_rubah;
        $transaksi->jumlah_bayar -= $biaya_rubah;
        $transaksi->save();
        $pesanan->status_pemesanan = 'dibatalkan';
        $pesanan->save();

        OpTransaksiLog::create([
            'nomor_transaksi' => $pesanan->nomor_transaksi,
            'status_log' => 'dibatalkan',
            'keterangan_log' => 'transaksi anda di batalkan ',
            'id_user' => Auth::user()->id,
            'id_cabang' => Auth::user()->id_cabang,
            'id_gudang' => $pesanan->id_gudang
        ]);

        return response()->json(['success' => true, 'message' => 'Pesanan berhasil dibatalkan.']);
    }

    // data list transaksi
    public function transaksiListPesanan()
    {
        return view("kasir.transaksi-list");
    }
    public function getDataAll($jenis_transaksi)
    {
        $penjualan = OpTransaksi::where('jenis_transaksi', $jenis_transaksi)->where('id_cabang', Auth::user()->id_cabang)->orderBy('created_at', 'DESC')->with('user', 'cabang')->get();
        return response()->json(['success' => true, 'message' => 'Item deleted successfully', 'data' => $penjualan]);
    }

    public function DetailDataAll($kode)
    {
        $penjualan = OpTransaksiDetail::where('nomor_transaksi', $kode)->where('id_cabang', Auth::user()->id_cabang)->orderBy('created_at', 'DESC')->with('barang', 'gudang')->get();
        $transaksi = OpTransaksi::where('nomor_transaksi', $kode)->where('id_cabang', Auth::user()->id_cabang)->first();
        return response()->json(['success' => true, 'message' => 'Item deleted successfully', 'data' => $penjualan, 'transaksi' => $transaksi]);
    }

    public function DataPemesananAll()
    {
        $pemesanan = OpTransaksiDetail::where('id_cabang', Auth::user()->id_cabang)
            ->where('pemesanan', 'ya')
            ->whereIn('status_pemesanan', ['pesan', 'kirim'])
            ->orderBy('created_at', 'DESC')
            ->with('user', 'cabang', 'gudang', 'transaksi')
            ->get();

        return response()->json(['success' => true, 'message' => 'Item deleted successfully', 'data' => $pemesanan]);
    }

    public function DetailDataPemesanan($kode)
    {
        $pemesanan = OpTransaksiDetail::where('nomor_transaksi', $kode)
            ->where('pemesanan', 'ya')
            ->where('status_pemesanan', 'pesan')
            ->where('id_cabang', Auth::user()->id_cabang)
            ->with('barang', 'transaksi')
            ->get();
        return response()->json(['success' => true, 'message' => 'Item deleted successfully', 'data' => $pemesanan]);
    }

    public function updateStatusPesnan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $status = OpTransaksiDetail::findOrFail($id);

        $status->status_pemesanan = $request->status;
        $status->save();

        return response()->json([
            'success' => true,
            'message' => $request->status === 1 ? 'Item activated successfully.' : 'Item deactivated successfully.',
        ]);
    }

    public function DetailDataHutang($id)
    {
        $pemesanan_hutang = OpTransaksi::where('id', $id)->first();

        if (!$pemesanan_hutang) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data retrieved successfully',
            'data' => $pemesanan_hutang
        ]);
    }

    public function BayarHutang($id, Request $request)
    {
        $request->validate([
            'jumlah_lunas_dp' => 'required|numeric',
        ]);
        $pemesanan_hutang = OpTransaksi::where('id', $id)->first();

        if (!$pemesanan_hutang) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
        }
        $pemesanan_hutang->update([
            'jumlah_lunas_dp' => $request->jumlah_lunas_dp,
            'status_transaksi' => 'lunas',
        ]);

        $saldoTerakhir = OpKas::where('id_cabang', Auth::user()->id_cabang)
            ->where('id_user', Auth::user()->id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        $saldoTerakhirKredit = $saldoTerakhir?->kredit ?? 0; // Nilai kredit terakhir atau 0 jika null
        $saldo = ($saldoTerakhir?->saldo ?? 0) + $request->jumlah_lunas_dp - $saldoTerakhirKredit; // Hitung saldo akhir

        OpKas::create([
            'id_cabang' => Auth::user()->id_cabang, // ID cabang pengguna saat ini
            'id_user' => Auth::user()->id, // ID pengguna saat ini
            'kode_transaksi' => $request->nomor_transaksi, // Kode transaksi dari request
            'tanggal' => now(), // Tanggal sekarang
            'keterangan' => 'Saldo tambahan dari transaksi pelunasan utang total' . $request->total_beli . ' dengan nomor transaksi ' . $request->nomor_transaksi,
            'debit' => $request->jumlah_lunas_dp, // Debit diisi dengan jumlah bayar
            'kredit' => $saldoTerakhirKredit, // Kredit diisi dengan nilai kredit terakhir
            'saldo' => $saldo, // Saldo diisi dengan hasil perhitungan
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Data retrieved successfully',
            'data' => $pemesanan_hutang
        ]);
    }

    // batalkan transaksi all
    public function batalkanTransaksiAll($id)
    {
        // Temukan transaksi utama dengan detailnya berdasarkan ID
        $transaksi = OpTransaksi::with('transaksidetail')->where('nomor_transaksi', $id)->first();

        if (!$transaksi) {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan.'], 404);
        }

        try {
            // Memulai transaksi database untuk menjaga konsistensi data
            DB::beginTransaction();

            // Proses setiap detail transaksi yang ada
            foreach ($transaksi->transaksidetail as $pesanan) {
                // Update stok barang (gudang atau cabang)
                $nomor = $transaksi->nomor_transaksi;
                $this->getBarang($pesanan, $nomor);

                // Update status pesanan menjadi "dibatalkan"
                $pesanan->status_pemesanan = 'dibatalkan';
                $pesanan->save();
            }

            // Update status transaksi menjadi "dibatalkan"
            OpTransaksi::where('id', $transaksi->id)->update(['status_transaksi' => 'dibatalkan']);

            // Update kas jika transaksi menggunakan metode tunai
            $this->updateKas($transaksi);

            // Commit perubahan ke database
            DB::commit();

            OpTransaksiLog::create([
                'nomor_transaksi' => $transaksi->nomor_transaksi,
                'status_log' => 'dibatalkan',
                'keterangan_log' => 'transaksi anda di batalkan ',
                'id_user' => Auth::user()->id,
                'id_cabang' => Auth::user()->id_cabang,
                'id_gudang' => $transaksi->id_gudang ? $transaksi->id_gudang : '',
            ]);

            return response()->json(['success' => true, 'message' => 'Transaksi berhasil dibatalkan.']);
        } catch (Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();

            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat membatalkan transaksi: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get barang based on gudang or cabang.
     */
    private function getBarang($pesanan, $nomor)
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
                $barang->keterangan_stock_gudang = 'Pembatalan transaksi barang dengan nomor transaksi ' . $nomor;
                $barang->save();
            }
        } else {
            $barang = OpBarangCabangStock::where('id_barang', $pesanan->id_barang)
                ->where('id_cabang', $pesanan->id_cabang)
                ->first();

            if ($barang) {
                $barang->stock_akhir += $pesanan->jumlah_barang;
                $barang->stock_keluar -= $pesanan->jumlah_barang;
                $barang->jenis_transaksi_stock = 'Dibatalkan';
                $barang->keterangan_stock_cabang = 'Pembatalan transaksi barang dengan nomor transaksi ' . $nomor;
                $barang->save();
            }
        }

        return $barang;
    }


    /**
     * Update kas based on transaction.
     */
    private function updateKas($transaksi)
    {
        // Temukan kas berdasarkan kode transaksi
        $kas = OpKas::where('kode_transaksi', $transaksi->nomor_transaksi)->first();

        if ($kas) {
            // Pastikan saldo cukup untuk transaksi
            if ($kas->saldo < $transaksi->total_beli) {
                throw new Exception('Saldo kas tidak mencukupi untuk pembatalan.');
            }

            // Kurangi saldo berdasarkan total beli
            $saldoTerakhir = OpKas::where('kode_transaksi', $kas->kode_transaksi)->where('id_cabang', Auth::user()->id_cabang)
                ->where('id_user', Auth::user()->id)
                ->orderBy('tanggal', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            $saldoTerakhirKredit = $transaksi->total_beli;
            $saldo = ($saldoTerakhir?->saldo ?? 0) - $transaksi->total_beli; // Hitung saldo akhir

            OpKas::create([
                'id_cabang' => Auth::user()->id_cabang, // ID cabang pengguna saat ini
                'id_user' => Auth::user()->id, // ID pengguna saat ini
                'kode_transaksi' => $kas->kode_transaksi, // Kode transaksi dari request
                'tanggal' => now(), // Tanggal sekarang
                'keterangan' => 'Saldo berkurang dari transaksi dibatalkan sebesar ' .
                    number_format($transaksi->total_beli, 2, ',', '.') .
                    ' dengan nomor transaksi ' . $kas->kode_transaksi,
                'debit' => 0,
                'kredit' => $saldoTerakhirKredit,
                'saldo' => $saldo,
            ]);
        }
    }
    // end batalkan
}
