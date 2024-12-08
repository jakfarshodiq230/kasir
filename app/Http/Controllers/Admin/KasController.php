<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OpKas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasController extends Controller
{
    public function index()
    {
        return view("admin.kas.kas");
    }

    public function GetDataKas(Request $request)
    {
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $kas = OpKas::where('id_cabang', Auth::user()->id_cabang);

        if ($request->filled('tanggal_transaksi')) {
            $kas = $kas->whereDate('tanggal', $request->input('tanggal_transaksi'));
        }
        if ($request->filled('nomor_transaksi')) {
            $kas = $kas->where('kode_transaksi', $request->input('nomor_transaksi'));
        }

        $totalRecords = $kas->count();
        $kas->orderBy('tanggal', 'DESC');
        $kas = $kas->with('users', 'cabang')
            ->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $kas,
        ]);
    }

    public function deleteAndUpdateSaldo($id, $idCabang, Request $request)
    {
        $id = $id;
        $idCabang = $idCabang;
        try {
            $deleted = OpKas::where('id', $id)
                ->where('id_cabang', $idCabang)
                ->delete();

            if ($deleted) {
                $records = OpKas::where('id_cabang', $idCabang)->orderBy('tanggal')->get();
                $saldoAkhir = 0;

                foreach ($records as $record) {
                    $saldoAkhir += $record->debit - $record->kredit;
                    $record->saldo = $saldoAkhir;
                    $record->save(); // Save the updated record
                }
                return response()->json(['success' => true, 'message' => 'Record deleted and saldo updated']);
            } else {
                // If no record was found to delete
                return response()->json(['success' => false, 'message' => 'Record not found']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error occurred: ' . $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'jumlah_transaksi' => 'required|numeric',
            'keterangan_transaksi' => 'nullable|string',
            'jenis_transaksi' => 'required|string|in:debit,kredit',
        ]);

        try {

            $dateNowMinusOne = \Carbon\Carbon::now()->subDay()->format('Y-m-d');
            $randomNumber = rand(10000, 99999);
            $kodeTransaksi = $dateNowMinusOne . '-' . Auth::user()->id_cabang . '-' . $randomNumber;


            $opKas = new OpKas();
            $opKas->id_user = Auth::user()->id;
            $opKas->id_cabang = Auth::user()->id_cabang;
            $opKas->kode_transaksi = $kodeTransaksi;
            $opKas->tanggal = now();
            $opKas->keterangan = $validated['keterangan_transaksi'];

            if ($validated['jenis_transaksi'] == 'debit') {
                $opKas->debit = $validated['jumlah_transaksi'];
                $opKas->kredit = 0;
            } else {
                $opKas->kredit = $validated['jumlah_transaksi'];
                $opKas->debit = 0;
            }


            $lastRecord = OpKas::where('id_cabang', Auth::user()->id_cabang)
                ->orderBy('tanggal', 'desc')
                ->first();


            $saldoAkhir = $lastRecord ? $lastRecord->saldo + $opKas->debit - $opKas->kredit : $opKas->debit - $opKas->kredit;
            $opKas->saldo = $saldoAkhir;

            $opKas->save();

            return response()->json(['success' => true, 'message' => 'Record created successfully']);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => 'Error occurred: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'jumlah_transaksi' => 'required|numeric',
            'keterangan_transaksi' => 'nullable|string',
            'jenis_transaksi' => 'required|string|in:debit,kredit',
        ]);

        try {
            $opKas = OpKas::findOrFail($id);
            $oldDebit = $opKas->debit;
            $oldKredit = $opKas->kredit;
            $oldSaldo = $opKas->saldo;

            $opKas->keterangan = $validated['keterangan_transaksi'];

            if ($validated['jenis_transaksi'] == 'debit') {
                $opKas->debit = $validated['jumlah_transaksi'];
                $opKas->kredit = 0;
            } else {
                $opKas->kredit = $validated['jumlah_transaksi'];
                $opKas->debit = 0;
            }
            $opKas->saldo = $oldSaldo - $oldDebit + $opKas->debit - $oldKredit + $opKas->kredit;

            $opKas->save();

            $transactions = OpKas::where('id_cabang', Auth::user()->id_cabang)
                ->where('tanggal', '>=', $opKas->tanggal)
                ->orderBy('tanggal', 'asc')
                ->get();

            $currentSaldo = $opKas->saldo;

            foreach ($transactions as $transaction) {
                $currentSaldo += $transaction->debit - $transaction->kredit;
                $transaction->saldo = $currentSaldo;
                $transaction->save();
            }

            return response()->json(['success' => true, 'message' => 'Record updated and saldo updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error occurred: ' . $e->getMessage()]);
        }
    }

    public function edit($id, $kode)
    {
        $opKas = OpKas::where('id', $id)->where('id_cabang', $kode)->first();
        return response()->json(['success' => true, 'message' => 'Record updated and saldo updated successfully', 'data' => $opKas]);
    }
}
