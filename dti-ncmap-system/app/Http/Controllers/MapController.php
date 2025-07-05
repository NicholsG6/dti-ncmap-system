<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfficeLocation;
use App\Models\StaffInformation;

class MapController extends Controller
{
    /**
     * Display the map view
     */
    public function index(Request $request)
    {
        $query = OfficeLocation::with(['staffMembers' => function($q) {
            $q->where('is_active', true);
        }])->where('is_active', true);

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

        $offices = $query->get();
        $provinces = OfficeLocation::where('is_active', true)
            ->distinct()
            ->pluck('province')
            ->sort();

        // Check if this is a debug request
        if ($request->route()->getName() === 'map.debug') {
            return view('map.debug', compact('offices', 'provinces'));
        }

        // Check if Google Maps API key is available
        $googleMapsKey = env('GOOGLE_MAPS_API_KEY');
        if (!$googleMapsKey || $googleMapsKey === 'YOUR_GOOGLE_MAPS_API_KEY_HERE') {
            // Redirect to OpenStreetMap version if no valid API key
            return redirect()->route('map.index.osm');
        }

        return view('map.index', compact('offices', 'provinces'));
    }

    /**
     * Display the map view with OpenStreetMap (fallback)
     */
    public function indexOSM(Request $request)
    {
        $query = OfficeLocation::with(['staffMembers' => function($q) {
            $q->where('is_active', true);
        }])->where('is_active', true);

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

        $offices = $query->get();
        $provinces = OfficeLocation::where('is_active', true)
            ->distinct()
            ->pluck('province')
            ->sort();

        return view('map.index-osm', compact('offices', 'provinces'));
    }

    /**
     * Get office data as JSON for map markers
     */
    public function getOfficesData(Request $request)
    {
        $query = OfficeLocation::with(['staffMembers' => function($q) {
            $q->where('is_active', true);
        }])->where('is_active', true);

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

        $offices = $query->get();

        return response()->json($offices->map(function($office) {
            return [
                'id' => $office->id,
                'office_name' => $office->office_name,
                'office_code' => $office->office_code,
                'latitude' => (float) $office->latitude,
                'longitude' => (float) $office->longitude,
                'complete_address' => $office->complete_address,
                'province' => $office->province,
                'municipality' => $office->municipality,
                'contact_number' => $office->contact_number,
                'email_address' => $office->email_address,
                'office_head' => $office->office_head,
                'office_description' => $office->office_description,
                'service_hours' => $office->service_hours,
                'staff_count' => $office->staffMembers->count(),
                'staff_members' => $office->staffMembers->map(function($staff) {
                    return [
                        'full_name' => $staff->full_name,
                        'position' => $staff->position,
                        'contact_person' => $staff->contact_person,
                        'cellphone_number' => $staff->cellphone_number,
                        'email_address' => $staff->email_address,
                    ];
                }),
            ];
        }));
    }

    /**
     * Show office details
     */
    public function showOffice(OfficeLocation $office)
    {
        $office->load(['staffMembers' => function($q) {
            $q->where('is_active', true);
        }]);

        return view('map.office-details', compact('office'));
    }

    /**
     * Show staff directory
     */
    public function staffDirectory(Request $request)
    {
        $query = StaffInformation::with('officeLocation')
            ->where('is_active', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('email_address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        if ($request->filled('province')) {
            $query->where('province', $request->province);
        }

        $staff = $query->orderBy('last_name')->orderBy('first_name')->paginate(12);
        
        $offices = OfficeLocation::active()->orderBy('office_name')->get();
        $provinces = StaffInformation::where('is_active', true)
            ->distinct()
            ->pluck('province')
            ->filter()
            ->sort();

        return view('map.staff-directory', compact('staff', 'offices', 'provinces'));
    }
}
