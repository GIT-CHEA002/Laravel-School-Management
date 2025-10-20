@extends('navbar')

@section('content')
    <div class="top-navbar">
        <div class="dashboard-header">
            <h1>Assign Subjects to {{ $schoolClass->class_name }}</h1>
        </div>
    </div>

    <div class="content-area">
        <div class="row">
            <div class="col-md-8">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h5>Assign Subjects and Teachers</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.classes.store-subjects', $schoolClass) }}">
                            @csrf
                            
                            <div id="subjects-container">
                                @if(old('subjects'))
                                    @foreach(old('subjects') as $index => $subject)
                                        <div class="row mb-3 subject-row">
                                            <div class="col-md-5">
                                                <select name="subjects[{{ $index }}][subject_id]" class="form-select" required>
                                                    <option value="">Select Subject</option>
                                                    @foreach($subjects as $subjectOption)
                                                        <option value="{{ $subjectOption->id }}" 
                                                            {{ $subject['subject_id'] == $subjectOption->id ? 'selected' : '' }}>
                                                            {{ $subjectOption->name }} ({{ $subjectOption->code }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('subjects.'.$index.'.subject_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-5">
                                                <select name="subjects[{{ $index }}][teacher_id]" class="form-select" required>
                                                    <option value="">Select Teacher</option>
                                                    @foreach($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}" 
                                                            {{ $subject['teacher_id'] == $teacher->id ? 'selected' : '' }}>
                                                            {{ $teacher->user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('subjects.'.$index.'.teacher_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger remove-subject">Remove</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    @if($classSubjects->count() > 0)
                                        @foreach($classSubjects as $index => $classSubject)
                                            <div class="row mb-3 subject-row">
                                                <div class="col-md-5">
                                                    <select name="subjects[{{ $index }}][subject_id]" class="form-select" required>
                                                        <option value="">Select Subject</option>
                                                        @foreach($subjects as $subjectOption)
                                                            <option value="{{ $subjectOption->id }}" 
                                                                {{ $classSubject->id == $subjectOption->id ? 'selected' : '' }}>
                                                                {{ $subjectOption->name }} ({{ $subjectOption->code }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5">
                                                    <select name="subjects[{{ $index }}][teacher_id]" class="form-select" required>
                                                        <option value="">Select Teacher</option>
                                                        @foreach($teachers as $teacher)
                                                            <option value="{{ $teacher->id }}" 
                                                                {{ $classSubject->pivot->teacher_id == $teacher->id ? 'selected' : '' }}>
                                                                {{ $teacher->user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger remove-subject">Remove</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="row mb-3 subject-row">
                                            <div class="col-md-5">
                                                <select name="subjects[0][subject_id]" class="form-select" required>
                                                    <option value="">Select Subject</option>
                                                    @foreach($subjects as $subject)
                                                        <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->code }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <select name="subjects[0][teacher_id]" class="form-select" required>
                                                    <option value="">Select Teacher</option>
                                                    @foreach($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger remove-subject">Remove</button>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>

                            <div class="mb-3">
                                <button type="button" id="add-subject" class="btn btn-outline-primary">Add Another Subject</button>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">Save Subjects</button>
                                <a href="{{ route('admin.classes.show', $schoolClass) }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6>Current Class Info</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Class:</strong> {{ $schoolClass->class_name }}</p>
                        <p><strong>Room:</strong> {{ $schoolClass->room_number ?? 'Not set' }}</p>
                        @if($schoolClass->teacher && $schoolClass->teacher->user)
                            <p><strong>Class Teacher:</strong> {{ $schoolClass->teacher->user->name }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let subjectIndex = {{ $classSubjects->count() > 0 ? $classSubjects->count() : 1 }};
            
            document.getElementById('add-subject').addEventListener('click', function() {
                const container = document.getElementById('subjects-container');
                const newRow = document.createElement('div');
                newRow.className = 'row mb-3 subject-row';
                
                newRow.innerHTML = `
                    <div class="col-md-5">
                        <select name="subjects[${subjectIndex}][subject_id]" class="form-select" required>
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <select name="subjects[${subjectIndex}][teacher_id]" class="form-select" required>
                            <option value="">Select Teacher</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-subject">Remove</button>
                    </div>
                `;
                
                container.appendChild(newRow);
                subjectIndex++;
            });

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-subject')) {
                    const row = e.target.closest('.subject-row');
                    if (document.querySelectorAll('.subject-row').length > 1) {
                        row.remove();
                    } else {
                        alert('You must have at least one subject assigned.');
                    }
                }
            });
        });
    </script>
@endsection
