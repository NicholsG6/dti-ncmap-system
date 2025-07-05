@extends('layouts.app')

@section('title', 'DTI NCMAP - Interactive Map (OpenStreetMap)')

@section('content')
<div class="container-fluid py-4">
    <!-- API Key Status Alert -->
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle"></i>
        <strong>Demo Mode:</strong> Using OpenStreetMap because Google Maps API key is not configured.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-geo-alt-fill"></i>
                        DTI Negosyo Centers Map - Region 7 (Demo)
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div id="osm-map" style="height: 600px; background-color: #f0f0f0; border: 1px solid #ddd;">
                        <div class="d-flex align-items-center justify-content-center h-100">
                            <div class="text-center">
                                <div class="spinner-border text-primary mb-3" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <h5>Loading Interactive Map...</h5>
                                <p class="text-muted">Displaying {{ $offices->count() }} DTI offices</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Google Maps Setup Instructions -->
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-info-circle"></i>
                        Setup Google Maps
                    </h6>
                </div>
                <div class="card-body">
                    <p class="small">To enable full Google Maps functionality:</p>
                    <ol class="small">
                        <li>Get API key from <a href="https://console.cloud.google.com/" target="_blank">Google Cloud Console</a></li>
                        <li>Enable "Maps JavaScript API"</li>
                        <li>Add to .env: <code>GOOGLE_MAPS_API_KEY=your_key</code></li>
                        <li>Run: <code>php artisan config:clear</code></li>
                    </ol>
                    <a href="{{ route('map.debug') }}" class="btn btn-info btn-sm">
                        <i class="bi bi-bug"></i> Debug Page
                    </a>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-search"></i>
                        Search & Filter
                    </h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('map.index') }}" id="filterForm">
                        <div class="mb-3">
                            <label for="search" class="form-label">Search Offices</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Office name, code, address...">
                        </div>
                        
                        <div class="mb-3">
                            <label for="province" class="form-label">Province</label>
                            <select class="form-select" id="province" name="province">
                                <option value="">All Provinces</option>
                                @foreach($provinces as $prov)
                                    <option value="{{ $prov }}" {{ request('province') === $prov ? 'selected' : '' }}>
                                        {{ $prov }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Search
                            </button>
                            <a href="{{ route('map.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Office List -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-list-ul"></i>
                        Office Locations ({{ $offices->count() }})
                    </h6>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @if($offices->count() > 0)
                        @foreach($offices as $office)
                            <div class="mb-3 p-3 border rounded office-item" data-office-id="{{ $office->id }}" 
                                 data-lat="{{ $office->latitude }}" data-lng="{{ $office->longitude }}">
                                <h6 class="mb-1">{{ $office->office_name }}</h6>
                                <p class="mb-1 text-muted small">{{ $office->office_code }}</p>
                                <p class="mb-1 small">{{ $office->complete_address }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-people"></i> {{ $office->staffMembers ? $office->staffMembers->count() : 0 }} staff
                                    </small>
                                    <div class="btn-group">
                                        <a href="{{ route('map.office.show', $office) }}" class="btn btn-sm btn-outline-primary">
                                            View Details
                                        </a>
                                        <button class="btn btn-sm btn-outline-success" onclick="openGoogleMaps({{ $office->latitude }}, {{ $office->longitude }})">
                                            <i class="bi bi-geo-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-search" style="font-size: 2rem;"></i>
                            <p class="mt-2">No offices found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .office-item {
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .office-item:hover {
        background-color: #f8f9fa;
    }
    .office-item.selected {
        background-color: #e3f2fd;
        border-color: #2196f3;
    }
    .leaflet-popup-content {
        font-family: inherit;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map;
    let markers = [];
    let offices = @json($offices);
    
    // Initialize OpenStreetMap
    function initOSMMap() {
        // Center on Cebu, Philippines (Region 7)
        const centerLatLng = [10.3157, 123.8854];
        
        map = L.map('osm-map').setView(centerLatLng, 10);
        
        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Add markers for each office
        offices.forEach((office, index) => {
            const marker = L.marker([office.latitude, office.longitude])
                .addTo(map)
                .bindPopup(`
                    <div style="min-width: 200px;">
                        <h6>${office.office_name}</h6>
                        <p class="mb-1"><strong>Code:</strong> ${office.office_code}</p>
                        <p class="mb-1">${office.complete_address}</p>
                        ${office.contact_number ? `<p class="mb-1"><strong>Contact:</strong> ${office.contact_number}</p>` : ''}
                        ${office.office_head ? `<p class="mb-1"><strong>Head:</strong> ${office.office_head}</p>` : ''}
                        <p class="mb-1"><strong>Staff:</strong> ${office.staff_members ? office.staff_members.length : 0} members</p>
                        <div class="mt-2">
                            <a href="/map/office/${office.id}" class="btn btn-sm btn-primary">View Details</a>
                            <button class="btn btn-sm btn-outline-secondary" onclick="openGoogleMaps(${office.latitude}, ${office.longitude})">Directions</button>
                        </div>
                    </div>
                `);
            
            marker.on('click', function() {
                // Highlight corresponding office in the list
                document.querySelectorAll('.office-item').forEach(item => {
                    item.classList.remove('selected');
                });
                const officeItem = document.querySelector(`[data-office-id="${office.id}"]`);
                if (officeItem) {
                    officeItem.classList.add('selected');
                    officeItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
            
            markers.push({ marker, office });
        });
        
        // Fit map to show all markers
        if (markers.length > 0) {
            const group = new L.featureGroup(markers.map(m => m.marker));
            map.fitBounds(group.getBounds().pad(0.1));
        }
        
        console.log(`Loaded ${offices.length} DTI office locations on OpenStreetMap`);
    }
    
    function openGoogleMaps(lat, lng) {
        const url = `https://www.google.com/maps/search/${lat},${lng}`;
        window.open(url, '_blank');
    }
    
    // Add click handlers for office list items
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map
        initOSMMap();
        
        // Office item click handlers
        document.querySelectorAll('.office-item').forEach(item => {
            item.addEventListener('click', function(e) {
                if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON') return;
                
                const lat = parseFloat(this.getAttribute('data-lat'));
                const lng = parseFloat(this.getAttribute('data-lng'));
                const officeId = this.getAttribute('data-office-id');
                
                // Center map on selected office
                map.setView([lat, lng], 15);
                
                // Find and open the marker popup
                const markerData = markers.find(m => m.office.id == officeId);
                if (markerData) {
                    markerData.marker.openPopup();
                }
                
                // Highlight this item
                document.querySelectorAll('.office-item').forEach(item => {
                    item.classList.remove('selected');
                });
                this.classList.add('selected');
            });
        });
        
        // Auto-submit form on input change
        document.getElementById('search').addEventListener('input', function() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 500);
        });

        document.getElementById('province').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });
</script>
@endpush
