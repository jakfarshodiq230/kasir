<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OpCabang;
use App\Models\OpKas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasController extends Controller
{
    public function index()
    {
        $cabang = OpCabang::where('id_toko', Auth::user()->id_toko)->get();
        return view("master.kas.kas", compact('cabang'));
    }

    public function GatDataKas(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'id_cabang' => 'required',
        ]);

        $startDate = Carbon::parse($request->startDate)->toDateString();
        $endDate = Carbon::parse($request->endDate)->toDateString();

        $kas = OpKas::where('id_cabang', $request->id_cabang)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'asc')
            ->with(['users', 'cabang'])
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data loaded successfully',
            'data' => $kas,
        ]);
    }
}
