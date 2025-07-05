# 🗺️ Google Maps Setup Guide for DTI-NCMAP System

## Current Issue
You're seeing: **"This page didn't load Google Maps correctly"**

**Cause:** Missing or invalid Google Maps API key

## 🚀 Quick Solutions

### Option 1: Use OpenStreetMap (Immediate Solution)
**No API key required - works right now!**

Visit: `http://localhost:8000/map/osm`

- ✅ Fully functional map
- ✅ All 3 DTI office locations  
- ✅ Interactive markers and popups
- ✅ Search and filtering
- ✅ Directions to Google Maps

### Option 2: Setup Google Maps API (Full Solution)

## 📋 Step-by-Step Google Maps Setup

### Step 1: Get Google Cloud Account
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Sign in with Google account
3. Create new project or select existing

### Step 2: Enable Required APIs
1. Go to **APIs & Services** → **Library**
2. Search and enable:
   - ✅ **Maps JavaScript API** (required)
   - ✅ **Places API** (optional, for search)

### Step 3: Create API Key
1. Go to **APIs & Services** → **Credentials**
2. Click **Create Credentials** → **API Key**
3. Copy the generated API key

### Step 4: Configure API Key Restrictions (Recommended)
1. Click on your API key to edit
2. **Application restrictions:**
   - Choose "HTTP referrers"
   - Add: `http://localhost:8000/*`
   - Add: `http://127.0.0.1:8000/*`
3. **API restrictions:**
   - Choose "Restrict key"
   - Select: Maps JavaScript API

### Step 5: Setup Billing (Required for Production)
1. Go to **Billing** in Google Cloud Console
2. Set up billing account
3. **Note:** Google provides $200 free credit monthly

### Step 6: Configure in Laravel
1. Open `dti-ncmap-system\.env`
2. Add this line:
   ```env
   GOOGLE_MAPS_API_KEY=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg
   ```
   *(Replace with your actual API key)*

3. Clear Laravel config:
   ```bash
   cd dti-ncmap-system
   php artisan config:clear
   ```

4. Test: `http://localhost:8000/map`

## 🔧 Troubleshooting

### Error: "RefererNotAllowedMapError"
**Solution:** Add your domain to API key restrictions:
- `http://localhost:8000/*`
- `http://127.0.0.1:8000/*`

### Error: "ApiNotActivatedMapError"  
**Solution:** Enable Maps JavaScript API in Google Cloud Console

### Error: "REQUEST_DENIED"
**Solution:** Check billing is enabled and API key is correct

### Error: Map shows but says "For development purposes only"
**Solution:** Enable billing in Google Cloud Console

## 💡 Testing Your Setup

### Test 1: Check API Key in System
```bash
php artisan app:check-data
```
Look for: `GOOGLE_MAPS_API_KEY: Set (length: XX)`

### Test 2: Visit Debug Page
`http://localhost:8000/map/debug`

### Test 3: Visit Main Map
`http://localhost:8000/map`
- Should redirect to OSM if API key missing
- Should show Google Maps if API key valid

## 🗺️ Available Map Options

| URL | Description | Requirements |
|-----|-------------|--------------|
| `/map` | Auto-detects API key, redirects to OSM if missing | None |
| `/map/osm` | OpenStreetMap version (always works) | None |
| `/map/debug` | Diagnostic page with data dump | None |

## 📊 Current System Status
- ✅ **Database:** 3 DTI offices with coordinates
- ✅ **Backend:** All controllers and routes working
- ✅ **Frontend:** Views and JavaScript ready  
- ❌ **Google Maps:** API key not configured
- ✅ **OpenStreetMap:** Working alternative available

## 💰 Cost Information

**Google Maps Pricing:**
- Free tier: $200 credit/month
- Maps JavaScript API: $7 per 1,000 loads
- For development/testing: Usually stays within free tier

**OpenStreetMap:**
- Completely free
- No API key required
- Fully functional for this project

## 🎯 Recommended Action

1. **For immediate testing:** Use OpenStreetMap version
   - Visit: `http://localhost:8000/map/osm`
   
2. **For production:** Setup Google Maps API key
   - Follow steps above
   - Test with: `http://localhost:8000/map`

The DTI-NCMAP system is fully functional with both options! 🎉
