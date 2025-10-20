@extends('navbar')

@section('content')
    <div class="top-navbar">
        <div class="dashboard-header">
            <h1>Exam Management</h1>
        </div>
    </div>

    <div class="content-area">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>All Exams</h3>
            <a href="{{ route('admin.exams.create') }}" class="btn btn-primary">Schedule New Exam</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Filter Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.exams.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <select name="class_id" class="form-select">
                            <option value="">All Classes</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->class_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="subject_id" class="form-select">
                            <option value="">All Subjects</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_from" class="form-control" placeholder="From Date" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_to" class="form-control" placeholder="To Date" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Exam Name</th>
                        <th>Class</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Max Score</th>
                        <th>Results</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exams as $exam)
                        <tr>
                            <td>{{ $exam->exam_name }}</td>
                            <td>{{ $exam->schoolClass->class_name }}</td>
                            <td>{{ $exam->subject->name }}</td>
                            <td>{{ $exam->exam_date ? \Carbon\Carbon::parse($exam->exam_date)->format('M d, Y') : 'Not set' }}</td>
                            <td>{{ $exam->max_score }}</td>
                            <td>
                                @if($exam->grades->count() > 0)
                                    <span class="badge bg-success">{{ $exam->grades->count() }} recorded</span>
                                @else
                                    <span class="badge bg-warning">No results</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.exams.show', $exam) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('admin.exams.edit', $exam) }}" class="btn btn-sm btn-warning">Edit</a>
                                <a href="{{ route('admin.exams.results', $exam) }}" class="btn btn-sm btn-success">Results</a>
                                <form method="POST" action="{{ route('admin.exams.destroy', $exam) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No exams found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $exams->appends(request()->query())->links() }}
    </div>
@endsection
