<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OpToko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokoController extends Controller
{
    public function index()
    {
        $owner = OpToko::find(Auth::user()->id_toko);
        return view("master.toko.toko", compact('owner'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255',
            'phone_toko' => 'required|string|digits_between:10,15',
            'alamat_toko' => 'required|string|max:255',
        ]);

        $owner = OpToko::findOrFail($id);

        if ($request->has('email_toko') && $request->email_toko !== $owner->email_toko) {
            $request->validate([
                'email_toko' => 'nullable|email|max:255',
            ]);
        }

        $updatedData = [
            'nama_toko' => $request->nama_toko,
            'nama_pemilik' => $request->nama_pemilik,
            'phone_toko' => $request->phone_toko,
            'alamat_toko' => $request->alamat_toko,
        ];

        if ($request->has('email_toko') && $request->email_toko !== $owner->email_toko) {
            $updatedData['email_toko'] = $request->email_toko;
        }
        $owner->update($updatedData);

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Data updated successfully',
        ]);
    }
}
