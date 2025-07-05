<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StaffInformation;
use App\Models\OfficeLocation;

class StaffInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = StaffInformation::with(['creator', 'officeLocation']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email_address', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%");
            });
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        if ($request->filled('type_code')) {
            $query->where('type_code', $request->type_code);
        }

        if ($request->filled('province')) {
            $query->where('province', $request->province);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $staff = $query->orderBy('last_name')->orderBy('first_name')->paginate(15);
        
        // Statistics
        $staffStats = [
            'total' => StaffInformation::count(),
            'active' => StaffInformation::where('is_active', true)->count(),
            'type_a' => StaffInformation::where('type_code', 'A')->count(),
            'type_b' => StaffInformation::where('type_code', 'B')->count(),
            'type_c' => StaffInformation::where('type_code', 'C')->count(),
        ];
        
        $offices = OfficeLocation::active()->orderBy('office_name')->get();
        $typeCodes = StaffInformation::distinct()->pluck('type_code')->filter()->sort();
        $provinces = StaffInformation::distinct()->pluck('province')->filter()->sort();

        return view('admin.staff.index', compact('staff', 'staffStats', 'offices', 'typeCodes', 'provinces'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $offices = OfficeLocation::active()->orderBy('office_name')->get();
        return view('admin.staff.create', compact('offices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_created' => 'required|date',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'region' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'complete_address' => 'required|string',
            'location_id' => 'required|exists:office_locations,id',
            'remarks' => 'nullable|string',
            'type_advanced' => 'nullable|string|max:255',
            'type_code' => 'nullable|string|max:255',
            'service_area' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'cellphone_number' => 'nullable|string|max:20',
            'email_address' => 'nullable|email|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['created_by'] = auth()->id();

        StaffInformation::create($validated);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff information created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StaffInformation $staff)
    {
        $staff->load(['creator', 'officeLocation', 'reminders']);
        
        return view('admin.staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StaffInformation $staff)
    {
        $offices = OfficeLocation::active()->orderBy('office_name')->get();
        return view('admin.staff.edit', compact('staff', 'offices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StaffInformation $staff)
    {
        $validated = $request->validate([
            'date_created' => 'required|date',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'region' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'complete_address' => 'required|string',
            'location_id' => 'required|exists:office_locations,id',
            'remarks' => 'nullable|string',
            'type_advanced' => 'nullable|string|max:255',
            'type_code' => 'nullable|string|max:255',
            'service_area' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'cellphone_number' => 'nullable|string|max:20',
            'email_address' => 'nullable|email|max:255',
            'is_active' => 'boolean',
        ]);

        $staff->update($validated);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StaffInformation $staff)
    {
        $staff->delete();

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff information deleted successfully.');
    }
}
