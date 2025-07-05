@extends('layouts.app')

@section('title', 'Create Reminder - DTI NCMAP System')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-plus-circle"></i>
        Create New Reminder
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.reminders.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Reminders
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Reminder Details</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.reminders.store') }}">
                    @csrf
                    
                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Date and Time Row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="reminder_date" class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('reminder_date') is-invalid @enderror" 
                                       id="reminder_date" name="reminder_date" 
                                       value="{{ old('reminder_date', date('Y-m-d')) }}" required>
                                @error('reminder_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="reminder_time" class="form-label">Time</label>
                                <input type="time" class="form-control @error('reminder_time') is-invalid @enderror" 
                                       id="reminder_time" name="reminder_time" value="{{ old('reminder_time') }}">
                                @error('reminder_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Leave empty for all-day reminder</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Priority and Status Row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="priority" class="form-label">Priority</label>
                                <select class="form-select @error('priority') is-invalid @enderror" 
                                        id="priority" name="priority">
                                    <option value="Low" {{ old('priority') === 'Low' ? 'selected' : '' }}>Low</option>
                                    <option value="Medium" {{ old('priority', 'Medium') === 'Medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="High" {{ old('priority') === 'High' ? 'selected' : '' }}>High</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" name="status">
                                    <option value="Active" {{ old('status', 'Active') === 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Completed" {{ old('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Cancelled" {{ old('status') === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Associated Location/Staff Row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="location_id" class="form-label">Office Location</label>
                                <select class="form-select @error('location_id') is-invalid @enderror" 
                                        id="location_id" name="location_id">
                                    <option value="">Select Office (Optional)</option>
                                    @foreach(\App\Models\OfficeLocation::active()->orderBy('office_name')->get() as $office)
                                        <option value="{{ $office->id }}" {{ old('location_id') == $office->id ? 'selected' : '' }}>
                                            {{ $office->office_name }} ({{ $office->office_code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="staff_id" class="form-label">Staff Member</label>
                                <select class="form-select @error('staff_id') is-invalid @enderror" 
                                        id="staff_id" name="staff_id">
                                    <option value="">Select Staff (Optional)</option>
                                    @foreach(\App\Models\StaffInformation::active()->orderBy('last_name')->orderBy('first_name')->get() as $staff)
                                        <option value="{{ $staff->id }}" {{ old('staff_id') == $staff->id ? 'selected' : '' }}>
                                            {{ $staff->full_name }} - {{ $staff->position }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('staff_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Buttons -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.reminders.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check"></i> Create Reminder
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
                <h6>Creating Reminders</h6>
                <ul class="small">
                    <li><strong>Title:</strong> Brief description of the reminder</li>
                    <li><strong>Description:</strong> Detailed information (optional)</li>
                    <li><strong>Date:</strong> When the reminder is due</li>
                    <li><strong>Time:</strong> Specific time or leave empty for all-day</li>
                    <li><strong>Priority:</strong> High, Medium, or Low importance</li>
                    <li><strong>Location/Staff:</strong> Associate with specific office or person</li>
                </ul>
                
                <hr>
                
                <h6>Priority Levels</h6>
                <div class="mb-2">
                    <span class="badge bg-danger">High</span> Urgent tasks
                </div>
                <div class="mb-2">
                    <span class="badge bg-warning">Medium</span> Normal tasks
                </div>
                <div class="mb-2">
                    <span class="badge bg-info">Low</span> Non-urgent tasks
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-populate staff based on selected location
    document.getElementById('location_id').addEventListener('change', function() {
        const locationId = this.value;
        const staffSelect = document.getElementById('staff_id');
        
        if (locationId) {
            // Filter staff by location (you could implement this via AJAX)
            // For now, we'll just show all staff
        }
    });
    
    // Set minimum date to today
    document.getElementById('reminder_date').min = new Date().toISOString().split('T')[0];
</script>
@endpush
