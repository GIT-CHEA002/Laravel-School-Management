<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    @extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Teacher Details
    </h2>
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Teacher Information</h3>
                    <div>
                        <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>

                <div class="row">
                    {{-- User Info --}}
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">User Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>User ID:</strong></td>
                                        <td>{{ $teacher->user->id }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Name:</strong></td>
                                        <td>{{ $teacher->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>{{ $teacher->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date of Birth:</strong></td>
                                        <td>{{ $teacher->user->date_of_birth ?? 'Not set' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Gender:</strong></td>
                                        <td>{{ ucfirst($teacher->user->gender ?? 'Not set') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Created:</strong></td>
                                        <td>{{ $teacher->user->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Teacher Profile Info --}}
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Teacher Profile</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Teacher ID:</strong></td>
                                        <td>{{ $teacher->id }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Specialization:</strong></td>
                                        <td>{{ $teacher->specialization ?? 'Not set' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Phone:</strong></td>
                                        <td>{{ $teacher->phone ?? 'Not set' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address:</strong></td>
                                        <td>{{ $teacher->address ?? 'Not set' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Joined On:</strong></td>
                                        <td>{{ $teacher->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

</body>
</html>
