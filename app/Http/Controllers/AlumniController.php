<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index()
    {
        $alumni = Alumni::all();
        return $alumni->isEmpty() ? response()->json(['message' => 'Data is Empty'], 404) : response()->json($alumni);
    }

    public function show($id)
    {
        $alumni = Alumni::find($id);
        return $alumni ? response()->json($alumni) : response()->json(['message' => 'Resource not found'], 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'graduation_year' => 'required|integer',
            'status' => 'required|string',
            'company_name' => 'nullable|string',
            'position' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $alumni = Alumni::create($request->all());
        return response()->json(['message' => 'Resource is added successfully', 'data' => $alumni], 201);
    }

    public function update(Request $request, $id)
    {
        $alumni = Alumni::find($id);
        if (!$alumni) {
            return response()->json(['message' => 'Resource not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'phone' => 'string|max:15',
            'address' => 'string',
            'graduation_year' => 'integer',
            'status' => 'string',
            'company_name' => 'nullable|string',
            'position' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $alumni->update($request->all());
        return response()->json(['message' => 'Resource updated successfully', 'data' => $alumni]);
    }

    public function destroy($id)
    {
        $alumni = Alumni::find($id);
        if (!$alumni) {
            return response()->json(['message' => 'Resource not found'], 404);
        }

        $alumni->delete();
        return response()->json(['message' => 'Resource deleted successfully']);
    }

    public function searchByName($name)
    {
        $alumni = Alumni::where('name', 'like', "%$name%")->get();
        return $alumni->isEmpty() ? response()->json(['message' => 'Data is Empty'], 404) : response()->json($alumni);
    }

    public function getRecentGraduates()
    {
        $alumni = Alumni::where('graduation_year', date('Y'))->get();
        return $alumni->isEmpty() ? response()->json(['message' => 'Data is Empty'], 404) : response()->json($alumni);
    }

    public function getEmployed()
    {
        $alumni = Alumni::whereNotNull('company_name')->get();
        return $alumni->isEmpty() ? response()->json(['message' => 'Data is Empty'], 404) : response()->json($alumni);
    }

    public function getUnemployed()
    {
        $alumni = Alumni::whereNull('company_name')->get();
        return $alumni->isEmpty() ? response()->json(['message' => 'Data is Empty'], 404) : response()->json($alumni);
    }
}
