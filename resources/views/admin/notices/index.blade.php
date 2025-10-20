@extends('navbar')

@section('content')
    <div class="top-navbar">
        <div class="dashboard-header">
            <h1>School Notices</h1>
        </div>
    </div>

    <div class="content-area">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>All Notices</h3>
            <a href="{{ route('admin.notices.create') }}" class="btn btn-primary">Add New Notice</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Created By</th>
                        <th>Expires</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notices as $notice)
                        <tr>
                            <td>{{ $notice->id }}</td>
                            <td>{{ $notice->title }}</td>
                            <td>{{ Str::limit($notice->content, 50) }}</td>
                            <td>{{ $notice->creator->name }}</td>
                            <td>{{ $notice->expires_at ? $notice->expires_at->format('M d, Y') : 'Never' }}</td>
                            <td>
                                @if($notice->isExpired())
                                    <span class="badge bg-danger">Expired</span>
                                @elseif($notice->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.notices.show', $notice) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('admin.notices.edit', $notice) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form method="POST" action="{{ route('admin.notices.destroy', $notice) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No notices found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $notices->links() }}
    </div>
@endsection
