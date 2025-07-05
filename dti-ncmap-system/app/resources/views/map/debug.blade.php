@extends('layouts.app')

@section('title', 'Map Debug - DTI NCMAP System')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-bug"></i>
                        Map Debug Information
                    </h5>
                </div>
                <div class="card-body">
                    <h6>Offices Data:</h6>
                    <pre>{{ json_encode($offices, JSON_PRETTY_PRINT) }}</pre>
                    
                    <h6>Provinces:</h6>
                    <pre>{{ json_encode($provinces, JSON_PRETTY_PRINT) }}</pre>
                    
                    <h6>Environment Variables:</h6>
                    <ul>
                        <li><strong>GOOGLE_MAPS_API_KEY:</strong> {{ env('GOOGLE_MAPS_API_KEY') ? 'Set (length: ' . strlen(env('GOOGLE_MAPS_API_KEY')) . ')' : 'Not Set' }}</li>
                        <li><strong>DB_CONNECTION:</strong> {{ env('DB_CONNECTION') }}</li>
                        <li><strong>DB_DATABASE:</strong> {{ env('DB_DATABASE') }}</li>
                    </ul>
                    
                    <h6>Test Simple Map:</h6>
                    <div id="simple-map" style="height: 400px; background-color: #f0f0f0; border: 2px solid #ccc; display: flex; align-items: center; justify-content: center;">
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Loading Map...</p>
                            <p class="small text-muted">If this doesn't change, there's a Google Maps API issue.</p>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('map.index') }}" class="btn btn-primary">Back to Full Map</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let map;
    let offices = @json($offices);
    
    console.log('Offices data:', offices);
    console.log('Number of offices:', offices.length);
    
    function initMap() {
        console.log('initMap function called');
        
        const mapElement = document.getElementById('simple-map');
        
        try {
            // Center on Cebu, Philippines (Region 7)
            const centerLatLng = { lat: 10.3157, lng: 123.8854 };
            
            map = new google.maps.Map(mapElement, {
                zoom: 10,
                center: centerLatLng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            
            console.log('Map created successfully');
            
            // Test adding a simple marker
            const testMarker = new google.maps.Marker({
                position: centerLatLng,
                map: map,
                title: 'Test Marker - Cebu City'
            });
            
            console.log('Test marker added');
            
            // Add markers for offices if they exist
            if (offices && offices.length > 0) {
                offices.forEach((office, index) => {
                    console.log(`Adding marker ${index + 1}:`, office.office_name);
                    
                    const marker = new google.maps.Marker({
                        position: { 
                            lat: parseFloat(office.latitude), 
                            lng: parseFloat(office.longitude) 
                        },
                        map: map,
                        title: office.office_name
                    });
                    
                    const infoWindow = new google.maps.InfoWindow({
                        content: `<div><h6>${office.office_name}</h6><p>${office.complete_address}</p></div>`
                    });
                    
                    marker.addListener('click', () => {
                        infoWindow.open(map, marker);
                    });
                });
                
                console.log(`Added ${offices.length} office markers`);
            } else {
                console.log('No offices data available');
            }
            
        } catch (error) {
            console.error('Error initializing map:', error);
            mapElement.innerHTML = `
                <div class="text-center text-danger">
                    <i class="bi bi-exclamation-triangle" style="font-size: 2rem;"></i>
                    <p class="mt-2"><strong>Map Error:</strong></p>
                    <p>${error.message}</p>
                </div>
            `;
        }
    }
    
    // Log when Google Maps API loads
    window.addEventListener('load', function() {
        console.log('Page loaded');
        if (typeof google !== 'undefined') {
            console.log('Google Maps API loaded successfully');
        } else {
            console.error('Google Maps API not loaded');
            document.getElementById('simple-map').innerHTML = `
                <div class="text-center text-danger">
                    <i class="bi bi-exclamation-triangle" style="font-size: 2rem;"></i>
                    <p class="mt-2"><strong>Google Maps API Not Loaded</strong></p>
                    <p>Check your API key configuration</p>
                </div>
            `;
        }
    });
</script>

<!-- Google Maps API with callback -->
<script async defer 
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY', 'YOUR_GOOGLE_MAPS_API_KEY_HERE') }}&callback=initMap&libraries=places">
</script>
@endpush
