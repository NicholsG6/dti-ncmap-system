@extends('layouts.app')

@section('title', $office->office_name . ' - DTI NCMAP System')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-building"></i>
        {{ $office->office_name }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.offices.edit', $office) }}" class="btn btn-sm btn-primary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('admin.offices.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Office Details -->
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Office Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Office Name</label>
                            <div class="fw-bold">{{ $office->office_name }}</div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">Office Code</label>
                            <div>
                                <span class="badge bg-primary">{{ $office->office_code }}</span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">Region</label>
                            <div>{{ $office->region }}</div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">Province</label>
                            <div>{{ $office->province }}</div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">Municipality</label>
                            <div>{{ $office->municipality }}</div>
                        </div>
                        
                        @if($office->district)
                        <div class="mb-3">
                            <label class="form-label text-muted">District</label>
                            <div>{{ $office->district }}</div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Complete Address</label>
                            <div>{{ $office->complete_address }}</div>
                        </div>
                        
                        @if($office->contact_number)
                        <div class="mb-3">
                            <label class="form-label text-muted">Contact Number</label>
                            <div>
                                <i class="bi bi-telephone"></i>
                                {{ $office->contact_number }}
                            </div>
                        </div>
                        @endif
                        
                        @if($office->email_address)
                        <div class="mb-3">
                            <label class="form-label text-muted">Email Address</label>
                            <div>
                                <i class="bi bi-envelope"></i>
                                <a href="mailto:{{ $office->email_address }}">{{ $office->email_address }}</a>
                            </div>
                        </div>
                        @endif
                        
                        @if($office->office_head)
                        <div class="mb-3">
                            <label class="form-label text-muted">Office Head</label>
                            <div>
                                <i class="bi bi-person-badge"></i>
                                {{ $office->office_head }}
                            </div>
                        </div>
                        @endif
                        
                        @if($office->service_hours)
                        <div class="mb-3">
                            <label class="form-label text-muted">Service Hours</label>
                            <div>
                                <i class="bi bi-clock"></i>
                                {{ $office->service_hours }}
                            </div>
                        </div>
                        @endif
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">Location Coordinates</label>
                            <div>
                                <i class="bi bi-geo-alt"></i>
                                {{ $office->latitude }}, {{ $office->longitude }}
                                <a href="https://www.google.com/maps/search/{{ $office->latitude }},{{ $office->longitude }}" 
                                   target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                    <i class="bi bi-geo-alt"></i> View on Map
                                </a>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">Status</label>
                            <div>
                                @if($office->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($office->office_description)
                <div class="mt-4">
                    <label class="form-label text-muted">Description</label>
                    <div class="p-3 bg-light rounded">{{ $office->office_description }}</div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Office Map -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-map"></i>
                    Office Location Map
                </h6>
            </div>
            <div class="card-body p-0">
                <div id="office-map" style="height: 400px; background-color: #f0f0f0;">
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div class="text-center">
                            <i class="bi bi-map" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="mt-2 text-muted">Map will load here</p>
                            <small class="text-muted">{{ $office->latitude }}, {{ $office->longitude }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="bi bi-lightning"></i> Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.offices.edit', $office) }}" class="btn btn-primary w-100 mb-2">
                    <i class="bi bi-pencil"></i> Edit Office
                </a>
                
                <a href="{{ route('map.office.show', $office) }}" class="btn btn-info w-100 mb-2" target="_blank">
                    <i class="bi bi-map"></i> View on Public Map
                </a>
                
                @if($office->staffMembers->count() > 0)
                <a href="{{ route('admin.staff.index', ['location_id' => $office->id]) }}" class="btn btn-outline-primary w-100 mb-2">
                    <i class="bi bi-people"></i> View Staff ({{ $office->staffMembers->count() }})
                </a>
                @endif
                
                <button type="button" class="btn btn-danger w-100" onclick="confirmDelete()">
                    <i class="bi bi-trash"></i> Delete Office
                </button>
            </div>
        </div>
        
        <!-- Staff Members -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-people"></i>
                    Staff Members ({{ $office->staffMembers->count() }})
                </h6>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @if($office->staffMembers->count() > 0)
                    @foreach($office->staffMembers as $staff)
                        <div class="mb-3 p-2 border rounded">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $staff->full_name }}</h6>
                                    <p class="mb-1 text-muted">{{ $staff->position }}</p>
                                    @if($staff->cellphone_number)
                                        <small class="text-muted">
                                            <i class="bi bi-telephone"></i> {{ $staff->cellphone_number }}
                                        </small>
                                    @endif
                                </div>
                                <span class="badge bg-{{ $staff->type_code === 'A' ? 'primary' : ($staff->type_code === 'B' ? 'info' : 'success') }}">
                                    Type {{ $staff->type_code }}
                                </span>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('admin.staff.show', $staff) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-people" style="font-size: 2rem;"></i>
                        <p class="mt-2">No staff assigned</p>
                        <a href="{{ route('admin.staff.create') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus"></i> Add Staff
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Office Info -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="bi bi-info-circle"></i> Office Info
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <label class="form-label text-muted">Created</label>
                    <div>{{ $office->created_at->format('M d, Y \a\t g:i A') }}</div>
                </div>
                
                <div class="mb-2">
                    <label class="form-label text-muted">Last Updated</label>
                    <div>{{ $office->updated_at->format('M d, Y \a\t g:i A') }}</div>
                </div>
                
                @if($office->creator)
                <div class="mb-2">
                    <label class="form-label text-muted">Created By</label>
                    <div>{{ $office->creator->name }}</div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Statistics -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="bi bi-bar-chart"></i> Statistics
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <h4 class="text-primary mb-0">{{ $office->staffMembers->count() }}</h4>
                        <small class="text-muted">Total Staff</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-success mb-0">{{ $office->staffMembers->where('type_code', 'A')->count() }}</h4>
                        <small class="text-muted">Type A</small>
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

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $office->office_name }}</strong>?</p>
                @if($office->staffMembers->count() > 0)
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Warning:</strong> This office has {{ $office->staffMembers->count() }} staff member(s). 
                        Consider reassigning them before deletion.
                    </div>
                @endif
                <p class="text-muted">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('admin.offices.destroy', $office) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Office</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete() {
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
    
    // Initialize map if Google Maps is available
    if (typeof google !== 'undefined') {
        function initMap() {
            const officeLocation = { lat: {{ $office->latitude }}, lng: {{ $office->longitude }} };
            
            const map = new google.maps.Map(document.getElementById('office-map'), {
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
                    <div>
                        <h6>{{ $office->office_name }}</h6>
                        <p>{{ $office->complete_address }}</p>
                    </div>
                `
            });

            marker.addListener('click', () => {
                infoWindow.open(map, marker);
            });
        }
        
        // Load map when page is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initMap);
        } else {
            initMap();
        }
    }
</script>

<!-- Google Maps API (if key is available) -->
@if(env('GOOGLE_MAPS_API_KEY') && env('GOOGLE_MAPS_API_KEY') !== 'YOUR_GOOGLE_MAPS_API_KEY_HERE')
<script async defer 
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
</script>
@endif
@endpush
