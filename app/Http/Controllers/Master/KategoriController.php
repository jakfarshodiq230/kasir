<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OpKategori;

class KategoriController extends Controller
{
    public function index()
    {
        return view("master.kategori.index");
    }

    public function DatakategoriJson()
    {
        $kategori = OpKategori::all();
        return response()->json(['message' => 'Data created successfully', 'data' => $kategori]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:op_kategori,nama_kategori',
            'pesan_kategori' => 'required|string',
        ]);

        $kategori = OpKategori::create([
            'nama_kategori' => $request->nama_kategori,
            'pesanan' => $request->pesan_kategori,
            'status' => 1,
        ]);

        return response()->json(['success' => true, 'message' => 'Data created successfully', 'data' => $kategori]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'pesan_kategori' => 'required|string',
        ]);

        // Find the record to update
        $kategori = OpKategori::findOrFail($id);

        // Update the OpKategori record
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'pesanan' => $request->pesan_kategori,
        ]);

        return response()->json(['success' => true, 'message' => 'Data updated successfully', 'data' => $kategori]);
    }

    public function destroy($id)
    {
        $kategori = OpKategori::findOrFail($id);
        $kategori->delete();
        return response()->json(['success' => true, 'message' => 'Data deleted successfully']);
    }

    public function viewData($id)
    {
        $kategori = OpKategori::findOrFail($id);
        return response()->json(['success' => true, 'message' => 'Data view successfully', 'data' => $kategori]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1',
        ]);

        $kategori = OpKategori::findOrFail($id);

        $kategori->status = $request->status;
        $kategori->save();

        return response()->json([
            'success' => true,
            'message' => $request->status === 1 ? 'Item activated successfully.' : 'Item deactivated successfully.',
        ]);
    }
}
