<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OpCabang;
use App\Models\OpGudang;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $cabang = OpCabang::all();
        $gudang = OpGudang::all();
        return view("master.karyawan.index", compact('cabang', 'gudang'));
    }

    public function DataKaryawanJson()
    {

        $users = User::where('level_user', '!=', 'owner')->with(['toko', 'cabang', 'gudang'])->get();
        return response()->json(['message' => 'Data created successfully', 'data' => $users]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email',
            'level_user' => 'required|string|max:255',
            'id_cabang' => 'required|string|max:255',
            'id_gudang' => 'nullable|string|max:255',
        ]);

        $users = User::create([
            'id_toko' => $request->id_toko,
            'id_cabang' => $request->id_cabang,
            'id_gudang' => $request->id_gudang,
            'name' => $request->name,
            'email' => $request->email,
            'password' => '1234567890',
            'level_user' => $request->level_user,
            'status_user' => 1,
        ]);

        return response()->json(['success' => true, 'message' => 'Data created successfully', 'data' => $users]);
    }

    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete();
        return response()->json(['success' => true, 'message' => 'Data deleted successfully']);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_user' => 'required|in:0,1',
        ]);

        $users = User::findOrFail($id);

        $users->status_user = $request->status_user;
        $users->save();

        return response()->json([
            'success' => true,
            'message' => $request->status_user === 1 ? 'Item activated successfully.' : 'Item deactivated successfully.',
        ]);
    }

    public function viewData($id)
    {
        $users = User::findOrFail($id);
        return response()->json(['success' => true, 'message' => 'Data view successfully', 'data' => $users]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'level_user' => 'required|string|max:255',
            'id_cabang' => 'required|string|max:255',
            'id_gudang' => 'nullable|string|max:255',

        ]);

        // Find the record to update
        $users = User::findOrFail($id);

        // Update the OpKategori record
        $users->update([
            'id_cabang' => $request->id_cabang,
            'id_gudang' => $request->id_gudang,
            'name' => $request->name,
            'email' => $request->email,
            'level_user' => $request->level_user,
        ]);

        return response()->json(['success' => true, 'message' => 'Data updated successfully', 'data' => $users]);
    }
}
