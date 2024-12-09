<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OpSession;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DivaceController extends Controller
{
    public function index()
    {
        return view("master.divace.divace");
    }

    public function GetDataDivace(Request $request)
    {
        $divace = OpSession::orderBy('last_activity', 'DESC')
            ->with(['user'])
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data loaded successfully',
            'data' => $divace,
        ]);
    }
}
