@extends('layouts.app')

@section('title', 'Create Office Location - DTI NCMAP System')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-plus-circle"></i>
        Create New Office Location
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.offices.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Offices
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Office Details</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.offices.store') }}">
                    @csrf
                    
                    <!-- Office Name and Code -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="office_name" class="form-label">Office Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('office_name') is-invalid @enderror" 
                                       id="office_name" name="office_name" value="{{ old('office_name') }}" required>
                                @error('office_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="office_code" class="form-label">Office Code</label>
                                <input type="text" class="form-control @error('office_code') is-invalid @enderror" 
                                       id="office_code" name="office_code" value="{{ old('office_code') }}" 
                                       placeholder="e.g., DTI-CEBU-001">
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
                                  id="complete_address" name="complete_address" rows="2" required>{{ old('complete_address') }}</textarea>
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="district" class="form-label">District</label>
                                <input type="text" class="form-control @error('district') is-invalid @enderror" 
                                       id="district" name="district" value="{{ old('district') }}">
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
                                       id="latitude" name="latitude" value="{{ old('latitude') }}" 
                                       placeholder="e.g., 10.3157" required>
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="longitude" class="form-label">Longitude <span class="text-danger">*</span></label>
                                <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror" 
                                       id="longitude" name="longitude" value="{{ old('longitude') }}" 
                                       placeholder="e.g., 123.8854" required>
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
                                       id="contact_number" name="contact_number" value="{{ old('contact_number') }}" 
                                       placeholder="e.g., 032-253-6294">
                                @error('contact_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email_address" class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email_address') is-invalid @enderror" 
                                       id="email_address" name="email_address" value="{{ old('email_address') }}" 
                                       placeholder="e.g., office@dti.gov.ph">
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
                                       id="office_head" name="office_head" value="{{ old('office_head') }}">
                                @error('office_head')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="service_hours" class="form-label">Service Hours</label>
                                <input type="text" class="form-control @error('service_hours') is-invalid @enderror" 
                                       id="service_hours" name="service_hours" value="{{ old('service_hours') }}" 
                                       placeholder="e.g., Monday-Friday 8:00 AM - 5:00 PM">
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
                                  id="office_description" name="office_description" rows="3">{{ old('office_description') }}</textarea>
                        @error('office_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Status -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="is_active" 
                                   name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active Office
                            </label>
                        </div>
                    </div>
                    
                    <!-- Submit Buttons -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.offices.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check"></i> Create Office
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
                <h6>Creating Office Locations</h6>
                <ul class="small">
                    <li><strong>Office Name:</strong> Full official name of the DTI office</li>
                    <li><strong>Office Code:</strong> Unique identifier (optional)</li>
                    <li><strong>Address:</strong> Complete mailing address</li>
                    <li><strong>Coordinates:</strong> Required for map display</li>
                    <li><strong>Contact Info:</strong> Phone and email for public directory</li>
                </ul>
                
                <hr>
                
                <h6>Finding Coordinates</h6>
                <ol class="small">
                    <li>Open <a href="https://maps.google.com" target="_blank">Google Maps</a></li>
                    <li>Search for the office address</li>
                    <li>Right-click on the location</li>
                    <li>Copy the coordinates from the popup</li>
                </ol>
                
                <hr>
                
                <h6>Region 7 Provinces</h6>
                <ul class="small">
                    <li>Cebu</li>
                    <li>Bohol</li>
                    <li>Negros Oriental</li>
                    <li>Siquijor</li>
                </ul>
            </div>
        </div>
        
        <!-- Coordinate Helper -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="bi bi-geo-alt"></i> Sample Coordinates
                </h6>
            </div>
            <div class="card-body">
                <h6>Major Cities in Region 7:</h6>
                <div class="mb-2">
                    <strong>Cebu City:</strong><br>
                    <small>Lat: 10.3157, Lng: 123.8854</small>
                </div>
                <div class="mb-2">
                    <strong>Tagbilaran (Bohol):</strong><br>
                    <small>Lat: 9.6496, Lng: 123.8547</small>
                </div>
                <div class="mb-2">
                    <strong>Dumaguete (Negros Oriental):</strong><br>
                    <small>Lat: 9.3016, Lng: 123.3063</small>
                </div>
                <div class="mb-2">
                    <strong>Siquijor:</strong><br>
                    <small>Lat: 9.2057, Lng: 123.5086</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-fill office code based on province and office name
    document.getElementById('province').addEventListener('change', generateOfficeCode);
    document.getElementById('office_name').addEventListener('input', generateOfficeCode);
    
    function generateOfficeCode() {
        const province = document.getElementById('province').value;
        const officeName = document.getElementById('office_name').value;
        const officeCodeField = document.getElementById('office_code');
        
        if (province && officeName && !officeCodeField.value) {
            let provinceCode = '';
            switch(province) {
                case 'Cebu': provinceCode = 'CEBU'; break;
                case 'Bohol': provinceCode = 'BOHOL'; break;
                case 'Negros Oriental': provinceCode = 'NEGOR'; break;
                case 'Siquijor': provinceCode = 'SIQUI'; break;
            }
            
            if (provinceCode) {
                const suggestion = `DTI-${provinceCode}-PROV`;
                officeCodeField.placeholder = `Suggestion: ${suggestion}`;
            }
        }
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
