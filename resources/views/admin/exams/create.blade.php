@extends('navbar')

@section('content')
    <div class="top-navbar">
        <div class="dashboard-header">
            <h1>Schedule New Exam</h1>
        </div>
    </div>

    <div class="content-area">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Exam Information</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.exams.store') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="exam_name" class="form-label">Exam Name *</label>
                                <input type="text" class="form-control @error('exam_name') is-invalid @enderror" 
                                       id="exam_name" name="exam_name" value="{{ old('exam_name') }}" required>
                                @error('exam_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="class_id" class="form-label">Class *</label>
                                <select class="form-select @error('class_id') is-invalid @enderror" 
                                        id="class_id" name="class_id" required onchange="updateSubjects()">
                                    <option value="">Select a class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" 
                                            {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->class_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="subject_id" class="form-label">Subject *</label>
                                <select class="form-select @error('subject_id') is-invalid @enderror" 
                                        id="subject_id" name="subject_id" required>
                                    <option value="">Select a subject</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" 
                                            data-classes="{{ $subject->classes->pluck('id')->toJson() }}"
                                            {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="exam_date" class="form-label">Exam Date *</label>
                                <input type="date" class="form-control @error('exam_date') is-invalid @enderror" 
                                       id="exam_date" name="exam_date" value="{{ old('exam_date') }}" required>
                                @error('exam_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="max_score" class="form-label">Maximum Score *</label>
                                <input type="number" class="form-control @error('max_score') is-invalid @enderror" 
                                       id="max_score" name="max_score" value="{{ old('max_score', 100) }}" 
                                       min="1" max="1000" required>
                                @error('max_score')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Maximum possible score for this exam (default: 100)</div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Schedule Exam</button>
                                <a href="{{ route('admin.exams.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6>Guidelines</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">• Use clear exam names (e.g., "Mid-term Mathematics")</li>
                            <li class="mb-2">• Select the correct class and subject</li>
                            <li class="mb-2">• Set appropriate maximum score</li>
                            <li class="mb-2">• Students' results can be recorded after creating the exam</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateSubjects() {
            const classId = document.getElementById('class_id').value;
            const subjectSelect = document.getElementById('subject_id');
            
            // Reset subject options
            subjectSelect.innerHTML = '<option value="">Select a subject</option>';
            
            if (classId) {
                // Show only subjects assigned to the selected class
                Array.from(subjectSelect.options).forEach(option => {
                    if (option.value) {
                        const classes = JSON.parse(option.dataset.classes || '[]');
                        if (classes.includes(parseInt(classId))) {
                            option.style.display = 'block';
                        } else {
                            option.style.display = 'none';
                        }
                    }
                });
            } else {
                // Show all subjects if no class selected
                Array.from(subjectSelect.options).forEach(option => {
                    option.style.display = 'block';
                });
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', updateSubjects);
    </script>
@endsection
