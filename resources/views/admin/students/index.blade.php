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
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Confirm Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this student? This action cannot be undone and will also delete the associated user account.</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Warning:</strong> Deleting a student will permanently remove all their data including enrollments, attendance, and grades.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Delete Student
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(studentId) {
    try {
        // Find the student row to get the student name for confirmation
        const deleteButton = document.querySelector(`button[onclick*="confirmDelete(${studentId})"]`);
        if (!deleteButton) {
            console.error('Delete button not found for student ID:', studentId);
            return;
        }
        
        const studentRow = deleteButton.closest('tr');
        if (!studentRow) {
            console.error('Student row not found');
            return;
        }
        
        const nameElement = studentRow.querySelector('strong');
        const studentName = nameElement ? nameElement.textContent.trim() : 'this student';
        
        // Update the modal content with the specific student name
        const modalBody = document.querySelector('#deleteModal .modal-body p');
        if (modalBody) {
            modalBody.innerHTML = `Are you sure you want to delete <strong>${studentName}</strong>? This action cannot be undone and will also delete the associated user account.`;
        }
        
        // Set the form action to the correct delete route
        const deleteForm = document.getElementById('deleteForm');
        if (deleteForm) {
            deleteForm.action = `{{ url('/admin/students') }}/${studentId}`;
        }
        
        // Show the modal
        const deleteModalElement = document.getElementById('deleteModal');
        if (deleteModalElement && typeof bootstrap !== 'undefined') {
            const deleteModal = new bootstrap.Modal(deleteModalElement);
            deleteModal.show();
        } else {
            console.error('Bootstrap modal not available');
        }
    } catch (error) {
        console.error('Error in confirmDelete function:', error);
        // Fallback: still try to set the form action and show modal
        const deleteForm = document.getElementById('deleteForm');
        if (deleteForm) {
            deleteForm.action = `{{ url('/admin/students') }}/${studentId}`;
        }
    }
}

// Handle form submission
document.addEventListener('DOMContentLoaded', function() {
    const deleteForm = document.getElementById('deleteForm');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            // Show loading state
            const submitBtn = deleteForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Deleting...';
            submitBtn.disabled = true;
        });
    }
});
</script>
@endsection
