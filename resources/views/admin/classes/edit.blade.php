@extends('navbar')

@section('content')
    <div class="top-navbar">
        <div class="dashboard-header">
            <h1>Edit {{ $schoolClass->class_name }}</h1>
        </div>
    </div>

    <div class="content-area">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Class Information</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.classes.update', $schoolClass) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="class_name" class="form-label">Class Name *</label>
                                <input type="text" class="form-control @error('class_name') is-invalid @enderror" 
                                       id="class_name" name="class_name" value="{{ old('class_name', $schoolClass->class_name) }}" required>
                                @error('class_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="room_number" class="form-label">Room Number</label>
                                <input type="text" class="form-control @error('room_number') is-invalid @enderror" 
                                       id="room_number" name="room_number" value="{{ old('room_number', $schoolClass->room_number) }}">
                                @error('room_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="teacher_id" class="form-label">Class Teacher</label>
                                <select class="form-select @error('teacher_id') is-invalid @enderror" 
                                        id="teacher_id" name="teacher_id">
                                    <option value="">Select a teacher (optional)</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" 
                                            {{ (old('teacher_id', $schoolClass->teacher_id) == $teacher->id) ? 'selected' : '' }}>
                                            {{ $teacher->user->name }} - {{ $teacher->user->email }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('teacher_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Update Class</button>
                                <a href="{{ route('admin.classes.show', $schoolClass) }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6>Current Info</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Class:</strong> {{ $schoolClass->class_name }}</p>
                        <p><strong>Room:</strong> {{ $schoolClass->room_number ?? 'Not set' }}</p>
                        @if($schoolClass->teacher && $schoolClass->teacher->user)
                            <p><strong>Current Teacher:</strong> {{ $schoolClass->teacher->user->name }}</p>
                        @endif
                        <hr>
                        <a href="{{ route('admin.classes.assign-subjects', $schoolClass) }}" class="btn btn-success btn-sm">Manage Subjects</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
