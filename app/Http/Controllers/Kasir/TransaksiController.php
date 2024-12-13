<?php

namespace App\Http\Controllers\Kasir;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OpBarangCabangStock;
use App\Models\OpBarangCabangStockLog;
use App\Models\OpBarang;
use App\Models\OpGudang;
use App\Models\OpKas;
use App\Models\OpPenjualan;
use App\Models\OpPenjualanCart;
use App\Models\OpPenjualanDetail;
use App\Models\OpPesanan;
use App\Models\OpPesananCart;
use App\Models\OpPesananDetail;
use App\Models\OpPesananLog;
use App\Models\OpSetingLensa;
use App\Models\OpStockGudang;

class TransaksiController extends Controller
{
    public function generateNextProductCode($date)
    {
        $year = date('Y', strtotime($date));
        $day = date('d', strtotime($date));
        $month = date('m', strtotime($date));

        $highestCode = OpPenjualan::whereDate('created_at', '=', date('Y-m-d', strtotime($date)))
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

    public function index()
    {
        $id_toko = Auth::user()->id_toko;
        $date = now();
        $nomor_transaksi = $this->generateNextProductCode($date);
        $barang = OpBarangCabangStock::where('id_toko', $id_toko)->with(['barang', 'gudang'])->get();
        return view("kasir.transaksi-langsung", compact('barang', 'nomor_transaksi'));
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

    public function simpanPembelian(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'jumlah_beli' => 'required|integer',
            'sub_total' => 'required|numeric',
        ]);

        if ($request->harga == 0) {
            $harga = $request->harga_lainya;
        } else {
            $harga = $request->harga;
        }

        $dataCart = OpPenjualanCart::create([
            'id_barang' => $request->id,
            'id_cabang' => Auth::user()->id_cabang,
            'id_user' => Auth::user()->id,
            'kode_produk' => $request->kode_produk,
            'harga' => $harga,
            'jumlah_beli' => $request->jumlah_beli,
            'sub_total' => $request->sub_total,
        ]);
        return response()->json(['success' => true, 'message' => 'Data get successfully', 'data' => $dataCart]);
    }

    public function getCartData(Request $request)
    {
        $id_cabang = Auth::user()->id_cabang;
        $id_user = Auth::user()->id;
        $dataCart = OpPenjualanCart::where('id_cabang', $id_cabang)->where('id_user', $id_user)->with(['barang'])->get();
        return response()->json(['message' => 'Data get successfully', 'data' => $dataCart]);
    }

    public function deleteCartData($id, Request $request)
    {
        $item = OpPenjualanCart::findOrFail($id);
        $item->delete();

        return response()->json(['success' => true, 'message' => 'Item deleted successfully']);
    }

    public function simpanPenjualan(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nomor_transaksi' => 'required|string|max:50|unique:op_penjualan,nomor_transaksi',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'id_user' => 'required|integer|exists:users,id',
            'phone_transaksi' => 'required|string|max:15',
            'diameter' => 'required|numeric',
            'warna' => 'required|string|max:50',
            'tanggal_transaksi' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_transaksi',
            'tanggal_ambil' => 'required|date|after_or_equal:tanggal_selesai',
            'pembayaran' => 'required|string|in:tunai,transfer',
            'jenis_transaksi' => 'required|string|in:non_hutang,hutang',
            'total_beli' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0|max:100',
            'jumlah_bayar' => 'required|numeric|min:0',
            'sisa_bayar' => 'required|numeric|min:0',
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

            ];

