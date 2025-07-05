<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfficeLocation;

class OfficeLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = OfficeLocation::with('creator');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('office_name', 'like', "%{$search}%")
                  ->orWhere('office_code', 'like', "%{$search}%")
                  ->orWhere('complete_address', 'like', "%{$search}%")
                  ->orWhere('province', 'like', "%{$search}%")
                  ->orWhere('municipality', 'like', "%{$search}%");
            });
        }

        if ($request->filled('province')) {
            $query->where('province', $request->province);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $offices = $query->orderBy('office_name')->paginate(15);
        $provinces = OfficeLocation::distinct()->pluck('province')->sort();

        return view('admin.offices.index', compact('offices', 'provinces'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.offices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'office_name' => 'required|string|max:255',
            'office_code' => 'required|string|max:50|unique:office_locations',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'complete_address' => 'required|string',
            'region' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'email_address' => 'nullable|email|max:255',
            'office_head' => 'nullable|string|max:255',
            'office_description' => 'nullable|string',
            'service_hours' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['created_by'] = auth()->id();

        OfficeLocation::create($validated);

        return redirect()->route('admin.offices.index')
            ->with('success', 'Office location created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OfficeLocation $office)
    {
        $office->load(['creator', 'staffMembers', 'reminders']);
        
        return view('admin.offices.show', compact('office'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OfficeLocation $office)
    {
        return view('admin.offices.edit', compact('office'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OfficeLocation $office)
    {
        $validated = $request->validate([
            'office_name' => 'required|string|max:255',
            'office_code' => 'required|string|max:50|unique:office_locations,office_code,' . $office->id,
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'complete_address' => 'required|string',
            'region' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'email_address' => 'nullable|email|max:255',
            'office_head' => 'nullable|string|max:255',
            'office_description' => 'nullable|string',
            'service_hours' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $office->update($validated);

        return redirect()->route('admin.offices.index')
            ->with('success', 'Office location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OfficeLocation $office)
    {
        $office->delete();

        return redirect()->route('admin.offices.index')
            ->with('success', 'Office location deleted successfully.');
    }
}
