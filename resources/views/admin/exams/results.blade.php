@extends('navbar')

@section('content')
    <div class="top-navbar">
        <div class="dashboard-header">
            <h1>Record Results: {{ $exam->exam_name }}</h1>
        </div>
    </div>

    <div class="content-area">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Exam Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Class:</strong> {{ $exam->schoolClass->class_name }}
                            </div>
                            <div class="col-md-3">
                                <strong>Subject:</strong> {{ $exam->subject->name }}
                            </div>
                            <div class="col-md-3">
                                <strong>Date:</strong> {{ $exam->exam_date ? \Carbon\Carbon::parse($exam->exam_date)->format('M d, Y') : 'Not set' }}
                            </div>
                            <div class="col-md-3">
                                <strong>Max Score:</strong> {{ $exam->max_score }}
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Student Results</h5>
                        <span class="badge bg-info">{{ $students->count() }} students</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.exams.store-results', $exam) }}">
                            @csrf
                            
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Student ID</th>
                                            <th>Score</th>
                                            <th>Percentage</th>
                                            <th>Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $student)
                                            @php
                                                $existingGrade = $exam->grades->where('student_id', $student->id)->first();
                                                $currentScore = $existingGrade ? $existingGrade->score : '';
                                            @endphp
                                            <tr>
                                                <td>
                                                    {{ $student->first_name }} {{ $student->last_name }}
                                                    <input type="hidden" name="grades[{{ $loop->index }}][student_id]" value="{{ $student->id }}">
                                                </td>
                                                <td>{{ $student->student_code ?? 'N/A' }}</td>
                                                <td>
                                                    <input type="number" 
                                                           name="grades[{{ $loop->index }}][score]" 
                                                           value="{{ old('grades.'.$loop->index.'.score', $currentScore) }}"
                                                           min="0" 
                                                           max="{{ $exam->max_score }}"
                                                           class="form-control score-input" 
                                                           style="width: 100px;"
                                                           oninput="calculateGrade(this, {{ $exam->max_score }})">
                                                </td>
                                                <td>
                                                    <span class="percentage-display">-</span>%
                                                </td>
                                                <td>
                                                    <span class="grade-display badge bg-secondary">-</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @error('grades')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('admin.exams.show', $exam) }}" class="btn btn-secondary">Back to Exam</a>
                                <button type="submit" class="btn btn-primary" onclick="return confirm('Save all exam results?')">Save Results</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function calculateGrade(input, maxScore) {
            const row = input.closest('tr');
            const score = parseFloat(input.value) || 0;
            const percentage = maxScore > 0 ? Math.round((score / maxScore) * 100 * 10) / 10 : 0;
            
            // Update percentage display
            const percentageDisplay = row.querySelector('.percentage-display');
            percentageDisplay.textContent = percentage.toFixed(1);
            
            // Calculate and display grade
            const gradeDisplay = row.querySelector('.grade-display');
            let letterGrade = '';
            let gradeClass = 'bg-secondary';
            
            if (score === '' || isNaN(score)) {
                letterGrade = '-';
                gradeClass = 'bg-secondary';
            } else if (percentage >= 90) {
                letterGrade = 'A+';
                gradeClass = 'bg-success';
            } else if (percentage >= 80) {
                letterGrade = 'A';
                gradeClass = 'bg-success';
            } else if (percentage >= 70) {
                letterGrade = 'B';
                gradeClass = 'bg-info';
            } else if (percentage >= 60) {
                letterGrade = 'C';
                gradeClass = 'bg-warning';
            } else if (percentage >= 50) {
                letterGrade = 'D';
                gradeClass = 'bg-warning';
            } else {
                letterGrade = 'F';
                gradeClass = 'bg-danger';
            }
            
            gradeDisplay.textContent = letterGrade;
            gradeDisplay.className = `grade-display badge ${gradeClass}`;
        }

        // Calculate grades on page load for existing scores
        document.addEventListener('DOMContentLoaded', function() {
            const scoreInputs = document.querySelectorAll('.score-input');
            const maxScore = {{ $exam->max_score }};
            
            scoreInputs.forEach(input => {
                calculateGrade(input, maxScore);
            });
        });

        // Validate form before submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const scoreInputs = document.querySelectorAll('.score-input');
            let hasValidScore = false;
            
            scoreInputs.forEach(input => {
                if (input.value !== '' && input.value >= 0) {
                    hasValidScore = true;
                }
            });
            
            if (!hasValidScore) {
                e.preventDefault();
                alert('Please enter at least one student score before saving.');
            }
        });
    </script>

    <style>
        .score-input:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        
        .percentage-display, .grade-display {
            font-weight: bold;
        }
        
        .table td {
            vertical-align: middle;
        }
    </style>
@endsection
