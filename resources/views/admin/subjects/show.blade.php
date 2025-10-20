@extends('navbar')

@section('content')
<div class="top-navbar">
    <div class="dashboard-header">
        <h1>Subject Details</h1>
    </div>
</div>

<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">{{ $subject->name }}</h3>
            <p class="text-muted mb-0">Subject Code: {{ $subject->code }}</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.subjects.edit', $subject) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Subject
            </a>
            <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Subjects
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Subject Information -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle text-primary"></i> Subject Information
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-bold text-muted">Subject ID:</td>
                            <td><span class="badge bg-light text-dark">#{{ $subject->id }}</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Subject Name:</td>
                            <td class="fw-semibold">{{ $subject->name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Subject Code:</td>
                            <td><span class="badge bg-info text-white">{{ $subject->code }}</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Created:</td>
                            <td>
                                <div>
                                    <div class="fw-semibold">{{ $subject->created_at->format('M d, Y H:i') }}</div>
                                    <small class="text-muted">{{ $subject->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Last Updated:</td>
                            <td>
                                <div>
                                    <div class="fw-semibold">{{ $subject->updated_at->format('M d, Y H:i') }}</div>
                                    <small class="text-muted">{{ $subject->updated_at->diffForHumans() }}</small>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar text-primary"></i> Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <div class="fw-bold text-primary" style="font-size: 2rem;">
                                    {{ $subject->teachers_count ?? $subject->teachers->count() }}
                                </div>
                                <div class="text-muted">Teachers</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold text-success" style="font-size: 2rem;">
                                {{ $subject->classes_count ?? $subject->classes->count() }}
                            </div>
                            <div class="text-muted">Classes</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Teachers Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chalkboard-teacher text-primary"></i> 
                        Teachers Teaching This Subject
                        <span class="badge bg-primary ms-2">{{ $subject->teachers->count() }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if($subject->teachers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Teacher</th>
                                        <th>Classes</th>
                                        <th>Specialization</th>
                                        <th>Contact</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subject->teachers as $teacher)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle me-3">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $teacher->user->name ?? 'N/A' }}</div>
                                                        <small class="text-muted">
                                                            {{ $teacher->first_name }} {{ $teacher->last_name }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $classesForThisSubject = $teacher->pivot->school_class_id 
                                                        ? \App\Models\SchoolClass::where('id', $teacher->pivot->school_class_id)->get()
                                                        : collect();
                                                @endphp
                                                @if($classesForThisSubject->count() > 0)
                                                    @foreach($classesForThisSubject as $class)
                                                        <span class="badge bg-info me-1">{{ $class->class_name }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">Not assigned</span>
                                                @endif
                                            </td>
                                            <td>{{ $teacher->specialization ?? 'Not specified' }}</td>
                                            <td>
                                                <div>
                                                    <div>{{ $teacher->phone ?? 'Not provided' }}</div>
                                                    <small class="text-muted">{{ $teacher->user->email ?? 'N/A' }}</small>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">No teachers assigned to this subject</h6>
                            <p class="text-muted">Teachers will appear here when they are assigned to teach this subject.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Classes Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-alt text-primary"></i> 
                        Classes Offering This Subject
                        <span class="badge bg-primary ms-2">{{ $subject->classes->count() }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if($subject->classes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Class Name</th>
                                        <th>Teacher</th>
                                        <th>Room</th>
                                        <th>Students</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subject->classes as $class)
                                        <tr>
                                            <td>
                                                <div class="fw-bold">{{ $class->class_name ?? $class->name }}</div>
                                                <small class="text-muted">ID: {{ $class->id }}</small>
                                            </td>
                                            <td>
                                                @if($class->pivot->teacher_id)
                                                    @php
                                                        $teacher = \App\Models\Teacher::find($class->pivot->teacher_id);
                                                    @endphp
                                                    @if($teacher)
                                                        <div>
                                                            <div class="fw-semibold">{{ $teacher->user->name ?? 'N/A' }}</div>
                                                            <small class="text-muted">{{ $teacher->specialization ?? '' }}</small>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">Teacher not found</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">Not assigned</span>
                                                @endif
                                            </td>
                                            <td>{{ $class->room_number ?? 'Not specified' }}</td>
                                            <td>
                                                <span class="badge bg-success">
                                                    {{ $class->students->count() }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">No classes offering this subject</h6>
                            <p class="text-muted">Classes will appear here when this subject is assigned to them.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.content-area {
    padding: 20px;
    background-color: #f8f9fa;
    min-height: calc(100vh - 80px);
}

.top-navbar {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px 0;
    margin-bottom: 30px;
}

.dashboard-header h1 {
    color: white;
    margin: 0;
    font-weight: 600;
    text-align: center;
}

.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    border-radius: 12px 12px 0 0 !important;
    padding: 1rem 1.5rem;
}

.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

.table td {
    border: none;
    padding: 0.75rem;
    vertical-align: middle;
}

.badge {
    border-radius: 20px;
    font-weight: 500;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-group .btn {
    border-radius: 6px;
    margin: 0 2px;
}
</style>
@endsection
