@extends('navbar')

@section('content')
    <div class="top-navbar">
        <div class="dashboard-header">
            <h1>Edit Exam</h1>
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
                        <form method="POST" action="{{ route('admin.exams.update', $exam) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="exam_name" class="form-label">Exam Name *</label>
                                <input type="text" class="form-control @error('exam_name') is-invalid @enderror" 
                                       id="exam_name" name="exam_name" value="{{ old('exam_name', $exam->exam_name) }}" required>
                                @error('exam_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="class_id" class="form-label">Class *</label>
                                <select class="form-select @error('class_id') is-invalid @enderror" 
                                        id="class_id" name="class_id" required>
                                    <option value="">Select a class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" 
                                            {{ old('class_id', $exam->class_id) == $class->id ? 'selected' : '' }}>
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
                                            {{ old('subject_id', $exam->subject_id) == $subject->id ? 'selected' : '' }}>
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
                                       id="exam_date" name="exam_date" value="{{ old('exam_date', $exam->exam_date) }}" required>
                                @error('exam_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="max_score" class="form-label">Maximum Score *</label>
                                <input type="number" class="form-control @error('max_score') is-invalid @enderror" 
                                       id="max_score" name="max_score" value="{{ old('max_score', $exam->max_score) }}" 
                                       min="1" max="1000" required>
                                @error('max_score')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Update Exam</button>
                                <a href="{{ route('admin.exams.show', $exam) }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6>Current Information</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Exam:</strong> {{ $exam->exam_name }}</p>
                        <p><strong>Class:</strong> {{ $exam->schoolClass->class_name }}</p>
                        <p><strong>Subject:</strong> {{ $exam->subject->name }}</p>
                        <p><strong>Date:</strong> {{ $exam->exam_date ? \Carbon\Carbon::parse($exam->exam_date)->format('M d, Y') : 'Not set' }}</p>
                        <p><strong>Max Score:</strong> {{ $exam->max_score }}</p>
                        <hr>
                        <a href="{{ route('admin.exams.results', $exam) }}" class="btn btn-success btn-sm">Record Results</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
