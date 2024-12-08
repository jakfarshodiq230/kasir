<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OpBarang;
use App\Models\OpKategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function generateNextProductCode($date)
    {
        // Ambil tahun, bulan, dan tanggal dari input
        $year = date('Y', strtotime($date));
        $day = date('d', strtotime($date));
        $month = date('m', strtotime($date));

        // Cari kode produk dengan angka tertinggi untuk hari yang sama
        $highestCode = OpBarang::whereDate('created_at', '=', date('Y-m-d', strtotime($date)))
            ->orderByRaw('CAST(SUBSTRING(kode_produk, -4) AS UNSIGNED) DESC') // Ambil angka terakhir dan urutkan
            ->value('kode_produk');

        // Tentukan nomor urut berikutnya
        if ($highestCode) {
            // Ambil angka terakhir dari kode produk
            $serialNumber = (int)substr($highestCode, -4) + 1;
        } else {
            // Jika belum ada kode produk untuk tanggal tersebut, mulai dari 1
            $serialNumber = 1;
        }

        // Format kode barang
        $productCode = "BRG" . $year . $day . $month . str_pad($serialNumber, 4, '0', STR_PAD_LEFT);
        return $productCode;
    }


    public function index()
    {
        return view("master.produk.index");
    }


    public function DatabarangJson()
    {
        $barang = OpBarang::with('kategori')->get();
        $date = now();
        $serialNumber = $this->generateNextProductCode($date);
        $kategori = OpKategori::all();
        return response()->json([
            'message' => 'Data get successfully',
            'data' => $barang,
            'kategori' => $kategori,
            'productCode' => $serialNumber,
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'kode_produk' => 'required|string|unique:op_barang,kode_produk',
            'nama_produk' => 'required|string|max:255',
            'kategori_produk' => 'required',
            'keterangan_produk' => 'required|string',
        ]);


        $barang = OpBarang::create([
            'kode_produk' => $request->kode_produk,
            'id_kategori' => $request->kategori_produk,
            'nama_produk' => $request->nama_produk,
            'keterangan_produk' => $request->keterangan_produk,
        ]);

        return response()->json(['success' => true, 'message' => 'Data created successfully', 'data' => $barang]);
    }

    public function destroy($id)
    {
        $barang = OpBarang::findOrFail($id);
        $barang->delete();
        return response()->json(['success' => true, 'message' => 'Data deleted successfully']);
    }

    public function viewData($id)
    {
        $barang = OpBarang::findOrFail($id);
        return response()->json(['success' => true, 'message' => 'Data view successfully', 'data' => $barang]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_produk' => 'required',
            'keterangan_produk' => 'required|string',
        ]);

        // Find the record to update
        $barang = OpBarang::findOrFail($id);

        // Update the OpKategori record
        $barang->update([
            'id_kategori' => $request->kategori_produk,
            'nama_produk' => $request->nama_produk,
            'keterangan_produk' => $request->keterangan_produk,
        ]);

        return response()->json(['success' => true, 'message' => 'Data updated successfully', 'data' => $barang]);
    }
}
