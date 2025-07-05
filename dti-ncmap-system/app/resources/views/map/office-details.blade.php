@extends('layouts.app')

@section('title', $office->office_name . ' - DTI NCMAP System')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Office Information -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-building"></i>
                        {{ $office->office_name }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="bi bi-info-circle"></i> Office Information</h6>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td><strong>Office Code:</strong></td>
                                        <td>{{ $office->office_code }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Region:</strong></td>
                                        <td>{{ $office->region }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Province:</strong></td>
                                        <td>{{ $office->province }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Municipality:</strong></td>
                                        <td>{{ $office->municipality }}</td>
                                    </tr>
                                    @if($office->district)
                                        <tr>
                                            <td><strong>District:</strong></td>
                                            <td>{{ $office->district }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="bi bi-geo-alt"></i> Location & Contact</h6>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td><strong>Address:</strong></td>
                                        <td>{{ $office->complete_address }}</td>
                                    </tr>
                                    @if($office->contact_number)
                                        <tr>
                                            <td><strong>Contact:</strong></td>
                                            <td>{{ $office->contact_number }}</td>
                                        </tr>
                                    @endif
                                    @if($office->email_address)
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>
                                                <a href="mailto:{{ $office->email_address }}">
                                                    {{ $office->email_address }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                    @if($office->service_hours)
                                        <tr>
                                            <td><strong>Service Hours:</strong></td>
                                            <td>{{ $office->service_hours }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if($office->office_description)
                        <div class="mt-4">
                            <h6><i class="bi bi-card-text"></i> Description</h6>
                            <p class="text-muted">{{ $office->office_description }}</p>
                        </div>
                    @endif

                    @if($office->office_head)
                        <div class="mt-4">
                            <h6><i class="bi bi-person-badge"></i> Office Head</h6>
                            <p class="text-muted">{{ $office->office_head }}</p>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-4 d-flex gap-2">
                        <button class="btn btn-primary" onclick="getDirections({{ $office->latitude }}, {{ $office->longitude }})">
                            <i class="bi bi-geo-alt"></i> Get Directions
                        </button>
                        <a href="{{ route('map.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-map"></i> Back to Map
                        </a>
                        <a href="{{ route('map.staff.directory', ['location_id' => $office->id]) }}" class="btn btn-outline-info">
                            <i class="bi bi-people"></i> View Staff ({{ $office->staffMembers->count() }})
                        </a>
                    </div>
                </div>
            </div>

            <!-- Office Map -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-map"></i>
                        Office Location
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div id="office-map" style="height: 400px;"></div>
                </div>
                
            </div>
        </div>

        <!-- Staff Members -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-people"></i>
                        Staff Members ({{ $office->staffMembers->count() }})
                    </h6>
                </div>
                <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                    @if($office->staffMembers->count() > 0)
                        @foreach($office->staffMembers as $staff)
                            <div class="mb-3 p-3 border rounded">
                                <h6 class="mb-1">{{ $staff->full_name }}</h6>
                                <p class="mb-1 text-muted">{{ $staff->position }}</p>
                                
                                @if($staff->cellphone_number)
                                    <p class="mb-1 small">
                                        <i class="bi bi-telephone"></i> {{ $staff->cellphone_number }}
                                    </p>
                                @endif
                                
                                @if($staff->email_address)
                                    <p class="mb-1 small">
                                        <i class="bi bi-envelope"></i> 
                                        <a href="mailto:{{ $staff->email_address }}">{{ $staff->email_address }}</a>
                                    </p>
                                @endif
                                
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <small class="text-muted">Type {{ $staff->type_code }}</small>
                                    @if($staff->service_area)
                                        <small class="text-muted">{{ $staff->service_area }}</small>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-people" style="font-size: 2rem;"></i>
                            <p class="mt-2">No staff members assigned</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-bar-chart"></i>
                        Quick Stats
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="border-end">
                                <h4 class="text-primary mb-0">{{ $office->staffMembers->count() }}</h4>
                                <small class="text-muted">Staff</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border-end">
                                <h4 class="text-success mb-0">{{ $office->staffMembers->where('type_code', 'A')->count() }}</h4>
                                <small class="text-muted">Type A</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <h4 class="text-info mb-0">{{ $office->staffMembers->where('type_code', 'B')->count() }}</h4>
                            <small class="text-muted">Type B</small>
                        </div>
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
    
    function initMap() {
        const officeLocation = { lat: {{ $office->latitude }}, lng: {{ $office->longitude }} };
        
        map = new google.maps.Map(document.getElementById('office-map'), {
            zoom: 15,
            center: officeLocation,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        const marker = new google.maps.Marker({
            position: officeLocation,
            map: map,
            title: '{{ $office->office_name }}',
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
                <div style="max-width: 250px;">
                    <h6>{{ $office->office_name }}</h6>
                    <p class="mb-1"><strong>Code:</strong> {{ $office->office_code }}</p>
                    <p class="mb-1">{{ $office->complete_address }}</p>
                    @if($office->contact_number)
                        <p class="mb-1"><strong>Contact:</strong> {{ $office->contact_number }}</p>
                    @endif
                </div>
            `
        });

        marker.addListener('click', () => {
            infoWindow.open(map, marker);
        });
        
        // Open info window by default
        infoWindow.open(map, marker);
    }
    
    function getDirections(lat, lng) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const origin = `${position.coords.latitude},${position.coords.longitude}`;
                const destination = `${lat},${lng}`;
                const url = `https://www.google.com/maps/dir/${origin}/${destination}`;
                window.open(url, '_blank');
            }, () => {
                const url = `https://www.google.com/maps/search/${lat},${lng}`;
                window.open(url, '_blank');
            });
        } else {
            const url = `https://www.google.com/maps/search/${lat},${lng}`;
            window.open(url, '_blank');
        }
    }
</script>

@endpush
