@extends('navbar')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Teacher Management
    </h2>
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>All Teachers</h3>
                    <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">Add New Teacher</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Search Form -->
                <form method="GET" action="{{ route('admin.students.index') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" name="search" class="form-control"
                                   placeholder="Search by name, email, or registration number..."
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-outline-primary">Search</button>
                            <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-secondary">Clear</a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Subject</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse( $teachers as $teacher)
                                <tr>
                                    <td>{{ $teacher->user_id }}</td>
                                    <td>{{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                                    <td>{{ $teacher->specialization }}</td>
                                    <td>{{ $teacher->phone ?? 'Not set' }}</td>
                                    <td>{{ $teacher->address ?? 'Not set' }}</td>
                                    <td>{{ $teacher->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.teachers.show', $teacher) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-sm btn-warning">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No Teacher found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $teachers->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
