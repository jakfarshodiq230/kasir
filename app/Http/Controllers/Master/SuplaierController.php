<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OpSuplaier;
use Illuminate\Http\Request;

class SuplaierController extends Controller
{
    public function index()
    {
        return view("master.suplaier.index");
    }

    public function DataSuplaierJson()
    {
        $suplaier = OpSuplaier::all();
        return response()->json(['message' => 'Data get successfully', 'data' => $suplaier]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_suplaier' => 'required|string|max:255',
            'nama_instansi_suplaier' => 'required|string|max:255|unique:op_suplaier,nama_suplaier',
            'kontak_suplaier' => 'required|numeric|digits_between:1,15',
            'alamat_suplaier' => 'required|string|max:255',
            'keterangan_suplaier' => 'required|string|max:255',
        ]);

        $suplaier = OpSuplaier::create([
            'nama_suplaier' => $request->nama_suplaier,
            'nama_instansi_suplaier' => $request->nama_instansi_suplaier,
            'kontak_suplaier' => $request->kontak_suplaier,
            'alamat_suplaier' => $request->alamat_suplaier,
            'keterangan_suplaier' => $request->keterangan_suplaier,
            'status_suplaier' => 1,
        ]);

        return response()->json(['success' => true, 'message' => 'Data created successfully', 'data' => $suplaier]);
    }
}
