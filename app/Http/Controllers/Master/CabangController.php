<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OpCabang;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    public function index()
    {
        return view("master.cabang.index");
    }

    public function DatacabangJson()
    {
        $cabang = OpCabang::all();
        return response()->json(['message' => 'Data get successfully', 'data' => $cabang]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_toko_cabang' => 'required|string|max:255|unique:op_toko_cabang,nama_toko_cabang',
            'alamat_cabang' => 'required|string|max:255',
            'phone_cabang' => 'required|string|digits_between:10,15',
            'email_cabang' => 'required|string|email|max:255|unique:op_toko_cabang,email_cabang',
            'latitude' => 'required|string|max:255',
            'longitude' => 'required|string|max:255',
        ]);

        $cabang = OpCabang::create([
            'nama_toko_cabang' => $request->nama_toko_cabang,
            'alamat_cabang' => $request->alamat_cabang,
            'phone_cabang' => $request->phone_cabang,
            'email_cabang' => $request->email_cabang,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'id_toko' => $request->id_toko,
            'status_cabang' => 1,
        ]);

        return response()->json(['success' => true, 'message' => 'Data created successfully', 'data' => $cabang]);
    }

    public function destroy($id)
    {
        $cabang = OpCabang::findOrFail($id);
        $cabang->delete();
        return response()->json(['success' => true, 'message' => 'Data deleted successfully']);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_cabang' => 'required|in:0,1',
        ]);

        $cabang = OpCabang::findOrFail($id);

        $cabang->status_cabang = $request->status_cabang;
        $cabang->save();

        return response()->json([
            'success' => true,
            'message' => $request->status_cabang === 1 ? 'Item activated successfully.' : 'Item deactivated successfully.',
        ]);
    }

    public function viewData($id)
    {
        $cabang = OpCabang::findOrFail($id);
        return response()->json(['success' => true, 'message' => 'Data view successfully', 'data' => $cabang]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_toko_cabang' => 'required|string|max:255',
            'alamat_cabang' => 'required|string|max:255',
            'phone_cabang' => 'required|string|digits_between:10,15',
            'email_cabang' => 'required|string|email|max:255',
            'latitude' => 'required|string|max:255',
            'longitude' => 'required|string|max:255',
        ]);

        // Find the record to update
        $cabang = OpCabang::findOrFail($id);

        // Update the Opgudang record
        $cabang->update([
            'nama_toko_cabang' => $request->nama_toko_cabang,
            'alamat_cabang' => $request->alamat_cabang,
            'phone_cabang' => $request->phone_cabang,
            'email_cabang' => $request->email_cabang,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json(['success' => true, 'message' => 'Data updated successfully', 'data' => $cabang]);
    }
}