            if ($validatedData['jenis_transaksi'] === 'non_hutang') {
                // For 'non_hutang' type, include 'jumlah_bayar' and 'sisa_bayar'
                $data['jumlah_bayar'] = $validatedData['jumlah_bayar'] ?? 0;
                $data['sisa_bayar'] = $validatedData['sisa_bayar'];
                $data['status_penjualan'] = 'lunas';
                // kas
                if ($validatedData['pembayaran'] === 'tunai') {
                    $saldoTerakhir = OpKas::where('id_cabang', Auth::user()->id_cabang)
                        ->where('id_user', Auth::user()->id)
                        ->orderBy('tanggal', 'desc')
                        ->orderBy('id', 'desc')
                        ->first();

                    $saldoTerakhirKredit = $saldoTerakhir?->kredit ?? 0; // Nilai kredit terakhir atau 0 jika null
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
                $data['status_penjualan'] = 'belum_lunas';
            }

            OpPenjualan::create($data);

            // Kurangi stock barang
            $cartItems = OpPenjualanCart::where('id_cabang', Auth::user()->id_cabang)
                ->get();

            foreach ($cartItems as $cartItem) {
                // insert detail Penjualan
                OpPenjualanDetail::create([
                    'nomor_transaksi' => $request->nomor_transaksi,
                    'id_barang' => $cartItem->id_barang,
                    'id_cabang' => $cartItem->id_cabang,
                    'id_user' => $cartItem->id_user,
                    'kode_produk' =>  $cartItem->kode_produk,
                    'harga_barang' =>  $cartItem->harga,
                    'jumlah_barang' =>  $cartItem->jumlah_beli,
                    'sub_total_transaksi' =>  $cartItem->sub_total,
                ]);
                // Find the stock data based on the id_barang and id_cabang
                $stockUpdate = OpBarangCabangStock::where('id_barang', $cartItem->id_barang)->first();

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
                    OpPenjualanCart::where('id_user', Auth::user()->id)->delete();
                } else {
                    // If stock data is not found
                    return response()->json([
                        'success' => false,
                        'message' => 'Barang tidak ditemukan di cabang yang dipilih untuk barang dengan kode produk: ' . $cartItem->kode_produk
                    ], 404);
                }
            }

            // If all updates are successful
            return response()->json([
                'success' => true,
                'message' => 'Stok berhasil diperbarui untuk semua barang'
            ], 200);


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
    public function cetakPrint($id)
    {
        $penjualan = OpPenjualan::with('user', 'cabang')->where('nomor_transaksi', $id)->first();
        $detailenjulan = OpPenjualanDetail::with('barang')->where('nomor_transaksi', $id)->get();
        //return response()->json(['success' => true, 'message' => 'Item deleted successfully', 'data' => $penjualan]);
        return view("kasir.nota-langsung", compact('penjualan', 'detailenjulan'));
    }

    // transaksi pesan
    public function generateNextProductCodePesnan($date)
    {
        $year = date('Y', strtotime($date));
        $day = date('d', strtotime($date));
        $month = date('m', strtotime($date));

        $highestCode = OpPesanan::whereDate('created_at', '=', date('Y-m-d', strtotime($date)))
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

    public function transaksiPesanan()
    {
        $id_toko = Auth::user()->id_toko;
        $date = now();
        $nomor_transaksi = $this->generateNextProductCodePesnan($date);
        $seting = OpSetingLensa::first();
        $gudang = OpGudang::where('status_gudang', '=', 1)->get();
        //return response()->json(['success' => true, 'message' => 'Item deleted successfully', 'data' => $barang]);
        return view("kasir.transaksi-pesanan", compact('nomor_transaksi', 'seting', 'gudang'));
    }

    public function getBarang(Request $request)
    {
        $idGudang = $request->id_gudang;

        // Fetch the Gudang and its related stocks and barang
        $gudang = OpStockGudang::with('barang')
            ->where('id_gudang', $idGudang)
            ->get();

        if ($gudang->isEmpty()) {
            return response()->json(['error' => 'Gudang or stock not found'], 404);
        }

        // Filter stocks and map results
        $barang = $gudang
            ->filter(fn($stock) => $stock->stock_akhir > 0)
            ->map(fn($stock) => [
                'id_barang' => $stock->barang->id,
                'kode_produk' => $stock->barang->kode_produk,
                'nama_produk' => $stock->barang->nama_produk,
                'stock_akhir' => $stock->stock_akhir,
            ])
            ->values(); // Re-index the collection

        return response()->json($barang);
    }

    public function getHarga(Request $request)
    {
        $idBarang = $request->id_barang;

        $barang = OpBarang::with('harga')->find($idBarang);

        if (!$barang || !$barang->harga) {
            return response()->json(['error' => 'Harga not found'], 404);
        }

        $harga = $barang->harga;

        // Prepare the harga data as an array of objects with `id` and `price` properties
        $hargaOptions = [
            ['id' => 'harga_jual', 'Ket' => 'Harga Jual', 'price' => $harga->harga_jual],
            ['id' => 'harga_grosir_1', 'Ket' => 'Harga Grosir 1', 'price' => $harga->harga_grosir_1],
            ['id' => 'harga_grosir_2', 'Ket' => 'Harga Grosir 2', 'price' => $harga->harga_grosir_2],
            ['id' => 'harga_grosir_3', 'Ket' => 'Harga Grosir 3', 'price' => $harga->harga_grosir_3],
            ['id' => 'harga_lainya', 'Ket' => 'Lainya', 'price' => 0],
        ];

        return response()->json($hargaOptions);
    }


    public function DataPesananCart(Request $request)
    {
        $id_cabang = Auth::user()->id_cabang;
        $id_user = Auth::user()->id;
        $dataCart = OpPesananCart::where('id_cabang', $id_cabang)->where('id_user', $id_user)->with(['barang'])->get();
        return response()->json(['message' => 'Data get successfully', 'data' => $dataCart]);
    }

    public function simpanPemesanan(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|string|max:255',
            'jumlah_beli' => 'required|integer',
            'sub_total' => 'required|numeric',
        ]);

