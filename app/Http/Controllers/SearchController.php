<?php

namespace App\Http\Controllers;

use App\Models\OpPesananLog;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'nomor_transaksi' => 'required',
        ]);

        $penjualan = OpPesananLog::where('nomor_transaksi', $request->nomor_transaksi)
            ->orderBy('created_at', 'ASC')
            ->get();

        if ($penjualan->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No data found for the provided transaction number.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data loaded successfully',
            'data' => $penjualan,
        ]);
    }
}
