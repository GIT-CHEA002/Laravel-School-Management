@extends('navbar')

@section('content')
    <div class="top-navbar">
        <div class="dashboard-header">
            <h1>{{ $schoolClass->class_name }} Details</h1>
        </div>
    </div>

    <div class="content-area">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Class Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Class Name:</strong> {{ $schoolClass->class_name }}</p>
                                <p><strong>Room Number:</strong> {{ $schoolClass->room_number ?? 'Not set' }}</p>
                            </div>
                            <div class="col-md-6">
                                @if($schoolClass->teacher && $schoolClass->teacher->user)
                                    <p><strong>Class Teacher:</strong> {{ $schoolClass->teacher->user->name }}</p>
                                    <p><strong>Teacher Email:</strong> {{ $schoolClass->teacher->user->email }}</p>
                                @else
                                    <p><strong>Class Teacher:</strong> Not assigned</p>
                                @endif
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.classes.edit', $schoolClass) }}" class="btn btn-warning">Edit Class</a>
                            <a href="{{ route('admin.classes.assign-subjects', $schoolClass) }}" class="btn btn-success">Manage Subjects</a>
                            <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Back to Classes</a>
                        </div>
                    </div>
                </div>

                <!-- Subjects Section -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Assigned Subjects</h5>
                        <span class="badge bg-primary">{{ $schoolClass->subjects->count() }} subjects</span>
                    </div>
                    <div class="card-body">
                        @if($schoolClass->subjects->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>Code</th>
                                            <th>Assigned Teacher</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($schoolClass->subjects as $subject)
                                            <tr>
                                                <td>{{ $subject->name }}</td>
                                                <td><span class="badge bg-info">{{ $subject->code }}</span></td>
                                                <td>
                                                    @php
                                                        $teacher = $schoolClass->teachers->where('id', $subject->pivot->teacher_id)->first();
                                                    @endphp
                                                    @if($teacher && $teacher->user)
                                                        {{ $teacher->user->name }}
                                                    @else
                                                        <span class="text-muted">Not assigned</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted">No subjects assigned to this class yet.</p>
                                <a href="{{ route('admin.classes.assign-subjects', $schoolClass) }}" class="btn btn-primary">Assign Subjects</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Students Section -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Enrolled Students</h5>
                        <span class="badge bg-success">{{ $schoolClass->students->count() }} students</span>
                    </div>
                    <div class="card-body">
                        @if($schoolClass->students->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Student Code</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($schoolClass->students as $student)
                                            <tr>
                                                <td>{{ $student->student_code ?? 'N/A' }}</td>
                                                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                                <td>
                                                    <span class="badge {{ $student->gender === 'male' ? 'bg-info' : 'bg-warning' }}">
                                                        {{ ucfirst($student->gender ?? 'unknown') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted">No students enrolled in this class yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6>Quick Stats</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Total Students:</span>
                                <strong>{{ $schoolClass->students->count() }}</strong>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Total Subjects:</span>
                                <strong>{{ $schoolClass->subjects->count() }}</strong>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Teachers:</span>
                                <strong>{{ $schoolClass->teachers->count() }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
