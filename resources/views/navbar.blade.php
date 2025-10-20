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
            padding: 15px 0;
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
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 4px solid var(--success);
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
                    <li><a href="{{ route('dashboard') }}" class="active"><i class="fas fa-tachometer-alt"></i> <span class="menu-text">Dashboard</span></a></li>
                    <li><a href="{{ route('admin.students.index') }}"><i class="fas fa-users"></i> <span class="menu-text">Students</span></a></li>
                    <li><a href="{{ route('admin.teachers.index') }}"><i class="fas fa-chalkboard-teacher"></i> <span class="menu-text">Teachers</span></a></li>
                    <li><a href="{{ route('admin.users.index') }}"><i class="fas fa-user-tie"></i> <span class="menu-text">Users</span></a></li>
                    <li><a href="{{ route('admin.classes.index') }}"><i class="fas fa-calendar-alt"></i> <span class="menu-text">Classes</span></a></li>
                    <li><a href="#"><i class="fas fa-clipboard-list"></i> <span class="menu-text">Exam</span></a></li>
                    <li><a href="#"><i class="fas fa-bullhorn"></i> <span class="menu-text">Notice</span></a></li>
                </ul>
            </div>
        </div>


        <!-- Main Content -->
        <div class="main-content">
            @yield("content");


        </div>
    </div>

    <script>
        // Simple script to handle sidebar toggle on mobile
        document.addEventListener('DOMContentLoaded', function() {
            // This would be replaced with actual functionality in a real application
            console.log('Dashboard loaded');
        });
    </script>
</body>
</html>
