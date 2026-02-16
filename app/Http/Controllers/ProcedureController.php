<?php

namespace App\Http\Controllers;
use App\Models\Procedure;
use App\Models\Clinic;

use Illuminate\Http\Request;

class ProcedureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $procedures = Procedure::latest()->paginate(10);

        return view('procedures.index', compact('procedures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clinics = Clinic::where('is_active', true)->get();
        return view('procedures.create', compact('clinics'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'clinic_id' => 'nullable|exists:clinics,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'education' => 'nullable|string',
            'default_duration_minutes' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        Procedure::create($data);

        return redirect()->route('procedures.index')
            ->with('success', 'Procedure created successfully.');
    }

    public function edit(Procedure $procedure)
    {
        $clinics = Clinic::where('is_active', true)->get();
        return view('procedures.edit', compact('procedure','clinics'));
    }

    public function update(Request $request, Procedure $procedure)
    {
        $data = $request->validate([
            'clinic_id' => 'nullable|exists:clinics,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'education' => 'nullable|string',
            'default_duration_minutes' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $procedure->update($data);

        return redirect()->route('procedures.index')
            ->with('success', 'Procedure updated successfully.');
    }

    public function destroy(Procedure $procedure)
    {
        $procedure->delete();

        return redirect()->route('procedures.index')
            ->with('success', 'Procedure deleted.');
    }
}