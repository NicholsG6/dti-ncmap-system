<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\OfficeLocation;
use App\Models\StaffInformation;
use App\Models\Reminder;

class CheckData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check database data and display counts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== DTI-NCMAP Database Check ===');
        
        $this->info('Users: ' . User::count());
        $this->info('- Admins: ' . User::where('user_type', 'admin')->count());
        $this->info('- Guests: ' . User::where('user_type', 'guest')->count());
        
        $this->info('Office Locations: ' . OfficeLocation::count());
        $this->info('- Active: ' . OfficeLocation::where('is_active', true)->count());
        
        $this->info('Staff Information: ' . StaffInformation::count());
        $this->info('- Active: ' . StaffInformation::where('is_active', true)->count());
        
        $this->info('Reminders: ' . Reminder::count());
        
        $this->info('=== Office Details ===');
        $offices = OfficeLocation::with('staffMembers')->get();
        foreach ($offices as $office) {
            $this->info("{$office->office_name} ({$office->office_code})");
            $this->info("  Latitude: {$office->latitude}, Longitude: {$office->longitude}");
            $this->info("  Staff: {$office->staffMembers->count()}");
        }
        
        $this->info('=== Reminder Test ===');
        $reminder = Reminder::first();
        if ($reminder) {
            $this->info("Reminder: {$reminder->title}");
            $this->info("Date: {$reminder->reminder_date}");
            $this->info("Time: " . ($reminder->reminder_time ?? 'null'));
            try {
                $dateTime = $reminder->reminder_date_time;
                $this->info("DateTime: " . ($dateTime ? $dateTime->toString() : 'null'));
                $this->info("Time Input: " . ($reminder->reminder_time_input ?? 'null'));
                $this->info("Is Overdue: " . ($reminder->is_overdue ? 'Yes' : 'No'));
                $this->info("Priority Color: " . $reminder->priority_color);
            } catch (\Exception $e) {
                $this->error("Error with reminder attributes: " . $e->getMessage());
            }
        } else {
            $this->info("No reminders found");
        }
        
        // Test edge cases
        $this->info('=== Testing Edge Cases ===');
        try {
            $testReminder = new Reminder([
                'title' => 'Test Reminder',
                'reminder_date' => null,
                'reminder_time' => null,
                'priority' => 'High',
                'status' => 'Active'
            ]);
            
            $this->info("Null date/time test:");
            $this->info("- DateTime: " . ($testReminder->reminder_date_time ?? 'null'));
            $this->info("- Time Input: " . ($testReminder->reminder_time_input ?? 'null'));
            $this->info("- Is Overdue: " . ($testReminder->is_overdue ? 'Yes' : 'No'));
            $this->info("✅ Edge case handling successful");
        } catch (\Exception $e) {
            $this->error("❌ Edge case failed: " . $e->getMessage());
        }
        
        $this->info('=== Dashboard Test ===');
        try {
            $todaysReminders = Reminder::today()->get();
            $upcomingReminders = Reminder::upcoming()->take(5)->get();
            
            $this->info("Today's reminders: " . $todaysReminders->count());
            $this->info("Upcoming reminders: " . $upcomingReminders->count());
            
            if ($todaysReminders->count() > 0) {
                $firstReminder = $todaysReminders->first();
                $this->info("First reminder time input: " . ($firstReminder->reminder_time_input ?? 'null'));
            }
            
            $this->info("✅ Dashboard data retrieval successful");
        } catch (\Exception $e) {
            $this->error("❌ Dashboard error: " . $e->getMessage());
        }
        
        $this->info('=== Environment Check ===');
        $this->info('DB_CONNECTION: ' . config('database.default'));
        $this->info('DB_DATABASE: ' . config('database.connections.mysql.database'));
        $this->info('GOOGLE_MAPS_API_KEY: ' . (env('GOOGLE_MAPS_API_KEY') ? 'Set (length: ' . strlen(env('GOOGLE_MAPS_API_KEY')) . ')' : 'Not Set'));
        
        return 0;
    }
}
