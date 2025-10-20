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
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registration #</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Created</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>
                                <strong>{{ $student->first_name }} {{ $student->last_name }}</strong>
                            </td>
                            <td>{{ $student->user->email ?? 'N/A' }}</td>
                            <td>{{ $student->registration_number ?? $student->student_code }}</td>
                            <td>
                                @if($student->gender)
                                    <span class="badge bg-{{ $student->gender === 'male' ? 'primary' : ($student->gender === 'female' ? 'danger' : 'secondary') }}">
                                        {{ ucfirst($student->gender) }}
                                    </span>
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </td>
                            <td>{{ $student->phone ?? 'Not set' }}</td>
                            <td>{{ $student->created_at->format('M d, Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.students.show', $student) }}" class="btn btn-sm btn-info me-1">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No students found.</td>
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
