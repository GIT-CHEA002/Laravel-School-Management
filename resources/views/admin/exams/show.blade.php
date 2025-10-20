@extends('navbar')

@section('content')
    <div class="top-navbar">
        <div class="dashboard-header">
            <h1>{{ $exam->exam_name }}</h1>
        </div>
    </div>

    <div class="content-area">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Exam Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Exam Name:</strong> {{ $exam->exam_name }}</p>
                                <p><strong>Class:</strong> {{ $exam->schoolClass->class_name }}</p>
                                <p><strong>Subject:</strong> {{ $exam->subject->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Date:</strong> {{ $exam->exam_date ? \Carbon\Carbon::parse($exam->exam_date)->format('M d, Y') : 'Not set' }}</p>
                                <p><strong>Maximum Score:</strong> {{ $exam->max_score }}</p>
                                <p><strong>Results Recorded:</strong> {{ $exam->grades->count() }} students</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.exams.edit', $exam) }}" class="btn btn-warning">Edit Exam</a>
                            <a href="{{ route('admin.exams.results', $exam) }}" class="btn btn-success">Record Results</a>
                            <a href="{{ route('admin.exams.index') }}" class="btn btn-secondary">Back to Exams</a>
                        </div>
                    </div>
                </div>

                <!-- Results Section -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Exam Results</h5>
                        <span class="badge bg-info">{{ $exam->grades->count() }} results</span>
                    </div>
                    <div class="card-body">
                        @if($exam->grades->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Student</th>
                                            <th>Score</th>
                                            <th>Percentage</th>
                                            <th>Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($exam->grades as $grade)
                                            @php
                                                $percentage = round(($grade->score / $exam->max_score) * 100, 1);
                                                $letterGrade = '';
                                                if ($percentage >= 90) $letterGrade = 'A+';
                                                elseif ($percentage >= 80) $letterGrade = 'A';
                                                elseif ($percentage >= 70) $letterGrade = 'B';
                                                elseif ($percentage >= 60) $letterGrade = 'C';
                                                elseif ($percentage >= 50) $letterGrade = 'D';
                                                else $letterGrade = 'F';
                                            @endphp
                                            <tr>
                                                <td>{{ $grade->student->first_name }} {{ $grade->student->last_name }}</td>
                                                <td>{{ $grade->score }}/{{ $exam->max_score }}</td>
                                                <td>{{ $percentage }}%</td>
                                                <td>
                                                    <span class="badge 
                                                        @if($percentage >= 60) bg-success
                                                        @elseif($percentage >= 50) bg-warning
                                                        @else bg-danger @endif">
                                                        {{ $letterGrade }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted">No results recorded for this exam yet.</p>
                                <a href="{{ route('admin.exams.results', $exam) }}" class="btn btn-primary">Record Results</a>
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
                        @if($exam->grades->count() > 0)
                            @php
                                $scores = $exam->grades->pluck('score');
                                $averageScore = $scores->avg();
                                $averagePercentage = round(($averageScore / $exam->max_score) * 100, 1);
                                $highestScore = $scores->max();
                                $lowestScore = $scores->min();
                            @endphp
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span>Average Score:</span>
                                    <strong>{{ round($averageScore, 1) }} ({{ $averagePercentage }}%)</strong>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span>Highest Score:</span>
                                    <strong>{{ $highestScore }}</strong>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span>Lowest Score:</span>
                                    <strong>{{ $lowestScore }}</strong>
                                </div>
                            </div>
                        @else
                            <p class="text-muted">No results available yet.</p>
                        @endif
                        
                        @if($studentsWithoutGrades->count() > 0)
                            <hr>
                            <div class="mb-2">
                                <strong>Missing Results:</strong><br>
                                <small class="text-muted">{{ $studentsWithoutGrades->count() }} students without grades</small>
                            </div>
                            <a href="{{ route('admin.exams.results', $exam) }}" class="btn btn-success btn-sm">Complete Results</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
