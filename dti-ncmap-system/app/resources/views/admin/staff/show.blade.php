@extends('layouts.app')

@section('title', $staff->first_name . ' ' . $staff->last_name . ' - DTI NCMAP System')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-person"></i>
        {{ $staff->first_name }} {{ $staff->middle_name }} {{ $staff->last_name }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.staff.edit', $staff) }}" class="btn btn-sm btn-primary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('admin.staff.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Personal Information -->
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Personal Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="text-center mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 80px; height: 80px; font-size: 2rem;">
                                {{ strtoupper(substr($staff->first_name, 0, 1) . substr($staff->last_name, 0, 1)) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label text-muted">First Name</label>
                                    <div class="fw-bold">{{ $staff->first_name }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Middle Name</label>
                                    <div>{{ $staff->middle_name ?: '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Last Name</label>
                                    <div class="fw-bold">{{ $staff->last_name }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Gender</label>
                                    <div>{{ $staff->gender ?: '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Date Created</label>
                                    <div>{{ $staff->date_created ? \Carbon\Carbon::parse($staff->date_created)->format('M d, Y') : '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professional Information -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Professional Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Position</label>
                            <div class="fw-bold">{{ $staff->position }}</div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">Type Code</label>
                            <div>
                                <span class="badge bg-{{ $staff->type_code === 'A' ? 'primary' : ($staff->type_code === 'B' ? 'info' : 'success') }} fs-6">
                                    Type {{ $staff->type_code }}
                                </span>
                            </div>
                        </div>
                        
                        @if($staff->type_advanced)
                        <div class="mb-3">
                            <label class="form-label text-muted">Type Advanced</label>
                            <div>{{ $staff->type_advanced }}</div>
                        </div>
                        @endif
                        
                        @if($staff->contact_person)
                        <div class="mb-3">
                            <label class="form-label text-muted">Contact Person</label>
                            <div>{{ $staff->contact_person }}</div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="col-md-6">
                        @if($staff->officeLocation)
                        <div class="mb-3">
                            <label class="form-label text-muted">Office Assignment</label>
                            <div>
                                <strong>{{ $staff->officeLocation->office_name }}</strong><br>
                                <small class="text-muted">{{ $staff->officeLocation->complete_address }}</small><br>
                                <a href="{{ route('admin.offices.show', $staff->officeLocation) }}" class="btn btn-sm btn-outline-primary mt-1">
                                    <i class="bi bi-building"></i> View Office
                                </a>
                            </div>
                        </div>
                        @endif
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">Status</label>
                            <div>
                                @if($staff->is_active)
                                    <span class="badge bg-success fs-6">Active</span>
                                @else
                                    <span class="badge bg-secondary fs-6">Inactive</span>
                                @endif
                            </div>
                        </div>
                        
                        @if($staff->service_area)
                        <div class="mb-3">
                            <label class="form-label text-muted">Service Area</label>
                            <div class="p-2 bg-light rounded">{{ $staff->service_area }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Location Information -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Location Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Region</label>
                            <div>{{ $staff->region ?: '-' }}</div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">Province</label>
                            <div>{{ $staff->province }}</div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">Municipality/City</label>
                            <div>{{ $staff->municipality }}</div>
                        </div>
                        
                        @if($staff->district)
                        <div class="mb-3">
                            <label class="form-label text-muted">District</label>
                            <div>{{ $staff->district }}</div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="col-md-6">
                        @if($staff->complete_address)
                        <div class="mb-3">
                            <label class="form-label text-muted">Complete Address</label>
                            <div class="p-2 bg-light rounded">{{ $staff->complete_address }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Contact Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @if($staff->cellphone_number)
                        <div class="mb-3">
                            <label class="form-label text-muted">Cellphone Number</label>
                            <div>
                                <i class="bi bi-phone"></i>
                                <a href="tel:{{ $staff->cellphone_number }}">{{ $staff->cellphone_number }}</a>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if($staff->email_address)
                        <div class="mb-3">
                            <label class="form-label text-muted">Email Address</label>
                            <div>
                                <i class="bi bi-envelope"></i>
                                <a href="mailto:{{ $staff->email_address }}">{{ $staff->email_address }}</a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($staff->remarks)
        <!-- Additional Information -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Additional Information</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-muted">Remarks</label>
                    <div class="p-3 bg-light rounded">{{ $staff->remarks }}</div>
                </div>
            </div>
        </div>
        @endif
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
                <a href="{{ route('admin.staff.edit', $staff) }}" class="btn btn-primary w-100 mb-2">
                    <i class="bi bi-pencil"></i> Edit Staff
                </a>
                
                @if($staff->cellphone_number)
                <a href="tel:{{ $staff->cellphone_number }}" class="btn btn-success w-100 mb-2">
                    <i class="bi bi-phone"></i> Call {{ $staff->cellphone_number }}
                </a>
                @endif
                
                @if($staff->email_address)
                <a href="mailto:{{ $staff->email_address }}" class="btn btn-info w-100 mb-2">
                    <i class="bi bi-envelope"></i> Send Email
                </a>
                @endif
                
                @if($staff->officeLocation)
                <a href="{{ route('admin.offices.show', $staff->officeLocation) }}" class="btn btn-outline-primary w-100 mb-2">
                    <i class="bi bi-building"></i> View Office
                </a>
                @endif
                
                <button type="button" class="btn btn-danger w-100" onclick="confirmDelete()">
                    <i class="bi bi-trash"></i> Delete Staff
                </button>
            </div>
        </div>
        
        <!-- Staff Info -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="bi bi-info-circle"></i> Staff Info
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <label class="form-label text-muted">Created</label>
                    <div>{{ $staff->created_at->format('M d, Y \a\t g:i A') }}</div>
                </div>
                
                <div class="mb-2">
                    <label class="form-label text-muted">Last Updated</label>
                    <div>{{ $staff->updated_at->format('M d, Y \a\t g:i A') }}</div>
                </div>
                
                @if($staff->creator)
                <div class="mb-2">
                    <label class="form-label text-muted">Created By</label>
                    <div>{{ $staff->creator->name }}</div>
                </div>
                @endif
                
                @if($staff->created_by)
                <div class="mb-2">
                    <label class="form-label text-muted">Created By ID</label>
                    <div>{{ $staff->created_by }}</div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Type Information -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="bi bi-tags"></i> Type Information
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <span class="badge bg-{{ $staff->type_code === 'A' ? 'primary' : ($staff->type_code === 'B' ? 'info' : 'success') }} fs-5">
                        Type {{ $staff->type_code }}
                    </span>
                </div>
                
                <div class="small">
                    @if($staff->type_code === 'A')
                        <strong>Administrative Staff</strong><br>
                        Handles administrative and management tasks.
                    @elseif($staff->type_code === 'B')
                        <strong>Field Operations</strong><br>
                        Responsible for field operations and outreach.
                    @elseif($staff->type_code === 'C')
                        <strong>Support Staff</strong><br>
                        Provides support services and assistance.
                    @endif
                </div>
                
                @if($staff->type_advanced)
                <hr>
                <div>
                    <strong>Advanced Type:</strong><br>
                    <span class="text-muted">{{ $staff->type_advanced }}</span>
                </div>
                @endif
            </div>
        </div>

        @if($staff->officeLocation)
        <!-- Office Location Details -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-building"></i> Office Location
                </h6>
            </div>
            <div class="card-body">
                <h6>{{ $staff->officeLocation->office_name }}</h6>
                <p class="text-muted mb-2">{{ $staff->officeLocation->complete_address }}</p>
                
                @if($staff->officeLocation->contact_number)
                <div class="mb-2">
                    <i class="bi bi-phone"></i> {{ $staff->officeLocation->contact_number }}
                </div>
                @endif
                
                @if($staff->officeLocation->email_address)
                <div class="mb-2">
                    <i class="bi bi-envelope"></i> {{ $staff->officeLocation->email_address }}
                </div>
                @endif
                
                <a href="{{ route('admin.offices.show', $staff->officeLocation) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-eye"></i> View Details
                </a>
            </div>
        </div>
        @endif
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
                <p>Are you sure you want to delete <strong>{{ $staff->first_name }} {{ $staff->last_name }}</strong>?</p>
                <p class="text-muted">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('admin.staff.destroy', $staff) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Staff</button>
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
</script>
@endpush
