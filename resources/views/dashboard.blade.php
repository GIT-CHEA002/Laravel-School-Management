@extends("navbar")
@section("content")
    <div class="top-navbar">
        <div class="search-box">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search...">
                <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
            </div>
        </div>
        <div class="user-actions">
            <button class="btn btn-light me-2"><i class="fas fa-bell"></i></button>
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle me-1"></i> Admin User
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Content Area -->
    <div class="content-area">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <h1>Dashboard</h1>
        </div>

        <!-- Stats Cards -->
        <div class="row">
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-icon" style="background-color: rgba(76, 201, 240, 0.2); color: #4cc9f0;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stats-number">{{ $totalStudents ?? 0}}</div>
                    <div class="stats-label">Students</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-icon" style="background-color: rgba(247, 37, 133, 0.2); color: #f72585;">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stats-number">{{ $totalTeachers ??0 }}</div>
                    <div class="stats-label">Teachers</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-icon" style="background-color: rgba(72, 149, 239, 0.2); color: #4895ef;">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="stats-number">{{ $totalClasses ?? 0}}</div>
                    <div class="stats-label">Classes</div>
                </div>
            </div>
        </div>

        <!-- Student Stats -->
        <div class="student-stats">
            <div class="student-stats-header">
                <h4 class="section-title">Students</h4>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                        data-bs-toggle="dropdown">
                        Grade 7 <i class="fas fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Grade 7</a></li>
                        <li><a class="dropdown-item" href="#">Grade 8</a></li>
                        <li><a class="dropdown-item" href="#">Grade 9</a></li>
                        <li><a class="dropdown-item" href="#">Grade 10</a></li>
                    </ul>
                </div>
            </div>

            <div class="student-details">
    <div class="student-detail-card">
        <h5>Total</h5>
        <div class="number">{{ $totalStudents }}</div>
    </div>

    <div class="student-detail-card">
        <i class="fas fa-female text-danger fs-1"></i>
        <h5>Female</h5>
        <div class="number">{{ $femaleStudents ?? 234 }}</div>
    </div>

    <div class="student-detail-card">
        <i class="fas fa-male text-info fs-1"></i>
        <h5>Male</h5>
        <div class="number">{{ $maleStudents ?? 193 }}</div>
    </div>
</div>

            <div class="attendance-section">
                <h5>Attendance</h5>
                <div class="attendance-bars">
                    <div class="attendance-bar">
                        <div class="attendance-label">
                            <span>Present</span>
                            <span>70%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 70%" aria-valuenow="70"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="attendance-bar">
                        <div class="attendance-label">
                            <span>Absent</span>
                            <span>30%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="30"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Awards Section -->
        <div class="awards-section">
            <div class="awards-header">
                <h4 class="section-title">Student Activities</h4>
            </div>
            <div class="awards-list">
                <div class="award-item">
                    <div class="award-title">Best in Show at Statewide Art Contest</div>
                    <div class="award-description">Aiden Kim created a stunning, mixed-media landscape piece.</div>
                </div>
                <div class="award-item">
                    <div class="award-title">Gold Medal in National Math Olympiad</div>
                    <div class="award-description">Ethan Wong solved complex problems with outstanding skills.</div>
                </div>
                <div class="award-item">
                    <div class="award-title">First Place in Regional Science Fair</div>
                    <div class="award-description">Sophia Martinez presented innovative renewable energy solution.</div>
                </div>
            </div>
        </div>

        <!-- Attendance Chart -->
        <div class="attendance-chart">
            <div class="attendance-chart-header">
                <h4 class="section-title">Attendance</h4>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                        data-bs-toggle="dropdown">
                        Weekly <i class="fas fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Daily</a></li>
                        <li><a class="dropdown-item" href="#">Weekly</a></li>
                        <li><a class="dropdown-item" href="#">Monthly</a></li>
                    </ul>
                </div>
            </div>
            <div class="chart-container">
                <!-- This would be replaced with a real chart in production -->
                <div
                    style="height: 100%; display: flex; align-items: flex-end; justify-content: space-between; padding: 0 20px;">
                    <div style="width: 40px; background-color: #4cc9f0; height: 70%; margin-right: 5px;"></div>
                    <div style="width: 40px; background-color: #f72585; height: 30%; margin-right: 5px;"></div>
                    <div style="width: 40px; background-color: #4cc9f0; height: 80%; margin-right: 5px;"></div>
                    <div style="width: 40px; background-color: #f72585; height: 20%; margin-right: 5px;"></div>
                    <div style="width: 40px; background-color: #4cc9f0; height: 90%; margin-right: 5px;"></div>
                    <div style="width: 40px; background-color: #f72585; height: 10%; margin-right: 5px;"></div>
                    <div style="width: 40px; background-color: #4cc9f0; height: 85%; margin-right: 5px;"></div>
                </div>
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
@endsection
