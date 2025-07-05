@extends('layouts.app')

@section('title', 'DTI NCMAP - Interactive Map')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-geo-alt-fill"></i>
                        DTI Negosyo Centers Map - Region 7
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div id="map" class="map-container" style="height: 600px;"></div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
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
            
            <!-- Legend -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-info-circle"></i>
                        Map Legend
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-primary me-2">●</span>
                        <small>DTI Negosyo Center</small>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-people text-success me-2"></i>
                        <small>Has Staff Members</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-geo-alt text-danger me-2"></i>
                        <small>Click marker for details</small>
                    </div>
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
                            <div class="mb-3 p-3 border rounded office-item" data-office-id="{{ $office->id }}">
                                <h6 class="mb-1">{{ $office->office_name }}</h6>
                                <p class="mb-1 text-muted small">{{ $office->office_code }}</p>
                                <p class="mb-1 small">{{ $office->complete_address }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                    <i class="bi bi-people"></i> {{ $office->staffMembers ? $office->staffMembers->count() : 0 }} staff
                                    </small>
                                    <a href="{{ route('map.office.show', $office) }}" class="btn btn-sm btn-outline-primary">
                                        View Details
                                    </a>
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
</style>
@endpush

@push('scripts')
<script>
    let map;
    let markers = [];
    let offices = @json($offices);

    function initMap() {
        // Center on Cebu, Philippines (Region 7)
        const centerLatLng = { lat: 10.3157, lng: 123.8854 };
        
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: centerLatLng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        // Add markers for each office
        offices.forEach(office => {
            const marker = new google.maps.Marker({
                position: { lat: parseFloat(office.latitude), lng: parseFloat(office.longitude) },
                map: map,
                title: office.office_name,
                icon: {
                    url: 'data:image/svg+xml;base64,' + btoa(`
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                            <circle cx="16" cy="16" r="12" fill="#0d6efd" stroke="white" stroke-width="2"/>
                            <text x="16" y="20" text-anchor="middle" fill="white" font-size="12" font-weight="bold">DTI</text>
                        </svg>
                    `),
                    scaledSize: new google.maps.Size(32, 32)
                }
            });

            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div style="max-width: 300px;">
                        <h6>${office.office_name}</h6>
                        <p class="mb-1"><strong>Code:</strong> ${office.office_code}</p>
                        <p class="mb-1"><strong>Address:</strong> ${office.complete_address}</p>
                        ${office.contact_number ? `<p class="mb-1"><strong>Contact:</strong> ${office.contact_number}</p>` : ''}
                        ${office.office_head ? `<p class="mb-1"><strong>Office Head:</strong> ${office.office_head}</p>` : ''}
                        <p class="mb-1"><strong>Staff:</strong> ${office.staff_members ? office.staff_members.length : 0} members</p>
                        <div class="mt-2">
                            <a href="/map/office/${office.id}" class="btn btn-sm btn-primary">View Details</a>
                            <button class="btn btn-sm btn-outline-secondary" onclick="getDirections(${office.latitude}, ${office.longitude})">Get Directions</button>
                        </div>
                    </div>
                `
            });

            marker.addListener('click', () => {
                // Close all other info windows
                markers.forEach(m => {
                    if (m.infoWindow) {
                        m.infoWindow.close();
                    }
                });
                
                infoWindow.open(map, marker);
                
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

            markers.push({ marker, infoWindow, office });
        });

        // Fit map to show all markers
        if (markers.length > 0) {
            const bounds = new google.maps.LatLngBounds();
            markers.forEach(({ marker }) => {
                bounds.extend(marker.getPosition());
            });
            map.fitBounds(bounds);
        }
    }

    function getDirections(lat, lng) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const origin = `${position.coords.latitude},${position.coords.longitude}`;
                const destination = `${lat},${lng}`;
                const url = `https://www.google.com/maps/dir/${origin}/${destination}`;
                window.open(url, '_blank');
            }, () => {
                // If location access is denied, just open Google Maps with destination
                const url = `https://www.google.com/maps/search/${lat},${lng}`;
                window.open(url, '_blank');
            });
        } else {
            const url = `https://www.google.com/maps/search/${lat},${lng}`;
            window.open(url, '_blank');
        }
    }

    // Add click handlers for office list items
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.office-item').forEach(item => {
            item.addEventListener('click', function(e) {
                if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON') return;
                
                const officeId = this.getAttribute('data-office-id');
                const markerData = markers.find(m => m.office.id == officeId);
                
                if (markerData) {
                    map.setCenter(markerData.marker.getPosition());
                    map.setZoom(15);
                    
                    // Close all info windows
                    markers.forEach(m => {
                        if (m.infoWindow) {
                            m.infoWindow.close();
                        }
                    });
                    
                    // Open this marker's info window
                    markerData.infoWindow.open(map, markerData.marker);
                    
                    // Highlight this item
                    document.querySelectorAll('.office-item').forEach(item => {
                        item.classList.remove('selected');
                    });
                    this.classList.add('selected');
                }
            });
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
</script>

<!-- Google Maps API -->
<script async defer 
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY', 'YOUR_GOOGLE_MAPS_API_KEY_HERE') }}&callback=initMap&libraries=places">
</script>
@endpush
