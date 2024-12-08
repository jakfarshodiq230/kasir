<?php

namespace App\Http\Controllers\Gudang;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OpBarang;
use App\Models\OpKategori;
use App\Models\OpJenis;
use App\Models\OpType;
use App\Models\OpSetingLensa;
use App\Models\OpDetailBarang;
use App\Models\OpSuplaier;
use App\Models\OpBarangHarga;

class BarangGudangController extends Controller
{
    // kode barang otomatis
    public function generateNextProductCode($date)
    {
        // Ensure the date format is correct
        $year = date('Y', strtotime($date));
        $day = date('d', strtotime($date));
        $month = date('m', strtotime($date));

        // Get the highest product code created on the same day
        $highestCode = OpBarang::whereDate('created_at', '=', date('Y-m-d', strtotime($date)))
            ->orderByRaw('CAST(SUBSTRING(kode_produk, 7, 4) AS UNSIGNED) DESC') // Change to get substring starting from the 7th character
            ->value('kode_produk');

        // Determine the serial number for the new product code
        if ($highestCode) {
            $serialNumber = (int)substr($highestCode, -4) + 1;
        } else {
            $serialNumber = 1;
        }

        // Format the serial number to always have 4 digits
        $productCode = "BRG" . $year . $day . $month . str_pad($serialNumber, 4, '0', STR_PAD_LEFT);

        return $productCode;
    }

    public function KodeBarangJson()
    {
        $date = now();
        $serialNumber = $this->generateNextProductCode($date);
        $kategori = OpKategori::where('status', 1)->get();
        $jenis = OpJenis::where('status_jenis', 1)->get();
        $type = OpType::where('status_type', 1)->get();
        $seting_lensa = OpSetingLensa::first();
        $suplaier = OpSuplaier::where('status_suplaier', 1)->get();
        return response()->json([
            'message' => 'Data get successfully',
            'kategori' => $kategori,
            'jenis' => $jenis,
            'type' => $type,
            'seting_lensa' => $seting_lensa,
            'suplaier' => $suplaier,
            'productCode' => $serialNumber,
        ]);
    }

    public function DataBarangJson()
    {
        $id_gudang = Auth::user()->id_gudang;
        $barang = OpBarang::where('id_gudang', $id_gudang)->with(['opBarangDetails', 'kategori', 'gudang', 'harga'])->get();
        return response()->json(['message' => 'Data get successfully', 'data' => $barang]);
    }


    public function index()
    {
        return view("gudang.barang.barang");
    }

    public function addBarang($id = null)
    {
        return view('gudang.barang.add', compact('id'));
    }

    public function store(Request $request)
    {

        $request->validate([
            // tabel produk
            'kode_produk' => 'required|string|unique:op_barang,kode_produk',
            'nama_produk' => 'required|string|max:255',
            'kategori_barang' => 'required',
            'keterangan_barang' => 'required|string',
            'id_gudang' => 'required|string',

            // tabel detail_produk
            'jenis_barang' => 'required',
            'type_barang' => 'required',

            // harga
            'harga_modal' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'harga_grosir_1' => 'required|numeric',
            'harga_grosir_2' => 'required|numeric',
            'harga_grosir_3' => 'required|numeric',
        ]);


        $barang = OpBarang::create([
            'kode_produk' => $request->kode_produk,
            'id_kategori' => $request->kategori_barang,
            'id_gudang' => $request->id_gudang,
            'nama_produk' => $request->nama_produk,
            'keterangan_produk' => $request->keterangan_barang,
            'id_user' => $request->id_user,
        ]);

        $id_barang = $barang->id;

        $barang = OpDetailBarang::create([
            'id_barang' => $id_barang,
            'id_jenis' => $request->jenis_barang,
            'id_type' => $request->type_barang,

            'R_SPH' => $request->r_sph,
            'L_SPH' => $request->l_sph,

            'R_CYL' => $request->r_cyl,
            'L_CYL' => $request->l_cyl,

            'R_AXS' => $request->r_axs,
            'L_AXS' => $request->l_axs,

            'R_ADD' => $request->r_add,
            'L_ADD' => $request->l_add,

            'PD' => $request->pd,
            'PD2' => $request->pd2,
        ]);

        $barang = OpBarangHarga::create([
            'id_barang' => $id_barang,
            'harga_modal' => $request->harga_modal,
            'harga_jual' => $request->harga_jual,
            'harga_grosir_1' => $request->harga_grosir_1,
            'harga_grosir_2' => $request->harga_grosir_2,
            'harga_grosir_3' => $request->harga_grosir_3,
        ]);


        return response()->json(['success' => true, 'message' => 'Data created successfully', 'data' => $barang]);
    }

    public function viewData($id)
    {
        $barang = OpBarang::with(['opBarangDetails', 'kategori', 'gudang', 'harga'])->where('id', $id)->get();
        $detail_barang = OpDetailBarang::with(['jenis', 'type'])->where('id_barang', $id)->get();
        return response()->json(['success' => true, 'message' => 'Data view successfully', 'data' => $barang, 'detail' => $detail_barang]);
    }

    public function editBarang($id)
    {
        return view('gudang.barang.add', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_barang' => 'required',
            'keterangan_barang' => 'required|string',

            // tabel detail_produk
            'jenis_barang' => 'required',
            'type_barang' => 'required',

            // harga
            'harga_modal' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'harga_grosir_1' => 'required|numeric',
            'harga_grosir_2' => 'required|numeric',
            'harga_grosir_3' => 'required|numeric',
        ]);

        // Find the record to update (OpBarang)
        $barang = OpBarang::findOrFail($id);

        // Update the OpBarang record
        $barang->update([
            'id_kategori' => $request->kategori_barang,
            'nama_produk' => $request->nama_produk,
            'keterangan_produk' => $request->keterangan_barang,
        ]);

        // Find the corresponding detail record (OpDetailBarang)
        $detail = OpDetailBarang::where('id_barang', $barang->id);

        // Update the OpDetailBarang record
        $detail->update([
            'id_jenis' => $request->jenis_barang,
            'id_type' => $request->type_barang,

            'R_SPH' => $request->r_sph,
            'L_SPH' => $request->l_sph,

            'R_CYL' => $request->r_cyl,
            'L_CYL' => $request->l_cyl,

            'R_AXS' => $request->r_axs,
            'L_AXS' => $request->l_axs,

            'R_ADD' => $request->r_add,
            'L_ADD' => $request->l_add,

            'PD' => $request->pd,
            'PD2' => $request->pd2,
        ]);

        $harga = OpBarangHarga::where('id_barang', $barang->id);
        $harga->update([
            'harga_modal' => $request->harga_modal,
            'harga_jual' => $request->harga_jual,
            'harga_grosir_1' => $request->harga_grosir_1,
            'harga_grosir_2' => $request->harga_grosir_2,
            'harga_grosir_3' => $request->harga_grosir_3,
        ]);

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Data updated successfully', 'data' => $barang, 'detail' => $detail, 'harga' => $harga]);
    }

    public function destroy($id)
    {
        $barang = OpBarang::findOrFail($id);
        $detail = OpDetailBarang::where('id_barang', $barang->id);
        $barang->delete();
        $detail->delete();
        return response()->json(['success' => true, 'message' => 'Data deleted successfully']);
    }
}
