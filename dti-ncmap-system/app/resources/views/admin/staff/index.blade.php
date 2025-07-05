@extends('layouts.app')

@section('title', 'Staff Members - Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Staff Members</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.staff.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Staff Member
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center bg-primary text-white">
            <div class="card-body">
                <h4 class="mb-0">{{ $staffStats['total'] ?? 0 }}</h4>
                <small>Total Staff</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-success text-white">
            <div class="card-body">
                <h4 class="mb-0">{{ $staffStats['active'] ?? 0 }}</h4>
                <small>Active</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-info text-white">
            <div class="card-body">
                <h4 class="mb-0">{{ $staffStats['type_a'] ?? 0 }}</h4>
                <small>Type A</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-warning text-white">
            <div class="card-body">
                <h4 class="mb-0">{{ $staffStats['type_b'] ?? 0 }}</h4>
                <small>Type B</small>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.staff.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Search</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Name, position, contact...">
            </div>
            <div class="col-md-2">
                <label for="location_id" class="form-label">Office Location</label>
                <select class="form-select" id="location_id" name="location_id">
                    <option value="">All Locations</option>
                    @foreach($offices as $location)
                        <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>
                            {{ $location->office_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="type_code" class="form-label">Type</label>
                <select class="form-select" id="type_code" name="type_code">
                    <option value="">All Types</option>
                    <option value="A" {{ request('type_code') === 'A' ? 'selected' : '' }}>Type A</option>
                    <option value="B" {{ request('type_code') === 'B' ? 'selected' : '' }}>Type B</option>
                    <option value="C" {{ request('type_code') === 'C' ? 'selected' : '' }}>Type C</option>
                </select>
            </div>
            <div class="col-md-2">
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
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-1">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Staff Members Table -->
<div class="card">
    <div class="card-body">
        @if($staff->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Staff Details</th>
                            <th>Location</th>
                            <th>Contact Information</th>
                            <th>Type & Status</th>
                            <th>Service Area</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staff as $staffMember)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                {{ strtoupper(substr($staffMember->first_name, 0, 1) . substr($staffMember->last_name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <strong>{{ $staffMember->first_name }} {{ $staffMember->middle_name }} {{ $staffMember->last_name }}</strong><br>
                                            <small class="text-muted">{{ $staffMember->position }}</small><br>
                                            @if($staff->contact_person)
                                                <small class="text-info">Contact: {{ $staff->contact_person }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($staff->officeLocation)
                                        <strong>{{ $staff->officeLocation->office_name }}</strong><br>
                                        <small class="text-muted">{{ $staff->province }}, {{ $staff->municipality }}</small>
                                    @else
                                        <span class="text-muted">{{ $staff->province }}, {{ $staff->municipality }}</span>
                                    @endif
                                    @if($staff->district)
                                        <br><small class="text-muted">District: {{ $staff->district }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($staff->cellphone_number)
                                        <i class="bi bi-phone"></i> {{ $staff->cellphone_number }}<br>
                                    @endif
                                    @if($staff->email_address)
                                        <i class="bi bi-envelope"></i> {{ $staff->email_address }}
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $staff->type_code === 'A' ? 'primary' : ($staff->type_code === 'B' ? 'info' : 'success') }} mb-1">
                                        Type {{ $staff->type_code }}
                                    </span><br>
                                    @if($staff->type_advanced)
                                        <small class="text-muted">{{ $staff->type_advanced }}</small><br>
                                    @endif
                                    @if($staff->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if($staff->service_area)
                                        <small>{{ Str::limit($staff->service_area, 50) }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.staff.show', $staff) }}" class="btn btn-sm btn-outline-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.staff.edit', $staff) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.staff.destroy', $staff) }}" 
                                              style="display: inline;" 
                                              onsubmit="return confirm('Are you sure you want to delete this staff member?')">
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
                    Showing {{ $staffMembers->firstItem() }} to {{ $staffMembers->lastItem() }} of {{ $staffMembers->total() }} results
                </div>
                {{ $staffMembers->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-people" style="font-size: 3rem; color: #6c757d;"></i>
                <h4 class="mt-3 text-muted">No Staff Members Found</h4>
                <p class="text-muted">No staff members match your current filters.</p>
                <a href="{{ route('admin.staff.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add First Staff Member
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
