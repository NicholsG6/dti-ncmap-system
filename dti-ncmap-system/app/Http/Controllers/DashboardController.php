<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfficeLocation;
use App\Models\StaffInformation;
use App\Models\Reminder;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_offices' => OfficeLocation::count(),
            'active_offices' => OfficeLocation::where('is_active', true)->count(),
            'total_staff' => StaffInformation::count(),
            'active_staff' => StaffInformation::where('is_active', true)->count(),
            'total_reminders' => Reminder::count(),
            'active_reminders' => Reminder::where('status', 'Active')->count(),
            'total_users' => User::count(),
            'admin_users' => User::where('user_type', 'admin')->count(),
        ];

        $recentOffices = OfficeLocation::with('creator')
            ->latest()
            ->take(5)
            ->get();

        $recentStaff = StaffInformation::with(['creator', 'officeLocation'])
            ->latest()
            ->take(5)
            ->get();

        $upcomingReminders = Reminder::with(['officeLocation', 'staffMember'])
            ->upcoming()
            ->take(10)
            ->get();

        $todaysReminders = Reminder::with(['officeLocation', 'staffMember'])
            ->today()
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOffices',
            'recentStaff',
            'upcomingReminders',
            'todaysReminders'
        ));
    }
}