        if ($request->harga == 0) {
            $harga = $request->harga_lainya;
        } else {
            $harga = $request->harga;
        }


        $dataCart = OpPesananCart::create([
            'id_barang' => $request->id,
            'id_cabang' => Auth::user()->id_cabang,
            'id_user' => Auth::user()->id,
            'kode_produk' => $request->kode_produk,
            'harga' => $harga,
            'jumlah_beli' => $request->jumlah_beli,
            'sub_total' => $request->sub_total,
        ]);
        return response()->json(['success' => true, 'message' => 'Data get successfully', 'data' => $dataCart]);
    }

    public function deleteCartPesanan($id, Request $request)
    {
        $item = OpPesananCart::findOrFail($id);
        $item->delete();
        return response()->json(['success' => true, 'message' => 'Item deleted successfully']);
    }

    public function simpanPemesananFinal(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nomor_transaksi' => 'required|string|max:50|unique:op_pemesanan,nomor_transaksi',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'id_user' => 'required|integer|exists:users,id',
            'id_gudang' => 'required|integer',
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
                'id_gudang' => $validatedData['id_gudang'],
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
                'status_pemesanan' => 'pesan',
            ];

            if ($validatedData['jenis_transaksi'] === 'non_hutang') {
                // For 'non_hutang' type, include 'jumlah_bayar' and 'sisa_bayar'
                $data['jumlah_bayar'] = $validatedData['jumlah_bayar'] ?? 0;
                $data['sisa_bayar'] = $validatedData['sisa_bayar'];
            } else {
                // For other transaction types, include 'jumlah_bayar_dp', 'jumlah_sisa_dp', and 'jumlah_lunas_dp'
                $data['jumlah_bayar_dp'] = $validatedData['jumlah_bayar'] ?? 0;
                $data['jumlah_sisa_dp'] = $validatedData['sisa_bayar'] ?? 0;
                $data['jumlah_lunas_dp'] = $validatedData['jumlah_lunas_dp'] ?? 0;
            }

            OpPesanan::create($data);

            // Kurangi stock barang
            $cartItems = OpPesananCart::where('id_user', Auth::user()->id)->where('id_cabang', Auth::user()->id_cabang)
                ->get();

            foreach ($cartItems as $cartItem) {
                // insert detail Penjualan
                OpPesananDetail::create([
                    'nomor_transaksi' => $request->nomor_transaksi,
                    'id_barang' => $cartItem->id_barang,
                    'id_cabang' => $cartItem->id_cabang,
                    'id_user' => $cartItem->id_user,
                    'kode_produk' =>  $cartItem->kode_produk,
                    'harga_barang' =>  $cartItem->harga,
                    'jumlah_barang' =>  $cartItem->jumlah_beli,
                    'sub_total_transaksi' =>  $cartItem->sub_total,
                ]);
            }

            OpPesananLog::create([
                'nomor_transaksi' => $request->nomor_transaksi,
                'status_log' => 'pesan',
                'keterangan_log' => 'pemesanan berhasil',
                'id_user' => Auth::user()->id
            ]);
            OpPesananCart::where('id_user', Auth::user()->id)->delete();
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
        $penjualan = OpPesanan::with('user', 'cabang')->where('nomor_transaksi', $id)->first();
        $detailenjulan = OpPesananDetail::with('barang')->where('nomor_transaksi', $id)->get();
        return view("kasir.nota-pemesanan", compact('penjualan', 'detailenjulan'));
    }
    // data list transaksi
    public function transaksiListPesanan()
    {
        return view("kasir.transaksi-list");
    }
    public function getDataAll($jenis_transaksi)
    {
        $penjualan = OpPenjualan::where('jenis_transaksi', $jenis_transaksi)->where('id_cabang', Auth::user()->id_cabang)->orderBy('created_at', 'DESC')->with('user', 'cabang')->get();
        return response()->json(['success' => true, 'message' => 'Item deleted successfully', 'data' => $penjualan]);
    }

    public function DetailDataAll($kode)
    {
        $penjualan = OpPenjualanDetail::where('nomor_transaksi', $kode)->where('id_cabang', Auth::user()->id_cabang)->orderBy('created_at', 'DESC')->with('barang')->get();
        return response()->json(['success' => true, 'message' => 'Item deleted successfully', 'data' => $penjualan]);
    }

    public function DataPemesananAll()
    {
        $pemesanan = OpPesanan::where('id_cabang', Auth::user()->id_cabang)->orderBy('created_at', 'DESC')->with('user', 'cabang', 'gudang', 'pemesanandetail')
            ->get()
            ->map(function ($pesanan) {
                $pesanan->total_beli_barang = $pesanan->pemesanandetail->sum('jumlah_barang');
                return $pesanan;
            });

        return response()->json(['success' => true, 'message' => 'Item deleted successfully', 'data' => $pemesanan]);
    }

    public function DetailDataPemesanan($kode)
    {
        $pemesanan = OpPesananDetail::where('nomor_transaksi', $kode)->where('id_cabang', Auth::user()->id_cabang)->with('barang', 'pesanan')->get();
        return response()->json(['success' => true, 'message' => 'Item deleted successfully', 'data' => $pemesanan]);
    }

    public function updateStatusPesnan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $status = OpPesanan::findOrFail($id);

        $status->status_pemesanan = $request->status;
        $status->save();

        return response()->json([
            'success' => true,
            'message' => $request->status === 1 ? 'Item activated successfully.' : 'Item deactivated successfully.',
        ]);
    }

    public function DetailDataHutang($id)
    {
        $pemesanan_hutang = OpPenjualan::where('id', $id)->first();

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
        $pemesanan_hutang = OpPenjualan::where('id', $id)->first();

        if (!$pemesanan_hutang) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
        }
        $pemesanan_hutang->update([
            'jumlah_lunas_dp' => $request->jumlah_lunas_dp,
            'status_penjualan' => 'lunas',
        ]);

        $saldoTerakhir = OpKas::where('id_cabang', Auth::user()->id_cabang)
            ->where('id_user', Auth::user()->id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        $saldoTerakhirKredit = $saldoTerakhir?->kredit ?? 0; // Nilai kredit terakhir atau 0 jika null
        $saldo = ($saldoTerakhir?->saldo ?? 0) + $request->total_beli - $saldoTerakhirKredit; // Hitung saldo akhir

        OpKas::create([
            'id_cabang' => Auth::user()->id_cabang, // ID cabang pengguna saat ini
            'id_user' => Auth::user()->id, // ID pengguna saat ini
            'kode_transaksi' => $request->nomor_transaksi, // Kode transaksi dari request
            'tanggal' => now(), // Tanggal sekarang
            'keterangan' => 'Saldo tambahan dari transaksi pelunasan hutang total' . $request->total_beli . ' dengan nomor transaksi ' . $request->nomor_transaksi,
            'debit' => $request->total_beli, // Debit diisi dengan jumlah bayar
            'kredit' => $saldoTerakhirKredit, // Kredit diisi dengan nilai kredit terakhir
            'saldo' => $saldo, // Saldo diisi dengan hasil perhitungan
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Data retrieved successfully',
            'data' => $pemesanan_hutang
        ]);
    }
}
