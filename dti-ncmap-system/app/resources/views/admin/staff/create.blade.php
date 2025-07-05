@extends('layouts.app')

@section('title', 'Create Staff Member - DTI NCMAP System')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-person-plus"></i>
        Create New Staff Member
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.staff.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Staff
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Staff Information</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.staff.store') }}">
                    @csrf
                    
                    <!-- Personal Information -->
                    <h6 class="text-primary border-bottom pb-2 mb-3">Personal Information</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                       id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="middle_name" class="form-label">Middle Name</label>
                                <input type="text" class="form-control @error('middle_name') is-invalid @enderror" 
                                       id="middle_name" name="middle_name" value="{{ old('middle_name') }}">
                                @error('middle_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                       id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_created" class="form-label">Date Created</label>
                                <input type="date" class="form-control @error('date_created') is-invalid @enderror" 
                                       id="date_created" name="date_created" value="{{ old('date_created', date('Y-m-d')) }}">
                                @error('date_created')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Location Information -->
                    <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">Location Information</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="region" class="form-label">Region</label>
                                <input type="text" class="form-control @error('region') is-invalid @enderror" 
                                       id="region" name="region" value="{{ old('region', 'Region 7') }}">
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
                                    <option value="Cebu" {{ old('province') === 'Cebu' ? 'selected' : '' }}>Cebu</option>
                                    <option value="Bohol" {{ old('province') === 'Bohol' ? 'selected' : '' }}>Bohol</option>
                                    <option value="Negros Oriental" {{ old('province') === 'Negros Oriental' ? 'selected' : '' }}>Negros Oriental</option>
                                    <option value="Siquijor" {{ old('province') === 'Siquijor' ? 'selected' : '' }}>Siquijor</option>
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
                                       id="municipality" name="municipality" value="{{ old('municipality') }}" required>
                                @error('municipality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="district" class="form-label">District</label>
                                <input type="text" class="form-control @error('district') is-invalid @enderror" 
                                       id="district" name="district" value="{{ old('district') }}">
                                @error('district')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="complete_address" class="form-label">Complete Address</label>
                                <textarea class="form-control @error('complete_address') is-invalid @enderror" 
                                          id="complete_address" name="complete_address" rows="2">{{ old('complete_address') }}</textarea>
                                @error('complete_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Office Assignment -->
                    <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">Office Assignment</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="location_id" class="form-label">Office Location</label>
                                <select class="form-select @error('location_id') is-invalid @enderror" 
                                        id="location_id" name="location_id">
                                    <option value="">Select Office Location</option>
                                    @foreach($officeLocations as $location)
                                        <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                            {{ $location->office_name }} - {{ $location->municipality }}, {{ $location->province }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Professional Information -->
                    <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">Professional Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="position" class="form-label">Position <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror" 
                                       id="position" name="position" value="{{ old('position') }}" required>
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contact_person" class="form-label">Contact Person</label>
                                <input type="text" class="form-control @error('contact_person') is-invalid @enderror" 
                                       id="contact_person" name="contact_person" value="{{ old('contact_person') }}">
                                @error('contact_person')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="type_code" class="form-label">Type Code <span class="text-danger">*</span></label>
                                <select class="form-select @error('type_code') is-invalid @enderror" 
                                        id="type_code" name="type_code" required>
                                    <option value="">Select Type</option>
                                    <option value="A" {{ old('type_code') === 'A' ? 'selected' : '' }}>Type A</option>
                                    <option value="B" {{ old('type_code') === 'B' ? 'selected' : '' }}>Type B</option>
                                    <option value="C" {{ old('type_code') === 'C' ? 'selected' : '' }}>Type C</option>
                                </select>
                                @error('type_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="type_advanced" class="form-label">Type Advanced Description</label>
                                <input type="text" class="form-control @error('type_advanced') is-invalid @enderror" 
                                       id="type_advanced" name="type_advanced" value="{{ old('type_advanced') }}">
                                @error('type_advanced')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="service_area" class="form-label">Service Area</label>
                        <textarea class="form-control @error('service_area') is-invalid @enderror" 
                                  id="service_area" name="service_area" rows="2" 
                                  placeholder="Describe the service area or coverage...">{{ old('service_area') }}</textarea>
                        @error('service_area')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Contact Information -->
                    <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">Contact Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cellphone_number" class="form-label">Cellphone Number</label>
                                <input type="text" class="form-control @error('cellphone_number') is-invalid @enderror" 
                                       id="cellphone_number" name="cellphone_number" value="{{ old('cellphone_number') }}" 
                                       placeholder="e.g., 09171234567">
                                @error('cellphone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email_address" class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email_address') is-invalid @enderror" 
                                       id="email_address" name="email_address" value="{{ old('email_address') }}" 
                                       placeholder="staff@dti.gov.ph">
                                @error('email_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Information -->
                    <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">Additional Information</h6>
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                  id="remarks" name="remarks" rows="3">{{ old('remarks') }}</textarea>
                        @error('remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Status -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="is_active" 
                                   name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active Staff Member
                            </label>
                        </div>
                    </div>
                    
                    <!-- Submit Buttons -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check"></i> Create Staff Member
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Help Sidebar -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="bi bi-info-circle"></i> Help
                </h6>
            </div>
            <div class="card-body">
                <h6>Creating Staff Members</h6>
                <ul class="small">
                    <li><strong>Personal Info:</strong> Full name and gender</li>
                    <li><strong>Location:</strong> Where the staff is based</li>
                    <li><strong>Office Assignment:</strong> Link to office location (optional)</li>
                    <li><strong>Position:</strong> Job title or role</li>
                    <li><strong>Type Code:</strong> Classification (A/B/C)</li>
                    <li><strong>Service Area:</strong> Coverage or responsibility</li>
                </ul>
                
                <hr>
                
                <h6>Type Classifications</h6>
                <ul class="small">
                    <li><strong>Type A:</strong> Administrative Staff</li>
                    <li><strong>Type B:</strong> Field Operations</li>
                    <li><strong>Type C:</strong> Support Staff</li>
                </ul>
                
                <hr>
                
                <h6>Contact Information</h6>
                <ul class="small">
                    <li>Use official contact details</li>
                    <li>Include both mobile and email when available</li>
                    <li>Contact Person field for alternate contacts</li>
                </ul>
            </div>
        </div>
        
        <!-- Office Locations Quick Reference -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="bi bi-building"></i> Available Offices
                </h6>
            </div>
            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                @if($officeLocations->count() > 0)
                    @foreach($officeLocations as $location)
                        <div class="mb-2 p-2 border rounded small">
                            <strong>{{ $location->office_name }}</strong><br>
                            <text-muted>{{ $location->municipality }}, {{ $location->province }}</text-muted>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No office locations available.</p>
                    <a href="{{ route('admin.offices.create') }}" class="btn btn-sm btn-primary">
                        Add Office Location
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-populate fields based on selections
    document.getElementById('province').addEventListener('change', function() {
        const region = document.getElementById('region');
        if (this.value && !region.value) {
            region.value = 'Region 7';
        }
    });
    
    // Validate phone number format
    document.getElementById('cellphone_number').addEventListener('input', function() {
        const phone = this.value.replace(/\D/g, '');
        if (phone.length > 0 && !phone.match(/^(09\d{9}|639\d{9})$/)) {
            this.setCustomValidity('Please enter a valid Philippine mobile number (09XXXXXXXXX)');
        } else {
            this.setCustomValidity('');
        }
    });
    
    // Auto-suggest email based on name
    document.getElementById('last_name').addEventListener('blur', function() {
        const firstName = document.getElementById('first_name').value;
        const lastName = this.value;
        const emailField = document.getElementById('email_address');
        
        if (firstName && lastName && !emailField.value) {
            const suggestion = `${firstName.toLowerCase()}.${lastName.toLowerCase()}@dti.gov.ph`;
            emailField.placeholder = `Suggestion: ${suggestion}`;
        }
    });
</script>
@endpush
