@extends('navbar')

@section('content')
<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>All Users</h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New User
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search and Filter Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-search"></i> Search & Filter Users
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
                <div class="col-md-6">
                    <label for="search" class="form-label">Search Users</label>
                    <input type="text"
                           name="search"
                           id="search"
                           class="form-control"
                           placeholder="Search by name or email..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <label for="role" class="form-label">Filter by Role</label>
                    <select name="role" id="role" class="form-select">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <div class="btn-group w-100" role="group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Summary -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h6 class="mb-0">
                        <i class="fas fa-users text-primary"></i>
                        Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
                        @if(request('search') || request('role'))
                            (filtered results)
                        @endif
                    </h6>
                </div>
                <div class="col-md-4 text-end">
                    @if(request('search') || request('role'))
                        <small class="text-muted">
                            <i class="fas fa-filter"></i> Filters applied
                        </small>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-list"></i> Users List
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">
                                <i class="fas fa-hashtag text-muted"></i> ID
                            </th>
                            <th class="border-0">
                                <i class="fas fa-user text-muted"></i> User
                            </th>
                            <th class="border-0">
                                <i class="fas fa-envelope text-muted"></i> Email
                            </th>
                            <th class="border-0">
                                <i class="fas fa-user-tag text-muted"></i> Role
                            </th>
                            <th class="border-0">
                                <i class="fas fa-calendar text-muted"></i> Created
                            </th>
                            <th class="border-0 text-center">
                                <i class="fas fa-cogs text-muted"></i> Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    <span class="fw-bold text-muted">#{{ $user->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $user->name }}</div>
                                            <small class="text-muted">ID: {{ $user->id }}</small>
                                        </div>
                                    </div>
                                </td>
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
                                <td>
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
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-semibold">{{ $user->created_at->format('M d, Y') }}</div>
                                        <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.users.show', $user) }}"
                                           class="btn btn-sm btn-outline-info"
                                           data-bs-toggle="tooltip"
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="btn btn-sm btn-outline-warning"
                                           data-bs-toggle="tooltip"
                                           title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="tooltip"
                                                    title="Delete User">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-3x mb-3"></i>
                                        <h5>No users found</h5>
                                        <p>
                                            @if(request('search') || request('role'))
                                                No users match your current search criteria.
                                            @else
                                                Get started by creating your first user.
                                            @endif
                                        </p>
                                        @if(request('search') || request('role'))
                                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                                                <i class="fas fa-times"></i> Clear Filters
                                            </a>
                                        @else
                                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Add New User
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted">
                            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
                        </span>
                    </div>
                    <div>
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
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

.card:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    border-radius: 12px 12px 0 0 !important;
    padding: 1rem 1.5rem;
}

.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

.table th {
    font-weight: 600;
    color: #495057;
    border-bottom: 2px solid #dee2e6;
    padding: 1rem 0.75rem;
}

.table td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border-bottom: 1px solid #f8f9fa;
}

.table tbody tr:hover {
    background-color: rgba(102, 126, 234, 0.05);
    transition: background-color 0.2s ease;
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

.badge {
    border-radius: 20px;
    font-weight: 500;
}

.alert {
    border: none;
    border-radius: 10px;
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

.pagination {
    margin-bottom: 0;
}

.page-link {
    border-radius: 8px;
    margin: 0 2px;
    border: 1px solid #dee2e6;
    color: #667eea;
}

.page-link:hover {
    background-color: #667eea;
    border-color: #667eea;
    color: white;
}

.page-item.active .page-link {
    background-color: #667eea;
    border-color: #667eea;
}
</style>

<script>
// Enable Bootstrap tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection
