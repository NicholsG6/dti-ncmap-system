@extends('layouts.app')

@section('title', 'Staff Directory - DTI NCMAP System')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-people-fill"></i>
                        DTI Staff Directory - Region 7
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('map.staff.directory') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="search" class="form-label">Search Staff</label>
                                <input type="text" class="form-control" id="search" name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Name, position, email...">
                            </div>
                            
                            <div class="col-md-3">
                                <label for="location_id" class="form-label">Office Location</label>
                                <select class="form-select" id="location_id" name="location_id">
                                    <option value="">All Offices</option>
                                    @foreach($offices as $office)
                                        <option value="{{ $office->id }}" {{ request('location_id') == $office->id ? 'selected' : '' }}>
                                            {{ $office->office_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-3">
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
                            
                            <div class="col-md-2 d-flex align-items-end">
                                <div class="btn-group w-100">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search"></i> Search
                                    </button>
                                    <a href="{{ route('map.staff.directory') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Results Count -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">
                            <i class="bi bi-person-badge"></i>
                            Found {{ $staff->total() }} staff members
                        </h6>
                        <div class="d-flex gap-2">
                            <a href="{{ route('map.index') }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-map"></i> View Map
                            </a>
                        </div>
                    </div>

                    <!-- Staff Cards Grid -->
                    <div class="row">
                        @forelse($staff as $member)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card staff-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="card-title mb-0">{{ $member->full_name }}</h6>
                                            <span class="badge bg-{{ $member->type_code === 'A' ? 'primary' : ($member->type_code === 'B' ? 'info' : 'success') }}">
                                                Type {{ $member->type_code }}
                                            </span>
                                        </div>
                                        
                                        <p class="text-muted mb-2">
                                            <i class="bi bi-briefcase"></i>
                                            {{ $member->position }}
                                        </p>
                                        
                                        @if($member->officeLocation)
                                            <p class="text-muted mb-2">
                                                <i class="bi bi-building"></i>
                                                {{ $member->officeLocation->office_name }}
                                            </p>
                                        @endif
                                        
                                        <p class="text-muted mb-2">
                                            <i class="bi bi-geo-alt"></i>
                                            {{ $member->municipality }}, {{ $member->province }}
                                        </p>
                                        
                                        @if($member->cellphone_number)
                                            <p class="text-muted mb-2">
                                                <i class="bi bi-telephone"></i>
                                                {{ $member->cellphone_number }}
                                            </p>
                                        @endif
                                        
                                        @if($member->email_address)
                                            <p class="text-muted mb-2">
                                                <i class="bi bi-envelope"></i>
                                                <a href="mailto:{{ $member->email_address }}" class="text-decoration-none">
                                                    {{ $member->email_address }}
                                                </a>
                                            </p>
                                        @endif
                                        
                                        @if($member->service_area)
                                            <p class="text-muted mb-2">
                                                <i class="bi bi-map"></i>
                                                <strong>Service Area:</strong> {{ $member->service_area }}
                                            </p>
                                        @endif
                                        
                                        @if($member->contact_person)
                                            <p class="text-muted mb-2">
                                                <i class="bi bi-person-check"></i>
                                                <strong>Contact Person:</strong> {{ $member->contact_person }}
                                            </p>
                                        @endif
                                        
                                        <div class="mt-3">
                                            <small class="text-muted">
                                                <i class="bi bi-calendar"></i>
                                                Added: {{ $member->date_created->format('M d, Y') }}
                                            </small>
                                        </div>
                                        
                                        @if($member->officeLocation)
                                            <div class="mt-2">
                                                <a href="{{ route('map.office.show', $member->officeLocation) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-building"></i> View Office
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="bi bi-people" style="font-size: 3rem; color: #ccc;"></i>
                                    <h5 class="mt-3 text-muted">No staff members found</h5>
                                    <p class="text-muted">Try adjusting your search criteria or browse all staff.</p>
                                    <a href="{{ route('map.staff.directory') }}" class="btn btn-primary">
                                        <i class="bi bi-arrow-clockwise"></i> Show All Staff
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($staff->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $staff->appends(request()->query())->links() }}
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
    .staff-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .staff-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
    
    .staff-card .card-title {
        color: #0d6efd;
        font-weight: 600;
    }
    
    .staff-card .text-muted {
        font-size: 0.9rem;
    }
    
    .staff-card .text-muted i {
        width: 16px;
        margin-right: 8px;
    }
    
    .badge {
        font-size: 0.75rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-submit form on input change
    document.getElementById('search').addEventListener('input', function() {
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(() => {
            this.form.submit();
        }, 500);
    });
    
    document.getElementById('location_id').addEventListener('change', function() {
        this.form.submit();
    });
    
    document.getElementById('province').addEventListener('change', function() {
        this.form.submit();
    });
</script>
@endpush
