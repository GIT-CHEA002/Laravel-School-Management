@extends('navbar')

@section('content')
<div class="top-navbar">
    <div class="dashboard-header">
        <h1>Subject Management</h1>
    </div>
</div>

<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>All Subjects</h3>
        <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Subject
        </a>
    </div>

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

    <!-- Search Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-search"></i> Search Subjects
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.subjects.index') }}" class="row g-3">
                <div class="col-md-8">
                    <label for="search" class="form-label">Search Subjects</label>
                    <input type="text" 
                           name="search" 
                           id="search"
                           class="form-control" 
                           placeholder="Search by name or code..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="btn-group w-100" role="group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="{{ route('admin.subjects.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Summary -->
    @if(request('search'))
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="mb-0">
                    <i class="fas fa-filter text-primary"></i>
                    Showing {{ $subjects->firstItem() ?? 0 }} to {{ $subjects->lastItem() ?? 0 }} of {{ $subjects->total() }} subjects
                    @if(request('search'))
                        matching "{{ request('search') }}"
                    @endif
                </h6>
            </div>
        </div>
    @endif

    <!-- Subjects Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-book"></i> Subjects List
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
                                <i class="fas fa-book text-muted"></i> Subject
                            </th>
                            <th class="border-0">
                                <i class="fas fa-code text-muted"></i> Code
                            </th>
                            <th class="border-0">
                                <i class="fas fa-chalkboard-teacher text-muted"></i> Teachers
                            </th>
                            <th class="border-0">
                                <i class="fas fa-calendar-alt text-muted"></i> Classes
                            </th>
                            <th class="border-0 text-center">
                                <i class="fas fa-cogs text-muted"></i> Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $subject)
                            <tr>
                                <td>
                                    <span class="fw-bold text-muted">#{{ $subject->id }}</span>
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-bold">{{ $subject->name }}</div>
                                        <small class="text-muted">{{ $subject->code }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info text-white">{{ $subject->code }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-chalkboard-teacher text-warning me-2"></i>
                                        <span class="fw-semibold">{{ $subject->teachers_count ?? 0 }}</span>
                                        <small class="text-muted ms-1">teachers</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                                        <span class="fw-semibold">{{ $subject->classes_count ?? 0 }}</span>
                                        <small class="text-muted ms-1">classes</small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.subjects.show', $subject) }}" 
                                           class="btn btn-sm btn-outline-info" 
                                           data-bs-toggle="tooltip" 
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.subjects.edit', $subject) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           data-bs-toggle="tooltip" 
                                           title="Edit Subject">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.subjects.destroy', $subject) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this subject?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    data-bs-toggle="tooltip" 
                                                    title="Delete Subject">
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
                                        <i class="fas fa-book fa-3x mb-3"></i>
                                        <h5>No subjects found</h5>
                                        <p>Get started by creating your first subject.</p>
                                        <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Add New Subject
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        @if($subjects->hasPages())
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted">
                            Showing {{ $subjects->firstItem() ?? 0 }} to {{ $subjects->lastItem() ?? 0 }} of {{ $subjects->total() }} subjects
                        </span>
                    </div>
                    <div>
                        {{ $subjects->appends(request()->query())->links() }}
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
