@extends('layouts.app')

@section('title', 'Register - DTI NCMAP System')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-geo-alt-fill text-primary" style="font-size: 3rem;"></i>
                        <h3 class="mt-2">Create Account</h3>
                        <p class="text-muted">Join the DTI NCMAP System</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Username</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="full_name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                           id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                                    @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="user_type" class="form-label">User Type</label>
                            <select class="form-select @error('user_type') is-invalid @enderror" 
                                    id="user_type" name="user_type" required>
                                <option value="">Select User Type</option>
                                <option value="guest" {{ old('user_type') === 'guest' ? 'selected' : '' }}>Guest (View Only)</option>
                                <option value="admin" {{ old('user_type') === 'admin' ? 'selected' : '' }}>Admin (Full Access)</option>
                            </select>
                            @error('user_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="bi bi-person-plus"></i> Create Account
                        </button>

                        <div class="text-center">
                            <p class="mb-0">Already have an account? 
                                <a href="{{ route('login') }}" class="text-decoration-none">Sign in here</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
