@extends('layouts.app')

@section('title', 'Edit ' . $office->office_name . ' - DTI NCMAP System')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-pencil-square"></i>
        Edit Office Location
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.offices.show', $office) }}" class="btn btn-sm btn-outline-info">
                <i class="bi bi-eye"></i> View
            </a>
            <a href="{{ route('admin.offices.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Update Office Details</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.offices.update', $office) }}">
                    @csrf
                    @method('PUT')
                    
                    <!-- Office Name and Code -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="office_name" class="form-label">Office Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('office_name') is-invalid @enderror" 
                                       id="office_name" name="office_name" value="{{ old('office_name', $office->office_name) }}" required>
                                @error('office_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="office_code" class="form-label">Office Code</label>
                                <input type="text" class="form-control @error('office_code') is-invalid @enderror" 
                                       id="office_code" name="office_code" value="{{ old('office_code', $office->office_code) }}">
                                @error('office_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Complete Address -->
                    <div class="mb-3">
                        <label for="complete_address" class="form-label">Complete Address <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('complete_address') is-invalid @enderror" 
                                  id="complete_address" name="complete_address" rows="2" required>{{ old('complete_address', $office->complete_address) }}</textarea>
                        @error('complete_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Location Details -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="region" class="form-label">Region</label>
                                <input type="text" class="form-control @error('region') is-invalid @enderror" 
                                       id="region" name="region" value="{{ old('region', $office->region) }}">
                                @error('region')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="province" class="form-label">Province <span class="text-danger">*</span></label>
                                <select class="form-select @error('province') is-invalid @enderror" 
                                        id="province" name="province" required>
                                    <option value="">Select Province</option>
                                    <option value="Cebu" {{ old('province', $office->province) === 'Cebu' ? 'selected' : '' }}>Cebu</option>
                                    <option value="Bohol" {{ old('province', $office->province) === 'Bohol' ? 'selected' : '' }}>Bohol</option>
                                    <option value="Negros Oriental" {{ old('province', $office->province) === 'Negros Oriental' ? 'selected' : '' }}>Negros Oriental</option>
                                    <option value="Siquijor" {{ old('province', $office->province) === 'Siquijor' ? 'selected' : '' }}>Siquijor</option>
                                </select>
                                @error('province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="municipality" class="form-label">Municipality/City <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('municipality') is-invalid @enderror" 
                                       id="municipality" name="municipality" value="{{ old('municipality', $office->municipality) }}" required>
                                @error('municipality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="district" class="form-label">District</label>
                                <input type="text" class="form-control @error('district') is-invalid @enderror" 
                                       id="district" name="district" value="{{ old('district', $office->district) }}">
                                @error('district')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Coordinates -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="latitude" class="form-label">Latitude <span class="text-danger">*</span></label>
                                <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror" 
                                       id="latitude" name="latitude" value="{{ old('latitude', $office->latitude) }}" required>
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="longitude" class="form-label">Longitude <span class="text-danger">*</span></label>
                                <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror" 
                                       id="longitude" name="longitude" value="{{ old('longitude', $office->longitude) }}" required>
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contact_number" class="form-label">Contact Number</label>
                                <input type="text" class="form-control @error('contact_number') is-invalid @enderror" 
                                       id="contact_number" name="contact_number" value="{{ old('contact_number', $office->contact_number) }}">
                                @error('contact_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email_address" class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email_address') is-invalid @enderror" 
                                       id="email_address" name="email_address" value="{{ old('email_address', $office->email_address) }}">
                                @error('email_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Office Head and Service Hours -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="office_head" class="form-label">Office Head</label>
                                <input type="text" class="form-control @error('office_head') is-invalid @enderror" 
                                       id="office_head" name="office_head" value="{{ old('office_head', $office->office_head) }}">
                                @error('office_head')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="service_hours" class="form-label">Service Hours</label>
                                <input type="text" class="form-control @error('service_hours') is-invalid @enderror" 
                                       id="service_hours" name="service_hours" value="{{ old('service_hours', $office->service_hours) }}">
                                @error('service_hours')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-3">
                        <label for="office_description" class="form-label">Office Description</label>
                        <textarea class="form-control @error('office_description') is-invalid @enderror" 
                                  id="office_description" name="office_description" rows="3">{{ old('office_description', $office->office_description) }}</textarea>
                        @error('office_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Status -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="is_active" 
                                   name="is_active" {{ old('is_active', $office->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active Office
                            </label>
                        </div>
                    </div>
                    
                    <!-- Submit Buttons -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.offices.show', $office) }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check"></i> Update Office
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Info Sidebar -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="bi bi-info-circle"></i> Office Info
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-muted">Created</label>
                    <div>{{ $office->created_at->format('M d, Y \a\t g:i A') }}</div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">Last Updated</label>
                    <div>{{ $office->updated_at->format('M d, Y \a\t g:i A') }}</div>
                </div>
                
                @if($office->creator)
                <div class="mb-3">
                    <label class="form-label text-muted">Created By</label>
                    <div>{{ $office->creator->name }}</div>
                </div>
                @endif
                
                <div class="mb-3">
                    <label class="form-label text-muted">Staff Members</label>
                    <div>{{ $office->staffMembers->count() }} assigned</div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="bi bi-lightning"></i> Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.offices.show', $office) }}" class="btn btn-info w-100 mb-2">
                    <i class="bi bi-eye"></i> View Office
                </a>
                
                <a href="{{ route('map.office.show', $office) }}" class="btn btn-outline-primary w-100 mb-2" target="_blank">
                    <i class="bi bi-map"></i> View on Public Map
                </a>
                
                @if($office->staffMembers->count() > 0)
                <a href="{{ route('admin.staff.index', ['location_id' => $office->id]) }}" class="btn btn-outline-success w-100 mb-2">
                    <i class="bi bi-people"></i> View Staff ({{ $office->staffMembers->count() }})
                </a>
                @endif
                
                <button type="button" class="btn btn-danger w-100" onclick="confirmDelete()">
                    <i class="bi bi-trash"></i> Delete Office
                </button>
            </div>
        </div>
        
        <!-- Current Location -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="bi bi-geo-alt"></i> Current Location
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>Coordinates:</strong><br>
                    {{ $office->latitude }}, {{ $office->longitude }}
                </div>
                <a href="https://www.google.com/maps/search/{{ $office->latitude }},{{ $office->longitude }}" 
                   target="_blank" class="btn btn-sm btn-outline-primary w-100">
                    <i class="bi bi-geo-alt"></i> View on Google Maps
                </a>
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
    
    // Validate coordinates
    document.getElementById('latitude').addEventListener('input', function() {
        const lat = parseFloat(this.value);
        if (lat && (lat < 4 || lat > 20)) {
            this.setCustomValidity('Latitude should be between 4° and 20° for Philippines');
        } else {
            this.setCustomValidity('');
        }
    });
    
    document.getElementById('longitude').addEventListener('input', function() {
        const lng = parseFloat(this.value);
        if (lng && (lng < 116 || lng > 127)) {
            this.setCustomValidity('Longitude should be between 116° and 127° for Philippines');
        } else {
            this.setCustomValidity('');
        }
    });
</script>
@endpush
