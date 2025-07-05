# DTI-NCMAP System Setup Instructions

## ⚠️ Issues Found and Solutions

### 1. Database Configuration Issue
**Problem**: The system is currently using SQLite instead of MySQL.

**Solution**: Update your `.env` file with the following database configuration:

```env
# Replace these lines in your .env file:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dti_ncmap_system
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Google Maps API Key Missing
**Problem**: Maps won't load without API key.

**Solution**: Add your Google Maps API key to `.env`:
```env
GOOGLE_MAPS_API_KEY=your_actual_google_maps_api_key_here
```

## 🔧 Setup Steps

### Step 1: Database Setup
1. **Create MySQL Database**:
   ```sql
   CREATE DATABASE dti_ncmap_system;
   ```

2. **Update Environment File**:
   - Open `dti-ncmap-system/.env`
   - Change database settings to MySQL (see above)

### Step 2: Run Migrations and Seeders
```bash
cd dti-ncmap-system
php artisan config:clear
php artisan migrate:fresh --seed
```

### Step 3: Install Dependencies (if needed)
```bash
composer install
npm install && npm run build
```

### Step 4: Start the Server
```bash
php artisan serve
```

## 👥 Default Login Credentials

- **Admin User**: 
  - Email: admin@dti-ncmap.com
  - Password: password

- **Guest User**:
  - Email: guest@dti-ncmap.com  
  - Password: password

## 🗺️ Accessing the System

- **Public Map**: http://localhost:8000/map
- **Login Page**: http://localhost:8000/login
- **Admin Dashboard**: http://localhost:8000/admin/dashboard (after admin login)

## ✅ Features Implemented

### Admin Features:
- ✅ Dashboard with statistics
- ✅ Office Locations CRUD
- ✅ Staff Information CRUD
- ✅ Reminders Management
- ✅ Interactive Map Management

### Guest Features:
- ✅ View Interactive Map
- ✅ Search Office Locations
- ✅ View Staff Directory
- ✅ Get Directions

### Technical Features:
- ✅ Role-based Authentication
- ✅ Responsive Bootstrap 5 Design
- ✅ Google Maps Integration
- ✅ Search and Filter Functionality
- ✅ CRUD Operations with Validation
- ✅ Database Relationships
- ✅ Middleware Protection

## 🐛 Troubleshooting

### If you get "Database not found" error:
1. Make sure MySQL is running in XAMPP
2. Create the database: `dti_ncmap_system`
3. Update `.env` with correct database credentials
4. Run: `php artisan config:clear && php artisan migrate:fresh --seed`

### If maps don't load:
1. Get a Google Maps API key from Google Cloud Console
2. Enable Maps JavaScript API and Places API
3. Add the key to your `.env` file
4. Clear config: `php artisan config:clear`

### If you get permission errors:
```bash
chmod -R 775 storage bootstrap/cache
```

## 📁 Project Structure

```
dti-ncmap-system/
├── app/
│   ├── Http/Controllers/          # All controllers implemented
│   ├── Http/Middleware/           # AdminMiddleware, GuestMiddleware
│   └── Models/                    # User, OfficeLocation, StaffInformation, Reminder
├── database/
│   ├── migrations/                # All database tables
│   └── seeders/                   # Sample data
├── resources/views/
│   ├── admin/                     # Admin dashboard and forms
│   ├── auth/                      # Login/Register forms
│   ├── layouts/                   # Base layout
│   └── map/                       # Public map views
└── routes/web.php                 # All routes configured
```

## 🎯 Next Steps

1. Fix the database configuration (most important)
2. Add Google Maps API key
3. Test all functionality
4. Customize styling if needed
5. Deploy to production server

The system is fully functional once the database configuration is corrected!
