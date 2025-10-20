@extends('navbar')

@section('content')
<div class="top-navbar">
    <div class="dashboard-header">
        <h1>Create New User</h1>
    </div>
</div>

<div class="content-area">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-plus"></i> User Information
                    </h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user text-primary"></i> Full Name
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           placeholder="Enter full name"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope text-primary"></i> Email Address
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="Enter email address"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock text-primary"></i> Password
                                    </label>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password" 
                                           name="password" 
                                           placeholder="Enter password"
                                           required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">
                                        <i class="fas fa-lock text-primary"></i> Confirm Password
                                    </label>
                                    <input type="password" 
                                           class="form-control"
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           placeholder="Confirm password"
                                           required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="role" class="form-label">
                                <i class="fas fa-user-tag text-primary"></i> User Role
                            </label>
                            <select class="form-select @error('role') is-invalid @enderror"
                                    id="role" 
                                    name="role" 
                                    required>
                                <option value="">Select User Role</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                                    <i class="fas fa-user-shield"></i> Administrator
                                </option>
                                <option value="teacher" {{ old('role') === 'teacher' ? 'selected' : '' }}>
                                    <i class="fas fa-chalkboard-teacher"></i> Teacher
                                </option>
                                <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>
                                    <i class="fas fa-graduation-cap"></i> Student
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle text-info"></i>
                                Choose the appropriate role for this user. Each role has different permissions and access levels.
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Users
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.content-area {
    padding: 20px;
    background-color: #f8f9fa;
    min-height: calc(100vh - 80px);
}

.top-navbar {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px 0;
    margin-bottom: 30px;
}

.dashboard-header h1 {
    color: white;
    margin: 0;
    font-weight: 600;
    text-align: center;
}

.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    border-radius: 12px 12px 0 0 !important;
    padding: 1rem 1.5rem;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #d1d5db;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    transform: translateY(-1px);
}

.form-label {
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
}
</style>
@endsection