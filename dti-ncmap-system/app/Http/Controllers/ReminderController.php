<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reminder;
use App\Models\OfficeLocation;
use App\Models\StaffInformation;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Reminder::with(['creator', 'officeLocation', 'staffMember']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('reminder_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('reminder_date', '<=', $request->date_to);
        }

        $reminders = $query->orderBy('reminder_date')->orderBy('reminder_time')->paginate(15);
        
        // Statistics
        $stats = [
            'total' => Reminder::count(),
            'active' => Reminder::where('status', 'Active')->count(),
            'high_priority' => Reminder::where('priority', 'High')->where('status', 'Active')->count(),
            'overdue' => Reminder::where('status', 'Active')->get()->filter(function($reminder) {
                return $reminder->is_overdue;
            })->count(),
        ];
        
        $offices = OfficeLocation::active()->orderBy('office_name')->get();
        $priorities = ['Low', 'Medium', 'High'];
        $statuses = ['Active', 'Completed', 'Cancelled'];

        return view('admin.reminders.index', compact('reminders', 'offices', 'priorities', 'statuses', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $offices = OfficeLocation::active()->orderBy('office_name')->get();
        $staff = StaffInformation::active()->orderBy('last_name')->orderBy('first_name')->get();
        
        return view('admin.reminders.create', compact('offices', 'staff'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reminder_date' => 'required|date',
            'reminder_time' => 'nullable|date_format:H:i',
            'priority' => 'required|in:Low,Medium,High',
            'status' => 'required|in:Active,Completed,Cancelled',
            'location_id' => 'nullable|exists:office_locations,id',
            'staff_id' => 'nullable|exists:staff_information,id',
        ]);

        $validated['created_by'] = auth()->id();

        Reminder::create($validated);

        return redirect()->route('admin.reminders.index')
            ->with('success', 'Reminder created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reminder $reminder)
    {
        $reminder->load(['creator', 'officeLocation', 'staffMember']);
        
        return view('admin.reminders.show', compact('reminder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reminder $reminder)
    {
        $offices = OfficeLocation::active()->orderBy('office_name')->get();
        $staff = StaffInformation::active()->orderBy('last_name')->orderBy('first_name')->get();
        
        return view('admin.reminders.edit', compact('reminder', 'offices', 'staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reminder $reminder)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reminder_date' => 'required|date',
            'reminder_time' => 'nullable|date_format:H:i',
            'priority' => 'required|in:Low,Medium,High',
            'status' => 'required|in:Active,Completed,Cancelled',
            'location_id' => 'nullable|exists:office_locations,id',
            'staff_id' => 'nullable|exists:staff_information,id',
        ]);

        $reminder->update($validated);

        return redirect()->route('admin.reminders.index')
            ->with('success', 'Reminder updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reminder $reminder)
    {
        $reminder->delete();

        return redirect()->route('admin.reminders.index')
            ->with('success', 'Reminder deleted successfully.');
    }
}
