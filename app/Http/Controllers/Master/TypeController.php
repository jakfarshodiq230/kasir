<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OpType;

class TypeController extends Controller
{
    public function index()
    {
        return view("master.type.index");
    }

    public function DatatypeJson()
    {
        $type = OpType::all();
        return response()->json(['message' => 'Data created successfully', 'data' => $type]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255|unique:op_type,type',
        ]);

        $type = OpType::create([
            'type' => $request->type,
            'status_type' => 1,
        ]);

        return response()->json(['success' => true, 'message' => 'Data created successfully', 'data' => $type]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string|max:255|unique:op_type,type,' . $id,
        ]);

        // Find the record to update
        $type = OpType::findOrFail($id);

        // Update the OpType record
        $type->update([
            'type' => $request->type,
        ]);

        return response()->json(['success' => true, 'message' => 'Data updated successfully', 'data' => $type]);
    }

    public function destroy($id)
    {
        $type = OpType::findOrFail($id);
        $type->delete();
        return response()->json(['success' => true, 'message' => 'Data deleted successfully']);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_type' => 'required|in:0,1',
        ]);

        $type = OpType::findOrFail($id);

        $type->status_type = $request->status_type;
        $type->save();

        return response()->json([
            'success' => true,
            'message' => $request->status_type === 1 ? 'Item activated successfully.' : 'Item deactivated successfully.',
        ]);
    }
}
