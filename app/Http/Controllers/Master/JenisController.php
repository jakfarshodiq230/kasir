<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OpJenis;

class JenisController extends Controller
{
    public function index()
    {
        return view("master.jenis.index");
    }

    public function DataJenisJson()
    {
        $jenis = OpJenis::all();
        return response()->json(['message' => 'Data created successfully', 'data' => $jenis]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|string|max:255|unique:op_jenis,jenis',
        ]);

        $jenis = OpJenis::create([
            'jenis' => $request->jenis,
            'status_jenis' => 1,
        ]);

        return response()->json(['success' => true, 'message' => 'Data created successfully', 'data' => $jenis]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required|string|max:255|unique:op_jenis,jenis,' . $id,
        ]);

        // Find the record to update
        $jenis = OpJenis::findOrFail($id);

        // Update the OpJenis record
        $jenis->update([
            'jenis' => $request->jenis,
        ]);

        return response()->json(['success' => true, 'message' => 'Data updated successfully', 'data' => $jenis]);
    }

    public function destroy($id)
    {
        $jenis = OpJenis::findOrFail($id);
        $jenis->delete();
        return response()->json(['success' => true, 'message' => 'Data deleted successfully']);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_jenis' => 'required|in:0,1',
        ]);

        $jenis = OpJenis::findOrFail($id);

        $jenis->status_jenis = $request->status_jenis;
        $jenis->save();

        return response()->json([
            'success' => true,
            'message' => $request->status_jenis === 1 ? 'Item activated successfully.' : 'Item deactivated successfully.',
        ]);
    }
}
