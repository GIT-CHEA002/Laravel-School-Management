
    @extends('navbar')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Student Details
    </h2>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Student Information</h3>
                    <div>
                        <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-warning">Edit Student</a>
                        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Back to Students</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Personal Information</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Student ID:</strong></td>
                                        <td>{{ $student->id }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Name:</strong></td>
                                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>{{ $student->user->email ?? 'Not set' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Registration #:</strong></td>
                                        <td>{{ $student->registration_number }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date of Birth:</strong></td>
                                        <td>
                                            @if($student->dob)
                                                {{ $student->dob->format('M d, Y') }}
                                            @else
                                                Not set
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Gender:</strong></td>
                                        <td>
                                            @if($student->gender)
                                                <span class="badge bg-{{ $student->gender === 'male' ? 'primary' : ($student->gender === 'female' ? 'danger' : 'secondary') }}">
                                                    {{ ucfirst($student->gender) }}
                                                </span>
                                            @else
                                                <span class="text-muted">Not set</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Contact Information</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Phone:</strong></td>
                                        <td>{{ $student->phone ?? 'Not set' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address:</strong></td>
                                        <td>{{ $student->address ?? 'Not set' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Account Created:</strong></td>
                                        <td>{{ $student->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Last Updated:</strong></td>
                                        <td>{{ $student->updated_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                @if($student->enrollments->count() > 0)
                    <div class="mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Class Enrollments</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Class</th>
                                                <th>Enrolled Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($student->enrollments as $enrollment)
                                                <tr>
                                                    <td>{{ $enrollment->schoolClass->name ?? 'Not set' }} {{ $enrollment->schoolClass->section ?? 'Not set' }}</td>
                                                    <td>
                                                        @if($enrollment->enrollment_date)
                                                            {{ $enrollment->enrollment_date->format('M d, Y') }}
                                                        @else
                                                            Not set
                                                        @endif
                                                    </td>
                                                    <td><span class="badge bg-success">Active</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($student->fees->count() > 0)
                    <div class="mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Fee Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Amount Due</th>
                                                <th>Amount Paid</th>
                                                <th>Status</th>
                                                <th>Due Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($student->fees as $fee)
                                                <tr>
                                                    <td>${{ number_format($fee->amount_due, 2) }}</td>
                                                    <td>${{ number_format($fee->amount_paid, 2) }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $fee->status === 'paid' ? 'success' : ($fee->status === 'partial' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst($fee->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($fee->due_date)
                                                            {{ \Carbon\Carbon::parse($fee->due_date)->format('M d, Y') }}
                                                        @else
                                                            Not set
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
