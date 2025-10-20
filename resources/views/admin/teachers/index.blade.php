@extends('navbar')

@section('content')
<div class="top-navbar">
    <div class="dashboard-header">
        <h1>Teacher Management</h1>
    </div>
</div>

<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>All Teachers</h3>
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Teacher
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
                <i class="fas fa-search"></i> Search & Filter Teachers
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.teachers.index') }}" class="row g-3">
                <div class="col-md-6">
                    <label for="search" class="form-label">Search Teachers</label>
                    <input type="text" 
                           name="search" 
                           id="search"
                           class="form-control" 
                           placeholder="Search by name, email, specialization, or phone..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <label for="subject_id" class="form-label">Filter by Subject</label>
                    <select name="subject_id" id="subject_id" class="form-select">
                        <option value="">All Subjects</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Summary -->
    @if(request()->filled('search') || request()->filled('subject_id'))
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            Showing {{ $teachers->total() }} teacher(s) 
            @if(request('search'))
                matching "{{ request('search') }}"
            @endif
            @if(request('subject_id'))
                teaching {{ $subjects->where('id', request('subject_id'))->first()->name ?? '' }}
            @endif
        </div>
    @endif

    <!-- Teachers Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Teachers List</h5>
            <span class="badge bg-primary">{{ $teachers->total() }} Total</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Subject</th>
                            <th>Class</th>
                            <th>Phone</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teachers as $teacher)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-2">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $teacher->user ? $teacher->user->name : ($teacher->first_name . ' ' . $teacher->last_name) }}</strong>
                                            @if($teacher->user && $teacher->user->email)
                                                <br><small class="text-muted">{{ $teacher->user->email }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($teacher->subjects && $teacher->subjects->count() > 0)
                                        @foreach($teacher->subjects->take(3) as $subject)
                                            <span class="badge bg-success me-1 mb-1">{{ $subject->name }}</span>
                                        @endforeach
                                        @if($teacher->subjects->count() > 3)
                                            <br><small class="text-muted">+{{ $teacher->subjects->count() - 3 }} more</small>
                                        @endif
                                    @else
                                        <span class="text-muted">No subjects assigned</span>
                                    @endif
                                </td>
                                <td>
                                    @if($teacher->classes && $teacher->classes->count() > 0)
                                        @foreach($teacher->classes->take(2) as $class)
                                            <span class="badge bg-info me-1 mb-1">{{ $class->class_name }}</span>
                                        @endforeach
                                        @if($teacher->classes->count() > 2)
                                            <br><small class="text-muted">+{{ $teacher->classes->count() - 2 }} more</small>
                                        @endif
                                    @else
                                        <span class="text-muted">No classes assigned</span>
                                    @endif
                                </td>
                                <td>
                                    @if($teacher->phone)
                                        <a href="tel:{{ $teacher->phone }}" class="text-decoration-none">
                                            <i class="fas fa-phone me-1"></i>{{ $teacher->phone }}
                                        </a>
                                    @else
                                        <span class="text-muted">Not set</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.teachers.show', $teacher) }}" class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Delete" onclick="confirmDelete({{ $teacher->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-3x mb-3"></i>
                                        <h5>No Teachers Found</h5>
                                        @if(request()->filled('search') || request()->filled('subject_id'))
                                            <p>Try adjusting your search criteria or <a href="{{ route('admin.teachers.index') }}">clear filters</a></p>
                                        @else
                                            <p>No teachers have been added yet. <a href="{{ route('admin.teachers.create') }}">Add the first teacher</a></p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($teachers->hasPages())
            <div class="card-footer">
                {{ $teachers->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<style>
.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 16px;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.badge {
    font-size: 0.75em;
}
</style>
@endsection
