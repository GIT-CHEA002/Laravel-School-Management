@extends('navbar')

@section('content')
<div class="content-area">
    <div class="dashboard-header mb-4">
        <h1>Students Management</h1>
        <p class="text-muted">Manage all student records efficiently</p>
    </div>

    <div class="bg-white shadow-sm rounded p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="fas fa-users text-primary me-2"></i>All Students</h4>
            <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus-fill me-1"></i> Add New Student
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.students.index') }}" class="mb-4">
            <div class="row g-2">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control"
                           placeholder="Search by name, email, or registration number..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-4 text-end">
                    <button type="submit" class="btn btn-outline-primary me-1">
                        <i class="bi bi-search"></i> Search
                    </button>
                    <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Clear
                    </a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Class</th>
                        <th>Phone</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td class="fw-bold">{{ $student->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $student->first_name }} {{ $student->last_name }}</strong>
                                        @if($student->user && $student->user->email)
                                            <br><small class="text-muted">{{ $student->user->email }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($student->gender)
                                    <span class="badge bg-{{ $student->gender === 'male' ? 'primary' : ($student->gender === 'female' ? 'danger' : 'secondary') }}">
                                        {{ ucfirst($student->gender) }}
                                    </span>
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </td>
                            <td>
                                @if($student->age)
                                    <span class="badge bg-info">{{ $student->age }} years</span>
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </td>
                            <td>
                                @if($student->classes->count() > 0)
                                    @foreach($student->classes as $class)
                                        <span class="badge bg-info me-1">{{ $class->class_name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">No class assigned</span>
                                @endif
                            </td>
                            <td>
                                @if($student->phone)
                                    <a href="tel:{{ $student->phone }}" class="text-decoration-none">
                                        <i class="fas fa-phone me-1"></i>{{ $student->phone }}
                                    </a>
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.students.show', $student) }}" class="btn btn-sm btn-outline-primary" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" title="Delete" onclick="confirmDelete({{ $student->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-users fa-2x mb-3 d-block"></i>
                                No students found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-1">
            {{ $students->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
