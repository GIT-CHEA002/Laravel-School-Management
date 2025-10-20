@extends('navbar')

@section('content')
    <div class="top-navbar">
        <div class="dashboard-header">
            <h1>Classes Management</h1>
        </div>
    </div>

    <div class="content-area">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>All Classes</h3>
            <a href="{{ route('admin.classes.create') }}" class="btn btn-primary">Add New Class</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Class Name</th>
                        <th>Teacher in Charge</th>
                        <th>Number of Students</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $class)
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ $class->class_name }}</strong>
                                    @if($class->room_number)
                                        <br><small class="text-muted">Room: {{ $class->room_number }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($class->teacher && $class->teacher->user)
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-2">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $class->teacher->user->name }}</strong>
                                            @if($class->teacher->user->email)
                                                <br><small class="text-muted">{{ $class->teacher->user->email }}</small>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">Not assigned</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="stats-badge me-2">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $class->students_count ?? 0 }}</strong>
                                        <br><small class="text-muted">{{ $class->subjects->count() }} subjects</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.classes.show', $class) }}" class="btn btn-sm btn-outline-primary" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.classes.assign-subjects', $class) }}" class="btn btn-sm btn-outline-success" title="Assign Subjects">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-school fa-2x mb-3 d-block"></i>
                                No classes found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $classes->links() }}
    </div>
@endsection