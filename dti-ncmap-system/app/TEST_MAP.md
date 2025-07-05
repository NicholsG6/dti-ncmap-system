# 🗺️ DTI-NCMAP Map Testing Guide

## Current Status
- ✅ Database: Working (MySQL with sample data)
- ✅ Backend: 3 offices with coordinates
- ✅ Frontend: Views and JavaScript ready
- ❌ Maps: Not loading (missing API key)

## Quick Fix Options

### Option 1: Get Google Maps API Key (Recommended)
1. Visit: https://console.cloud.google.com/
2. Create project → Enable "Maps JavaScript API"
3. Create API Key
4. Add to `.env`: `GOOGLE_MAPS_API_KEY=your_key_here`
5. Run: `php artisan config:clear`

### Option 2: Test Debug Page
Visit: `http://localhost:8000/map/debug`
This shows all data without requiring API key.

### Option 3: Use Test API Key (Limited)
For testing only, add this to `.env`:
```
GOOGLE_MAPS_API_KEY=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg
```
⚠️ This is a demo key with limited usage!

## Current Data in System
```
DTI Cebu Provincial Office (DTI-CEBU-PROV)
  Location: 10.3157, 123.8854 (Cebu City)
  Staff: 2 members

DTI Bohol Provincial Office (DTI-BOHOL-PROV)  
  Location: 9.6474, 123.8621 (Tagbilaran)
  Staff: 2 members

DTI Negros Oriental Provincial Office (DTI-NEGOR-PROV)
  Location: 9.3073, 123.3035 (Dumaguete)
  Staff: 2 members
```

## Testing Steps
1. Fix API key issue
2. Visit: `http://localhost:8000/map`
3. Should see map centered on Cebu with 3 DTI office markers
4. Click markers for office details
5. Test search and filtering

## URLs to Test
- Main Map: `http://localhost:8000/map`
- Debug Page: `http://localhost:8000/map/debug`
- Staff Directory: `http://localhost:8000/map/staff`
- Admin Login: `http://localhost:8000/login`
  - Email: admin@dti-ncmap.com
  - Password: password

## Expected Map Behavior
- Loads centered on Cebu, Philippines
- Shows 3 blue DTI markers
- Clicking markers shows office info popups
- "Get Directions" button opens Google Maps
- Search box filters offices
- Office list on right side shows all locations
