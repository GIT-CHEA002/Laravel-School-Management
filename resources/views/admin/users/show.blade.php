@extends('navbar')

@section('content')

<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">{{ $user->name }}</h3>
            <p class="text-muted mb-0">{{ ucfirst($user->role) }} Account</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Basic Information -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user text-primary"></i> Basic Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12 text-center">
                            <div class="avatar-circle-large mx-auto mb-3">
                                <i class="fas fa-user text-white" style="font-size: 2rem;"></i>
                            </div>
                            <h4 class="mb-1">{{ $user->name }}</h4>
                            <span class="badge fs-6 px-3 py-2
                                @if($user->role === 'admin')
                                    bg-danger text-white
                                @elseif($user->role === 'teacher')
                                    bg-warning text-dark
                                @else
                                    bg-info text-white
                                @endif">
                                <i class="fas fa-user-
                                    @if($user->role === 'admin')
                                        shield
                                    @elseif($user->role === 'teacher')
                                        chalkboard-teacher
                                    @else
                                        graduation-cap
                                    @endif"></i>
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>

                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-bold text-muted">User ID:</td>
                            <td><span class="badge bg-light text-dark">#{{ $user->id }}</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Email:</td>
                            <td>
                                <div>
                                    <div class="fw-semibold">{{ $user->email }}</div>
                                    @if($user->email_verified_at)
                                        <small class="text-success">
                                            <i class="fas fa-check-circle"></i> Verified
                                        </small>
                                    @else
                                        <small class="text-warning">
                                            <i class="fas fa-exclamation-triangle"></i> Unverified
                                        </small>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Account Information -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle text-primary"></i> Account Information
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-bold text-muted">Created:</td>
                            <td>
                                <div>
                                    <div class="fw-semibold">{{ $user->created_at->format('M d, Y H:i') }}</div>
                                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Last Updated:</td>
                            <td>
                                <div>
                                    <div class="fw-semibold">{{ $user->updated_at->format('M d, Y H:i') }}</div>
                                    <small class="text-muted">{{ $user->updated_at->diffForHumans() }}</small>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Account Status:</td>
                            <td>
                                <span class="badge bg-success">
                                    <i class="fas fa-check"></i> Active
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Role-specific Information -->
    @if($user->role === 'student' && $user->student)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-graduation-cap text-primary"></i> Student Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold text-muted">Student Code:</td>
                                        <td>{{ $user->student->student_code ?? 'Not set' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Date of Birth:</td>
                                        <td>
                                            @if($user->student->dob)
                                                {{ $user->student->dob->format('M d, Y') }}
                                            @else
                                                Not set
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Gender:</td>
                                        <td>{{ ucfirst($user->student->gender ?? 'Not set') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold text-muted">Phone:</td>
                                        <td>{{ $user->student->phone ?? 'Not set' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Parent Name:</td>
                                        <td>{{ $user->student->parent_name ?? 'Not set' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Parent Phone:</td>
                                        <td>{{ $user->student->parent_phone ?? 'Not set' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif($user->role === 'teacher' && $user->teacher)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chalkboard-teacher text-primary"></i> Teacher Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold text-muted">First Name:</td>
                                        <td>{{ $user->teacher->first_name ?? 'Not set' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Last Name:</td>
                                        <td>{{ $user->teacher->last_name ?? 'Not set' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Phone:</td>
                                        <td>{{ $user->teacher->phone ?? 'Not set' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold text-muted">Specialization:</td>
                                        <td>{{ $user->teacher->specialization ?? 'Not set' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Hire Date:</td>
                                        <td>
                                            @if($user->teacher->hire_date)
                                                {{ $user->teacher->hire_date->format('M d, Y') }}
                                            @else
                                                Not set
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
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

.card:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    border-radius: 12px 12px 0 0 !important;
    padding: 1rem 1.5rem;
}

.avatar-circle-large {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
}

.table td {
    border: none;
    padding: 0.5rem 0;
}

.badge {
    border-radius: 20px;
    font-weight: 500;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-group .btn {
    border-radius: 6px;
    margin: 0 2px;
}
</style>
@endsection
