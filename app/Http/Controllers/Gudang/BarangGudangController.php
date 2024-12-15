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
use App\Models\OpStockGudangLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Picqer\Barcode\BarcodeGeneratorPNG;

class BarangGudangController extends Controller
{
    // kode barang otomatis
    public function generateNextProductCode()
    {
        $tahun = Carbon::now()->format('Y');
        $lastBarang = OpBarang::where('kode_produk', 'LIKE', 'BRG' . $tahun . '%')
            ->orderBy('kode_produk', 'desc')
            ->first();
        if ($lastBarang) {
            $lastNumber = (int) substr($lastBarang->kode_produk, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        $newNumberFormatted = str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        $newKodeBarang = 'BRG' . $tahun . $newNumberFormatted;

        return $newKodeBarang;
    }

    public function KodeBarangJson()
    {
        $serialNumber = $this->generateNextProductCode();
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

        // Generate barcode image from kode_produk
        $generator = new BarcodeGeneratorPNG();
        $barcodeData = $generator->getBarcode($request->kode_produk, BarcodeGeneratorPNG::TYPE_CODE_128);

        // Define path to store barcode image in storage/app/public/barcode_barang
        $barcodeFolder = storage_path('app/public/barcode_barang');
        $barcodePath = $barcodeFolder . '/' . $request->kode_produk . '.png';

        // Check if barcode folder exists, if not, create it
        if (!File::exists($barcodeFolder)) {
            File::makeDirectory($barcodeFolder, 0755, true); // Create folder with proper permissions
        }

        // Save barcode image to the folder
        file_put_contents($barcodePath, $barcodeData);

        $barang = OpBarang::create([
            'kode_produk' => $request->kode_produk,
            'id_kategori' => $request->kategori_barang,
            'id_gudang' => $request->id_gudang,
            'nama_produk' => $request->nama_produk,
            'keterangan_produk' => $request->keterangan_barang,
            'id_user' => $request->id_user,
            'barcode' => 'barcode_barang/' . $request->kode_produk . '.png',
        ]);

        $id_barang = $barang->id;

        OpDetailBarang::create([
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

        OpBarangHarga::create([
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
        $idGudang = Auth::user()->id_gudang;
        $barang = OpBarang::where('id', $id)
            ->where('id_gudang', $idGudang)
            ->firstOrFail();
        $detail = OpDetailBarang::where('id_barang', $barang->id);
        $barang->delete();
        $detail->delete();
        return response()->json(['success' => true, 'message' => 'Data deleted successfully']);
    }

    public function CetakBarcode()
    {
        return view("gudang.barang.cetak-barcode");
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

        $harga = $this->getHarga($barang->id);

        return response()->json([
            'message' => 'Data retrieved successfully',
            'data' => $barang,
            'harga' => $harga,
        ]);
    }

    public function getHarga($idBarang)
    {

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

    public function generateBarcodePdf(Request $request)
    {
        // Validate the inputs
        $request->validate([
            'kode_produk' => 'required',
            'nama_produk' => 'required',
            'barcode' => 'required',
            'harga_barang' => 'required|numeric',
            'jumlah_cetak' => 'required|integer|min:1',
        ]);

        // Check if harga_barang is 0, then use harga_lainya
        $harga = ($request->harga_barang == 0) ? $request->harga_lainya : $request->harga_barang;

        // Collect data from the request
        $data = [
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'barcode' => $request->barcode,
            'harga_barang' => $harga,
            'jumlah_cetak' => $request->jumlah_cetak,
        ];

        // Create barcode directory if it doesn't exist
        $barcodeDirectory = storage_path('app/public/barcodes');
        if (!File::exists($barcodeDirectory)) {
            File::makeDirectory($barcodeDirectory, 0775, true);
        }

        // Generate dynamic filename using barcode or kode_produk
        $filename = 'brcode_' . $request->kode_produk . '.pdf';
        $filePath = $barcodeDirectory . '/' . $filename;


        // Generate the PDF from the view
        $pdf = PDF::loadView('gudang.barang.barcode-pdf', $data);

        // Save the PDF to the defined path
        try {
            $pdf->save($filePath);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error generating PDF: ' . $e->getMessage()]);
        }

        // Return the generated PDF URL for download
        return response()->json([
            'success' => true,
            'pdf_url' => asset('storage/barcodes/' . $filename)
        ]);
    }
}
