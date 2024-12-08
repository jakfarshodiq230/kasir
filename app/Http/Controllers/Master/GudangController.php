<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OpGudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index()
    {
        return view("master.gudang.index");
    }

    public function DataGudangJson()
    {
        $gudang = OpGudang::all();
        return response()->json(['message' => 'Data get successfully', 'data' => $gudang]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_gudang' => 'required|string|max:255|unique:op_gudang,nama_gudang',
            'lokasi_gudang' => 'required|string|max:255',
            'deskripsi_gudang' => 'required|string|max:255',
        ]);

        $gudang = OpGudang::create([
            'nama_gudang' => $request->nama_gudang,
            'lokasi_gudang' => $request->lokasi_gudang,
            'deskripsi_gudang' => $request->deskripsi_gudang,
            'status_gudang' => 1,
        ]);

        return response()->json(['success' => true, 'message' => 'Data created successfully', 'data' => $gudang]);
    }

    public function destroy($id)
    {
        $gudang = OpGudang::findOrFail($id);
        $gudang->delete();
        return response()->json(['success' => true, 'message' => 'Data deleted successfully']);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_gudang' => 'required|in:0,1',
        ]);

        $gudang = OpGudang::findOrFail($id);

        $gudang->status_gudang = $request->status_gudang;
        $gudang->save();

        return response()->json([
            'success' => true,
            'message' => $request->status_gudang === 1 ? 'Item activated successfully.' : 'Item deactivated successfully.',
        ]);
    }

    public function viewData($id)
    {
        $gudang = OpGudang::findOrFail($id);
        return response()->json(['success' => true, 'message' => 'Data view successfully', 'data' => $gudang]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_gudang' => 'required|string|max:255',
            'lokasi_gudang' => 'required|string|max:255',
            'deskripsi_gudang' => 'required|string|max:255',
        ]);

        // Find the record to update
        $gudang = OpGudang::findOrFail($id);

        // Update the Opgudang record
        $gudang->update([
            'nama_gudang' => $request->nama_gudang,
            'lokasi_gudang' => $request->lokasi_gudang,
            'deskripsi_gudang' => $request->deskripsi_gudang,
        ]);

        return response()->json(['success' => true, 'message' => 'Data updated successfully', 'data' => $gudang]);
    }
}
