<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OpSetingLensa;

class lensaController extends Controller
{
    public function index()
    {
        return view("master.lensa.index");
    }

    public function DatasetingLensaJson()
    {
        $seting_lensa = OpSetingLensa::first();
        return response()->json(['message' => 'Data created successfully', 'data' => $seting_lensa]);
    }


    public function saveData(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'm_sph' => 'required|numeric',
            'm_cyl' => 'required|numeric',
            'm_axs' => 'required|numeric',
            'm_add' => 'required|numeric',
            's_sph' => 'required|numeric',
            's_cyl' => 'required|numeric',
            's_axs' => 'required|numeric',
            's_add' => 'required|numeric',
            'id' => 'nullable|exists:op_seting_lensa,id',
        ]);

        try {
            $seting_lensa = OpSetingLensa::updateOrCreate(
                ['id' => $request->id],
                [
                    'sph_dari' => $validated['m_sph'],
                    'cyl_dari' => $validated['m_cyl'],
                    'axs_dari' => $validated['m_axs'],
                    'add_dari' => $validated['m_add'],
                    'sph_sampai' => $validated['s_sph'],
                    'cyl_sampai' => $validated['s_cyl'],
                    'axs_sampai' => $validated['s_axs'],
                    'add_sampai' => $validated['s_add'],
                ]
            );

            return response()->json([
                'message' => $seting_lensa->wasRecentlyCreated ? 'Data has been successfully saved.' : 'Data has been successfully updated.',
                'data' => $seting_lensa,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while saving the data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
