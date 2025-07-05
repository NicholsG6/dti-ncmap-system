@extends('layouts.app')

@section('title', 'Edit Reminder - DTI NCMAP System')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-pencil-square"></i>
        Edit Reminder
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.reminders.show', $reminder) }}" class="btn btn-sm btn-outline-info">
                <i class="bi bi-eye"></i> View
            </a>
            <a href="{{ route('admin.reminders.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Update Reminder Details</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.reminders.update', $reminder) }}">
                    @csrf
                    @method('PUT')
                    
                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $reminder->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $reminder->description) }}</textarea>
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
                                       value="{{ old('reminder_date', $reminder->reminder_date->format('Y-m-d')) }}" required>
                                @error('reminder_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="reminder_time" class="form-label">Time</label>
                                <input type="time" class="form-control @error('reminder_time') is-invalid @enderror" 
                                       id="reminder_time" name="reminder_time" 
                                       value="{{ old('reminder_time', $reminder->reminder_time_input) }}">
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
                                    <option value="Low" {{ old('priority', $reminder->priority) === 'Low' ? 'selected' : '' }}>Low</option>
                                    <option value="Medium" {{ old('priority', $reminder->priority) === 'Medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="High" {{ old('priority', $reminder->priority) === 'High' ? 'selected' : '' }}>High</option>
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
                                    <option value="Active" {{ old('status', $reminder->status) === 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Completed" {{ old('status', $reminder->status) === 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Cancelled" {{ old('status', $reminder->status) === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
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
                                        <option value="{{ $office->id }}" {{ old('location_id', $reminder->location_id) == $office->id ? 'selected' : '' }}>
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
                                        <option value="{{ $staff->id }}" {{ old('staff_id', $reminder->staff_id) == $staff->id ? 'selected' : '' }}>
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
                        <a href="{{ route('admin.reminders.show', $reminder) }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check"></i> Update Reminder
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
                    <i class="bi bi-info-circle"></i> Reminder Info
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-muted">Created</label>
                    <div>{{ $reminder->created_at->format('M d, Y \a\t g:i A') }}</div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">Last Updated</label>
                    <div>{{ $reminder->updated_at->format('M d, Y \a\t g:i A') }}</div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">Created By</label>
                    <div>{{ $reminder->creator->name ?? 'System' }}</div>
                </div>
                
                @if($reminder->is_overdue)
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Overdue</strong><br>
                        This reminder is past its due date.
                    </div>
                @endif
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
                @if($reminder->status === 'Active')
                    <form method="POST" action="{{ route('admin.reminders.update', $reminder) }}" class="mb-2">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="Completed">
                        <button type="submit" class="btn btn-success btn-sm w-100">
                            <i class="bi bi-check-circle"></i> Mark as Completed
                        </button>
                    </form>
                @endif
                
                @if($reminder->status !== 'Cancelled')
                    <form method="POST" action="{{ route('admin.reminders.update', $reminder) }}" class="mb-2">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="Cancelled">
                        <button type="submit" class="btn btn-warning btn-sm w-100">
                            <i class="bi bi-x-circle"></i> Cancel Reminder
                        </button>
                    </form>
                @endif
                
                <button type="button" class="btn btn-danger btn-sm w-100" onclick="confirmDelete()">
                    <i class="bi bi-trash"></i> Delete Reminder
                </button>
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
                Are you sure you want to delete this reminder? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('admin.reminders.destroy', $reminder) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
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
