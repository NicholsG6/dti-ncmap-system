<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\OfficeLocation;
use App\Models\StaffInformation;
use App\Models\Reminder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@dti-ncmap.com',
            'password' => Hash::make('password'),
            'full_name' => 'DTI NCMAP Administrator',
            'user_type' => 'admin',
            'is_active' => true,
        ]);

        // Create guest user
        $guest = User::create([
            'name' => 'guest',
            'email' => 'guest@dti-ncmap.com',
            'password' => Hash::make('password'),
            'full_name' => 'Guest User',
            'user_type' => 'guest',
            'is_active' => true,
        ]);

        // Sample Office Locations in Region 7
        $offices = [
            [
                'office_name' => 'DTI Cebu Provincial Office',
                'office_code' => 'DTI-CEBU-PROV',
                'latitude' => 10.3157,
                'longitude' => 123.8854,
                'complete_address' => 'Capitol Site, Cebu City, Cebu',
                'region' => 'Region VII - Central Visayas',
                'province' => 'Cebu',
                'municipality' => 'Cebu City',
                'district' => 'Capitol Site',
                'contact_number' => '(032) 255-6330',
                'email_address' => 'cebu.provincial@dti.gov.ph',
                'office_head' => 'Maria Santos',
                'office_description' => 'Main DTI office for Cebu Province',
                'service_hours' => '8:00 AM - 5:00 PM (Monday to Friday)',
                'is_active' => true,
                'created_by' => $admin->id,
            ],
            [
                'office_name' => 'DTI Bohol Provincial Office',
                'office_code' => 'DTI-BOHOL-PROV',
                'latitude' => 9.6474,
                'longitude' => 123.8621,
                'complete_address' => 'CPG Avenue, Tagbilaran City, Bohol',
                'region' => 'Region VII - Central Visayas',
                'province' => 'Bohol',
                'municipality' => 'Tagbilaran City',
                'district' => 'CPG Avenue',
                'contact_number' => '(038) 501-8888',
                'email_address' => 'bohol.provincial@dti.gov.ph',
                'office_head' => 'Juan Dela Cruz',
                'office_description' => 'Main DTI office for Bohol Province',
                'service_hours' => '8:00 AM - 5:00 PM (Monday to Friday)',
                'is_active' => true,
                'created_by' => $admin->id,
            ],
            [
                'office_name' => 'DTI Negros Oriental Provincial Office',
                'office_code' => 'DTI-NEGOR-PROV',
                'latitude' => 9.3073,
                'longitude' => 123.3035,
                'complete_address' => 'Rizal Boulevard, Dumaguete City, Negros Oriental',
                'region' => 'Region VII - Central Visayas',
                'province' => 'Negros Oriental',
                'municipality' => 'Dumaguete City',
                'district' => 'Rizal Boulevard',
                'contact_number' => '(035) 422-6301',
                'email_address' => 'negros.oriental@dti.gov.ph',
                'office_head' => 'Ana Rodriguez',
                'office_description' => 'Main DTI office for Negros Oriental Province',
                'service_hours' => '8:00 AM - 5:00 PM (Monday to Friday)',
                'is_active' => true,
                'created_by' => $admin->id,
            ],
        ];

        foreach ($offices as $officeData) {
            $office = OfficeLocation::create($officeData);

            // Add sample staff for each office
            $staff = [
                [
                    'date_created' => now(),
                    'first_name' => 'John',
                    'middle_name' => 'A.',
                    'last_name' => 'Doe',
                    'gender' => 'Male',
                    'region' => $officeData['region'],
                    'province' => $officeData['province'],
                    'municipality' => $officeData['municipality'],
                    'district' => $officeData['district'],
                    'complete_address' => 'Sample Address, ' . $officeData['municipality'],
                    'location_id' => $office->id,
                    'remarks' => 'Sample staff member',
                    'type_advanced' => 'Senior',
                    'type_code' => 'BUSDEV',
                    'service_area' => 'Business Development',
                    'contact_person' => 'John A. Doe',
                    'position' => 'Business Development Officer',
                    'cellphone_number' => '09123456789',
                    'email_address' => 'john.doe@dti.gov.ph',
                    'is_active' => true,
                    'created_by' => $admin->id,
                ],
                [
                    'date_created' => now(),
                    'first_name' => 'Jane',
                    'middle_name' => 'B.',
                    'last_name' => 'Smith',
                    'gender' => 'Female',
                    'region' => $officeData['region'],
                    'province' => $officeData['province'],
                    'municipality' => $officeData['municipality'],
                    'district' => $officeData['district'],
                    'complete_address' => 'Sample Address 2, ' . $officeData['municipality'],
                    'location_id' => $office->id,
                    'remarks' => 'Sample staff member',
                    'type_advanced' => 'Regular',
                    'type_code' => 'TRADEIND',
                    'service_area' => 'Trade and Industry',
                    'contact_person' => 'Jane B. Smith',
                    'position' => 'Trade and Industry Officer',
                    'cellphone_number' => '09987654321',
                    'email_address' => 'jane.smith@dti.gov.ph',
                    'is_active' => true,
                    'created_by' => $admin->id,
                ],
            ];

            foreach ($staff as $staffData) {
                $staffMember = StaffInformation::create($staffData);

                // Add sample reminders
                Reminder::create([
                    'title' => 'Monthly Report Submission',
                    'description' => 'Submit monthly activity report to regional office',
                    'reminder_date' => now()->addDays(7),
                    'reminder_time' => '09:00',
                    'priority' => 'High',
                    'status' => 'Active',
                    'location_id' => $office->id,
                    'staff_id' => $staffMember->id,
                    'created_by' => $admin->id,
                ]);
            }

            // Add office-level reminder
            Reminder::create([
                'title' => 'Quarterly Assessment',
                'description' => 'Conduct quarterly performance assessment for all staff',
                'reminder_date' => now()->addDays(30),
                'reminder_time' => '14:00',
                'priority' => 'Medium',
                'status' => 'Active',
                'location_id' => $office->id,
                'staff_id' => null,
                'created_by' => $admin->id,
            ]);
        }
    }
}
