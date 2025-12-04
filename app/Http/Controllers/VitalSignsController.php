<?php

namespace App\Http\Controllers;

use App\Models\Vital_Signs;
use App\Http\Requests\StoreVital_SignsRequest;
use App\Http\Requests\UpdateVital_SignsRequest;

class VitalSignsController extends Controller
{
    public function index()
    {
        $vitals = Vital_Signs::latest()->paginate(10);
        return view('vital_signs.index', compact('vitals'));
    }

    public function create()
    {
        return view('vital_signs.create');
    }

    public function store(StoreVital_SignsRequest $request)
{
    // Validate input via request file
    $validated = $request->validated();

    // Create a vital sign record
    $vital = \App\Models\Vital_Signs::create($validated);

    return redirect()
        ->back()
        ->with('success', 'Vital Signs successfully saved!');
}


    public function show(Vital_Signs $vital_Signs)
    {
        return view('vital_signs.show', compact('vital_Signs'));
    }

    public function edit(Vital_Signs $vital_Signs)
    {
        return view('vital_signs.edit', compact('vital_Signs'));
    }

    public function update(UpdateVital_SignsRequest $request, Vital_Signs $vital_Signs)
    {
        $validated = $request->validated();
        $vital_Signs->update($validated);

        return redirect()
            ->route('vital-signs.index')
            ->with('success', 'Vital signs updated successfully.');
    }


    public function destroy(Vital_Signs $vital_Signs)
    {
        $vital_Signs->delete();

        return redirect()
            ->route('vital-signs.index')
            ->with('success', 'Vital signs deleted successfully.');
    }
}
    
