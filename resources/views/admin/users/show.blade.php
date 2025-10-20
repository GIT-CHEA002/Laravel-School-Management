<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>
<body>
    @extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        User Details
    </h2>
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>User Information</h3>
                    <div>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">Edit User</a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to Users</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Basic Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>ID:</strong></td>
                                        <td>{{ $user->id }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Name:</strong></td>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Role:</strong></td>
                                        <td>
                                            <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'teacher' ? 'warning' : 'info') }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email Verified:</strong></td>
                                        <td>
                                            @if($user->email_verified_at)
                                                <span class="text-success">✓ Verified</span>
                                            @else
                                                <span class="text-warning">⚠ Not Verified</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Account Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Created:</strong></td>
                                        <td>{{ $user->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Last Updated:</strong></td>
                                        <td>{{ $user->updated_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Account Age:</strong></td>
                                        <td>{{ $user->created_at->diffForHumans() }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                @if($user->role === 'student')
                    <div class="mt-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Student Information</h5>
                                @if($user->student)
                                    <p><strong>Registration Number:</strong> {{ $user->student->registration_number }}</p>
                                    <p><strong>Date of Birth:</strong> {{ $user->student->date_of_birth ? $user->student->date_of_birth->format('M d, Y') : 'Not set' }}</p>
                                    <p><strong>Gender:</strong> {{ $user->student->gender ?? 'Not set' }}</p>
                                    <p><strong>Phone:</strong> {{ $user->student->phone ?? 'Not set' }}</p>
                                @else
                                    <p class="text-muted">No student profile found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                @if($user->role === 'teacher')
                    <div class="mt-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Teacher Information</h5>
                                @if($user->teacher)
                                    <p><strong>Employee Number:</strong> {{ $user->teacher->employee_number }}</p>
                                    <p><strong>Phone:</strong> {{ $user->teacher->phone ?? 'Not set' }}</p>
                                    <p><strong>Address:</strong> {{ $user->teacher->address ?? 'Not set' }}</p>
                                @else
                                    <p class="text-muted">No teacher profile found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

</body>
</html>
