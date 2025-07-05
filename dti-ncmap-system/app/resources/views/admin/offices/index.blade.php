@extends('layouts.app')

@section('title', 'Office Locations - Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Office Locations</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.offices.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Office Location
        </a>
    </div>
</div>

<!-- Search and Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.offices.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Search</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Office name, code, address...">
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
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Office Locations Table -->
<div class="card">
    <div class="card-body">
        @if($offices->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Office Details</th>
                            <th>Location</th>
                            <th>Contact</th>
                            <th>Staff</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($offices as $office)
                            <tr>
                                <td>
                                    <strong>{{ $office->office_name }}</strong><br>
                                    <small class="text-muted">{{ $office->office_code }}</small>
                                    @if($office->office_head)
                                        <br><small class="text-muted">Head: {{ $office->office_head }}</small>
                                    @endif
                                </td>
                                <td>
                                    {{ $office->province }}, {{ $office->municipality }}<br>
                                    <small class="text-muted">{{ Str::limit($office->complete_address, 50) }}</small>
                                </td>
                                <td>
                                    @if($office->contact_number)
                                        <i class="bi bi-phone"></i> {{ $office->contact_number }}<br>
                                    @endif
                                    @if($office->email_address)
                                        <i class="bi bi-envelope"></i> {{ $office->email_address }}
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $office->staffMembers->count() }} members</span>
                                </td>
                                <td>
                                    @if($office->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.offices.show', $office) }}" class="btn btn-sm btn-outline-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.offices.edit', $office) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.offices.destroy', $office) }}" 
                                              style="display: inline;" 
                                              onsubmit="return confirm('Are you sure you want to delete this office location?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Showing {{ $offices->firstItem() }} to {{ $offices->lastItem() }} of {{ $offices->total() }} results
                </div>
                {{ $offices->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-building" style="font-size: 3rem; color: #6c757d;"></i>
                <h4 class="mt-3 text-muted">No Office Locations Found</h4>
                <p class="text-muted">No office locations match your current filters.</p>
                <a href="{{ route('admin.offices.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add First Office Location
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
