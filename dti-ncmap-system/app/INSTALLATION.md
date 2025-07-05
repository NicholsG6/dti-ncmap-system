# DTI NCMAP System Installation Guide

## Overview
The DTI NCMAP System is a comprehensive Laravel-based web application for managing DTI Negosyo Centers in Region 7 with interactive map functionality.

## Features Implemented
- ✅ User Authentication (Admin/Guest roles)
- ✅ Admin Dashboard with statistics
- ✅ Office Location Management (CRUD)
- ✅ Staff Information Management (CRUD)
- ✅ Reminder System (CRUD)
- ✅ Interactive Map with Google Maps integration
- ✅ Public Staff Directory
- ✅ Search and Filter functionality
- ✅ Responsive Bootstrap 5 design
- ✅ Middleware for role-based access control
- ✅ Sample data seeding

## System Requirements
- PHP 8.1 or higher
- Composer
- MySQL 8.0 or higher
- Node.js and NPM (optional, for asset compilation)

## Installation Steps

### 1. Database Setup
Create a MySQL database named `dti_ncmap_system`

### 2. Environment Configuration
Copy the `.env.example` file to `.env` and configure:

```env
APP_NAME="DTI NCMAP System"
APP_ENV=local
APP_KEY=base64:your-generated-app-key
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dti_ncmap_system
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password

# Add your Google Maps API Key
GOOGLE_MAPS_API_KEY=your_google_maps_api_key_here
```

### 3. Install Dependencies
```bash
composer install
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Run Migrations and Seeders
```bash
php artisan migrate:fresh --seed
```

### 6. Start Development Server
```bash
php artisan serve
```

## Default Users
After seeding, you can login with:

**Admin User:**
- Email: admin@dti-ncmap.com
- Password: password

**Guest User:**
- Email: guest@dti-ncmap.com
- Password: password

## Google Maps Setup
1. Go to Google Cloud Console
2. Enable the Maps JavaScript API
3. Create an API key
4. Add the API key to your `.env` file as `GOOGLE_MAPS_API_KEY`
5. Update the Google Maps script in `resources/views/map/index.blade.php`

## File Structure

### Controllers
- `AuthController` - Authentication (login, register, logout)
- `DashboardController` - Admin dashboard with statistics
- `OfficeLocationController` - Office CRUD operations
- `StaffInformationController` - Staff CRUD operations
- `ReminderController` - Reminder CRUD operations
- `MapController` - Public map and staff directory

### Models
- `User` - User management with role methods
- `OfficeLocation` - Office locations with relationships
- `StaffInformation` - Staff data with relationships
- `Reminder` - Reminder system with priority/status

### Middleware
- `AdminMiddleware` - Restricts access to admin users only
- `GuestMiddleware` - Redirects authenticated users appropriately

### Views Structure
```
resources/views/
├── layouts/
│   └── app.blade.php          # Main application layout
├── auth/
│   ├── login.blade.php        # Login form
│   └── register.blade.php     # Registration form
├── admin/
│   ├── dashboard.blade.php    # Admin dashboard
│   ├── offices/              # Office management views
│   ├── staff/                # Staff management views
│   └── reminders/            # Reminder management views
└── map/
    ├── index.blade.php       # Interactive map
    ├── office-details.blade.php
    └── staff-directory.blade.php
```

## Usage

### Admin Functions
- View dashboard with statistics
- Manage office locations (add, edit, delete)
- Manage staff information (add, edit, delete)
- Manage reminders with priorities
- Access all system features

### Guest Functions
- View interactive map of all DTI offices
- Search and filter office locations
- View staff directory
- Get directions to offices
- View office details and staff information

## Features

### Interactive Map
- Google Maps integration showing all DTI office locations
- Custom markers for DTI offices
- Info windows with office details
- Direction functionality
- Search and filter capabilities

### Dashboard Analytics
- Total counts of offices, staff, reminders, and users
- Recent additions tracking
- Today's reminders display
- Upcoming reminders overview

### Search & Filter
- Office locations by name, code, address, province
- Staff by name, position, location, type code
- Reminders by title, location, priority, status, date range

### Responsive Design
- Bootstrap 5 framework
- Mobile-friendly interface
- Clean, professional UI
- Accessible navigation

## Testing the Application

1. Access the application at `http://localhost:8000`
2. You'll be redirected to the map view
3. Login using the default admin credentials
4. Test the admin dashboard and CRUD operations
5. Logout and test guest functionality

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check your `.env` database credentials
   - Ensure MySQL is running
   - Verify database exists

2. **Google Maps Not Loading**
   - Check your Google Maps API key
   - Ensure Maps JavaScript API is enabled
   - Verify API key restrictions

3. **Permission Errors**
   - Ensure storage and bootstrap/cache directories are writable
   - Run: `chmod -R 775 storage bootstrap/cache`

4. **Composer/Dependencies Issues**
   - Run: `composer clear-cache`
   - Delete vendor folder and run: `composer install`

## Next Steps

### Recommended Enhancements
1. Add file upload for staff photos
2. Implement email notifications for reminders
3. Add more detailed analytics and reports
4. Implement data export functionality
5. Add API endpoints for mobile app integration
6. Enhance security with additional validation
7. Add audit trails for data changes

## Support
For issues or questions, refer to Laravel documentation or contact the development team.
