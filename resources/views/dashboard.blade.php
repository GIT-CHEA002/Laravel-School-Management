@extends("navbar")
@section("content")
<div class="top-navbar">
    <div class="d-flex align-items-center">
        <div class="school-logo me-3">
            <img src="{{ url('photo/photo1.jpg') }}" alt="School Logo" width="40" height="40" class="rounded-circle">
        </div>
        <div>
            <h4 class="mb-0 text-dark">Education Management System</h4>
            <small class="text-muted">Dashboard Overview</small>
        </div>
    </div>

</div>

    <!-- Content Area -->
    <div class="content-area">
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.students.index') }}" style="text-decoration: none;">
                    <div class="stats-card">
                        <div class="stats-icon" style="background-color: rgba(76, 201, 240, 0.2); color: #4cc9f0;">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stats-number">{{ $totalStudents ?? 0 }}</div>
                        <div class="stats-label">Students</div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.teachers.index') }}" style="text-decoration: none;">
                    <div class="stats-card">
                        <div class="stats-icon" style="background-color: rgba(247, 37, 133, 0.2); color: #f72585;">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="stats-number">{{ $totalTeachers ?? 0 }}</div>
                        <div class="stats-label">Teachers</div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.classes.index') }}" style="text-decoration: none;">
                    <div class="stats-card">
                        <div class="stats-icon" style="background-color: rgba(72, 149, 239, 0.2); color: #4895ef;">
                            <i class="fas fa-school"></i>
                        </div>
                        <div class="stats-number">{{ $totalClasses ?? 0 }}</div>
                        <div class="stats-label">Classes</div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.exams.index') }}" style="text-decoration: none;">
                    <div class="stats-card">
                        <div class="stats-icon" style="background-color: rgba(114, 201, 114, 0.2); color: #72c972;">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="stats-number">{{ $examsToday ?? 0 }}</div>
                        <div class="stats-label">Exams Today</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Quick Stats Row -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="stats-card">
                    <div class="stats-icon" style="background-color: rgba(255, 193, 7, 0.2); color: #ffc107;">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div class="stats-number">{{ $noticesCount ?? 0 }}</div>
                    <div class="stats-label">Active Notices</div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="stats-card">
                    <div class="stats-icon" style="background-color: rgba(40, 167, 69, 0.2); color: #28a745;">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="stats-number">{{ $recentStudents ?? 0 }}</div>
                    <div class="stats-label">New Students (7 days)</div>
                </div>
            </div>
        </div>

        <!-- Student Stats -->
        <div class="student-stats">
            <div class="student-stats-header">
                <h4 class="section-title"><i class="fas fa-chart-line me-2"></i>Student Statistics</h4>
                <form method="GET" action="{{ route('admin.dashboard') }}" class="d-inline">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                            data-bs-toggle="dropdown">
                            {{ $selectedClass ? $selectedClass->class_name : 'Select Class' }} <i class="fas fa-caret-down"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ !request('class_id') ? 'active' : '' }}" href="{{ route('admin.dashboard', collect(request()->query())->except('class_id')->toArray()) }}">All Classes</a></li>
                            @foreach($classes ?? [] as $class)
                                <li>
                                    <a class="dropdown-item {{ request('class_id') == $class->id ? 'active' : '' }}"
                                       href="{{ route('admin.dashboard', array_merge(request()->query(), ['class_id' => $class->id])) }}">
                                        {{ $class->class_name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </form>
            </div>

            <div class="student-details">
                <div class="student-detail-card">
                    <h5>Total {{ $selectedClass ? 'in ' . $selectedClass->class_name : '' }}</h5>
                    <div class="number">{{ $selectedClass ? $studentsInClass : $totalStudents }}</div>
                </div>

                <div class="student-detail-card">
                    <i class="fas fa-female text-danger fs-1"></i>
                    <h5>Female</h5>
                    <div class="number">{{ $selectedClass ? $femaleInClass : $femaleStudents }}</div>
                </div>

                <div class="student-detail-card">
                    <i class="fas fa-male text-info fs-1"></i>
                    <h5>Male</h5>
                    <div class="number">{{ $selectedClass ? $maleInClass : $maleStudents }}</div>
                </div>
            </div>

            <div class="attendance-section">
                <h5><i class="fas fa-calendar-check me-2"></i>Today's Attendance</h5>
                <div class="attendance-bars">
                    <div class="attendance-bar">
                        <div class="attendance-label">
                            <span>Present ({{ $presentCount }})</span>
                            <span>{{ $presentPercentage }}%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-info" role="progressbar"
                                style="width: {{ $presentPercentage }}%"
                                aria-valuenow="{{ $presentPercentage }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="attendance-bar">
                        <div class="attendance-label">
                            <span>Absent ({{ $absentCount }})</span>
                            <span>{{ $absentPercentage }}%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-danger" role="progressbar"
                                style="width: {{ $absentPercentage }}%"
                                aria-valuenow="{{ $absentPercentage }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Recent Notices -->
            <div class="col-md-6 mb-4">
                <div class="awards-section">
                    <div class="awards-header">
                        <h4 class="section-title"><i class="fas fa-sticky-note me-2"></i>Recent Notices</h4>
                        <a href="{{ route('admin.notices.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-1"></i>Add Notice
                        </a>
                    </div>
                    <div class="awards-list">
                        @forelse($recentNotices ?? [] as $notice)
                            <div class="award-item">
                                <div class="award-title">{{ $notice->title }}</div>
                                <div class="award-description">
                                    {{ Str::limit($notice->content, 100) }}
                                    <br><small class="text-muted">By {{ $notice->creator->name ?? 'Unknown' }} • {{ $notice->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-3">
                                <p class="text-muted">No notices found.</p>
                                <a href="{{ route('admin.notices.create') }}" class="btn btn-outline-primary btn-sm">Create First Notice</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Enrollment Chart -->
            <div class="col-md-6 mb-4">
                <div class="awards-section">
                    <div class="awards-header">
                        <h4 class="section-title"><i class="fas fa-chart-bar me-2"></i>Enrollment by Class</h4>
                    </div>
                    <div class="chart-container" style="height: 250px; padding: 20px;">
                        @if(!empty($enrollmentData))
                            <div style="display: flex; align-items: flex-end; justify-content: space-around; height: 200px;">
                                @foreach($enrollmentData as $data)
                                    <div style="display: flex; flex-direction: column; align-items: center; flex: 1;">
                                        <div style="width: 50px; background-color: #4cc9f0; height: {{ max(20, ($data['student_count'] * 10)) }}px; margin-bottom: 10px; border-radius: 4px 4px 0 0;"
                                             title="{{ $data['class_name'] }}">
                                        </div>
                                        <small style="font-size: 11px; color: #6c757d; transform: rotate(-45deg);">{{ $data['class_name'] }}</small>
                                        <small style="font-size: 10px; color: #6c757d; margin-top: 5px;">{{ $data['student_count'] }}</small>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted">No enrollment data available.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Chart -->
        <div class="attendance-chart">
            <div class="attendance-chart-header">
                <h4 class="section-title"><i class="fas fa-chart-area me-2"></i>Attendance Trends</h4>
                <form method="GET" action="{{ route('admin.dashboard') }}" class="d-inline">
                    @if(request('class_id'))
                        <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                    @endif
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                            data-bs-toggle="dropdown">
                            {{ ucfirst($period) }} <i class="fas fa-caret-down"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard', array_merge(request()->query(), ['period' => 'daily'])) }}">Daily</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard', array_merge(request()->query(), ['period' => 'weekly'])) }}">Weekly</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard', array_merge(request()->query(), ['period' => 'monthly'])) }}">Monthly</a></li>
                        </ul>
                    </div>
                </form>
            </div>
            <div class="chart-container">
                @if(!empty($chartData) && count($chartData) > 0)
                    <div style="height: 200px; display: flex; align-items: flex-end; justify-content: space-between; padding: 20px;">
                        @foreach($chartData as $data)
                            <div style="display: flex; flex-direction: column; align-items: center; flex: 1;">
                                <div style="display: flex; flex-direction: column; align-items: flex-end; height: 160px; justify-content: flex-end;">
                                    @if($data['present'] > 0 || $data['absent'] > 0)
                                        <div style="width: 40px; background-color: #4cc9f0; height: {{ max(10, $data['present_percentage'] * 1.5) }}px; margin-bottom: 2px; border-radius: 2px 2px 0 0;" title="Present: {{ $data['present'] }}"></div>
                                        <div style="width: 40px; background-color: #f72585; height: {{ max(5, $data['absent_percentage'] * 1.5) }}px; margin-bottom: 5px; border-radius: 0 0 2px 2px;" title="Absent: {{ $data['absent'] }}"></div>
                                    @else
                                        <div style="width: 40px; height: 10px; margin-bottom: 5px; background-color: #e9ecef; border-radius: 2px;" title="No data"></div>
                                    @endif
                                </div>
                                <small style="font-size: 11px; color: #6c757d; margin-top: 5px;">{{ $data['date'] }}</small>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                        <div>
                            <i class="fas fa-chart-area fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No attendance data available for {{ ucfirst($period) }} period.</p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="attendance-legend">
                <div class="legend-item">
                    <div class="legend-color legend-present"></div>
                    <span>Present</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color legend-absent"></div>
                    <span>Absent</span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
