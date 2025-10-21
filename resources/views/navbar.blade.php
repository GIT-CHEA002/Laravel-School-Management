<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Education - School Management Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --info: #4895ef;
            --warning: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --sidebar-width: 250px;
        }
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary), var(--secondary));
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu {
            padding: 15px 0 120px 0; /* Add bottom padding for footer */
        }

        .sidebar-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            transition: all 0.3s;
            cursor: pointer;
            position: relative;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active, .sidebar-menu .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 4px solid var(--success);
        }

        .sidebar-menu a:active {
            transform: translateY(1px);
        }

        /* Ensure active state is properly styled */
        .sidebar-menu .nav-link.active,
        .sidebar-menu a.active {
            background-color: rgba(255, 255, 255, 0.15) !important;
            color: white !important;
            border-left: 4px solid var(--success) !important;
        }

        /* Prevent button from getting stuck in active state */
        .sidebar-menu a:focus {
            outline: none;
            box-shadow: none;
        }

        .sidebar-menu i {
            margin-right: 10px;
            font-size: 18px;
        }

        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
        }

        .top-navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e9ecef;
        }

        .school-logo img {
            border: 2px solid #f8f9fa;
        }

        .notification-icon .btn {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-avatar i {
            font-size: 28px;
            color: var(--primary);
        }

        /* Table styling improvements */
        .table th {
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
            color: #495057;
            font-size: 14px;
            padding: 12px 15px;
        }

        .table td {
            padding: 12px 15px;
            vertical-align: middle;
            border-top: 1px solid #f1f3f4;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.04);
        }

        /* Avatar circle for student/teacher lists */
        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .stats-badge {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        /* Button consistency */
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--secondary);
            border-color: var(--secondary);
        }

        .content-area {
            padding: 30px;
        }

        .dashboard-header {
            margin-bottom: 30px;
        }

        .dashboard-header h1 {
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .dashboard-header p {
            color: #6c757d;
            margin: 0;
        }

        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 25px;
            transition: transform 0.3s;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .stats-number {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stats-label {
            color: #6c757d;
            font-size: 14px;
        }

        /* Student Stats */
        .student-stats {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 30px;
        }

        .student-stats-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .student-details {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .student-detail-card {
            flex: 1;
            padding: 15px;
            border-radius: 8px;
            background-color: #f8f9fa;
        }

        .student-detail-card h5 {
            margin-bottom: 10px;
            font-size: 14px;
            color: #6c757d;
        }

        .student-detail-card .number {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .attendance-section {
            margin-top: 20px;
        }

        .attendance-bars {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }

        .attendance-bar {
            flex: 1;
        }

        .attendance-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .progress {
            height: 8px;
            border-radius: 4px;
        }

        /* Earnings Chart */
        .earnings-chart {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 30px;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .chart-container {
            height: 200px;
            position: relative;
        }

        .chart-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .chart-labels span {
            font-size: 12px;
            color: #6c757d;
        }

        /* Awards Section */
        .awards-section {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 30px;
        }

        .awards-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .award-item {
            padding: 15px 0;
            border-bottom: 1px solid #f1f1f1;
        }

        .award-item:last-child {
            border-bottom: none;
        }

        .award-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .award-description {
            color: #6c757d;
            font-size: 14px;
        }

        /* Attendance Chart */
        .attendance-chart {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 30px;
        }

        .attendance-chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .attendance-legend {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .legend-present {
            background-color: #4cc9f0;
        }

        .legend-absent {
            background-color: #f72585;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                text-align: center;
            }

            .sidebar .menu-text {
                display: none;
            }

            .sidebar-header h3 {
                display: none;
            }

            .sidebar-menu a {
                justify-content: center;
                padding: 15px 10px;
            }

            .sidebar-menu i {
                margin-right: 0;
                font-size: 20px;
            }

            .main-content {
                margin-left: 70px;
            }

            .student-details {
                flex-direction: column;
            }
        }
        /* Fix Laravel pagination arrows (SVGs) */
nav svg {
    height: 16px;
    width: 16px;
}

/* Make sure hidden elements (like "..." separators) stay visible */
nav .hidden {
    display: inline !important;
}

/* Optional: style pagination for better look with Bootstrap */
.pagination {
    margin: 1rem 0;
}

.pagination .page-item.active .page-link {
    background-color: #4361ee;
    border-color: #4361ee;
    color: white;
}

.pagination .page-link {
    color: #4361ee;
}

        /* Sidebar Footer - User Authentication Section */
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 15px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.1);
        }

        /* User Profile Section */
        .user-profile {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .user-info {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .user-avatar {
            margin-right: 12px;
            font-size: 32px;
            color: rgba(255, 255, 255, 0.8);
        }

        .user-details {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-weight: 600;
            color: white;
            font-size: 14px;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 12px;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
            gap: 4px;
        }

        .role-admin {
            background-color: rgba(220, 53, 69, 0.2);
            color: #ff6b6b;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .role-teacher {
            background-color: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .role-student {
            background-color: rgba(13, 202, 240, 0.2);
            color: #0dcaf0;
            border: 1px solid rgba(13, 202, 240, 0.3);
        }

        .user-actions {
            margin-left: 10px;
        }

        .btn-logout {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #ff6b6b;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
        }

        .btn-logout:hover {
            background: rgba(220, 53, 69, 0.3);
            color: white;
            transform: translateY(-1px);
        }

        /* Login Section */
        .login-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .login-content {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .login-icon {
            margin-right: 12px;
            font-size: 28px;
            color: rgba(255, 255, 255, 0.7);
        }

        .login-text {
            flex: 1;
        }

        .login-title {
            font-weight: 600;
            color: white;
            font-size: 14px;
            margin-bottom: 2px;
        }

        .login-subtitle {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.6);
        }

        .login-actions {
            margin-left: 10px;
        }

        .btn-login {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #218838, #1ea080);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar-footer {
                padding: 10px 15px;
            }
            
            .user-name, .login-title {
                font-size: 12px;
            }
            
            .btn-login {
                padding: 6px 12px;
                font-size: 11px;
            }
}

        /* Dropdown active state styling */
        .dropdown-item.active,
        .dropdown-item:active {
            background-color: #4361ee;
            color: white;
        }
        
        .dropdown-item.active:hover,
        .dropdown-item:active:hover {
            background-color: #3651d1;
            color: white;
        }

    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3><img src="{{ url('photo/photo1.jpg') }}" alt="image not found" width="50"> <span class="menu-text">Education</span></h3>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <!-- 1️⃣ Main Dashboard Page -->
                    <li><a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') || request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> <span class="menu-text">Dashboard</span></a></li>
                    
                    <!-- 2️⃣ Students Module -->
                    <li><a href="{{ route('admin.students.index') }}" class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}"><i class="fas fa-users"></i> <span class="menu-text">Students</span></a></li>
                    
                    <!-- 3️⃣ Teachers Module -->
                    <li><a href="{{ route('admin.teachers.index') }}" class="nav-link {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}"><i class="fas fa-chalkboard-teacher"></i> <span class="menu-text">Teachers</span></a></li>
                    
                    <!-- 4️⃣ Classes Module -->
                    <li><a href="{{ route('admin.classes.index') }}" class="nav-link {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}"><i class="fas fa-school"></i> <span class="menu-text">Classes</span></a></li>
                    
                    <!-- 5️⃣ Exams Module -->
                    <li><a href="{{ route('admin.exams.index') }}" class="nav-link {{ request()->routeIs('admin.exams.*') ? 'active' : '' }}"><i class="fas fa-clipboard-list"></i> <span class="menu-text">Exams</span></a></li>
                    
                    <!-- 5.5️⃣ Grades Module -->
                    <li><a href="{{ route('admin.grades.index') }}" class="nav-link {{ request()->routeIs('admin.grades.*') ? 'active' : '' }}"><i class="fas fa-chart-bar"></i> <span class="menu-text">Grades</span></a></li>
                    
                    <!-- 6️⃣ Notices Module -->
                    <li><a href="{{ route('admin.notices.index') }}" class="nav-link {{ request()->routeIs('admin.notices.*') ? 'active' : '' }}"><i class="fas fa-bullhorn"></i> <span class="menu-text">Notices</span></a></li>
                    
                    <!-- 7️⃣ Users & Roles -->
                    <li><a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fas fa-user-tie"></i> <span class="menu-text">Users</span></a></li>
                    
                    <!-- Optional: Profile Page -->
                    <li><a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"><i class="fas fa-user-cog"></i> <span class="menu-text">Profile</span></a></li>
                    
                    <!-- Additional: Subjects -->
                    <li><a href="{{ route('admin.subjects.index') }}" class="nav-link {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}"><i class="fas fa-book"></i> <span class="menu-text">Subjects</span></a></li>
                </ul>
            </div>

            <!-- User Authentication Section -->
            @auth
                <!-- User Profile Section -->
                <div class="sidebar-footer">
                    <div class="user-profile">
                        <div class="user-info">
                            <div class="user-avatar">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div class="user-details">
                                <div class="user-name">{{ Auth::user()->name }}</div>
                                <div class="user-role">
                                    <span class="role-badge role-{{ Auth::user()->role }}">
                                        <i class="fas fa-user-{{ Auth::user()->role === 'admin' ? 'shield' : (Auth::user()->role === 'teacher' ? 'chalkboard-teacher' : 'graduation-cap') }}"></i>
                                        {{ ucfirst(Auth::user()->role) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="user-actions">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline" onsubmit="return confirmLogout()">
                                @csrf
                                <button type="submit" class="btn-logout" title="Logout">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <!-- Login Section -->
                <div class="sidebar-footer">
                    <div class="login-section">
                        <div class="login-content">
                            <div class="login-icon">
                                <i class="fas fa-sign-in-alt"></i>
                            </div>
                            <div class="login-text">
                                <div class="login-title">Admin Login</div>
                                <div class="login-subtitle">Access the dashboard</div>
                            </div>
                        </div>
                        <div class="login-actions">
                            <a href="{{ route('login') }}" class="btn-login">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </div>
                    </div>
                </div>
            @endauth
        </div>


        <!-- Main Content -->
        <div class="main-content">
            @yield("content")


        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Simple navigation link handling
            const navLinks = document.querySelectorAll('.sidebar-menu a');
            
            // Clean up any stuck active states on navigation
            navLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    // Allow the navigation to proceed
                    // The server-side routeIs() will handle the active state
                });
                
                // Remove focus after click to prevent stuck appearance
                link.addEventListener('mouseup', function() {
                    this.blur();
                });
            });
            
            // Mobile responsiveness
            function handleMobileSidebar() {
                if (window.innerWidth <= 768) {
                    // Mobile styles are handled by CSS media queries
                    console.log('Mobile view');
                } else {
                    // Desktop view
                    console.log('Desktop view');
                }
            }
            
            handleMobileSidebar();
            window.addEventListener('resize', handleMobileSidebar);
        });

        // Logout confirmation function
        function confirmLogout() {
            const userRole = '{{ Auth::check() ? Auth::user()->role : "user" }}';
            const userName = '{{ Auth::check() ? Auth::user()->name : "User" }}';
            
            return confirm(`Are you sure you want to logout, ${userName}?\n\nYou are currently logged in as ${userRole}.`);
        }
    </script>
</body>
</html>
