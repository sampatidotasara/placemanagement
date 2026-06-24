<?php

include 'auth.php';
include 'db.php';

/* ==========================
   BASIC STATS
========================== */

$totalCompanies = $conn->query(
"SELECT COUNT(*) total FROM companies"
)->fetch_assoc()['total'];

$totalApplications = $conn->query(
"SELECT COUNT(*) total FROM applications"
)->fetch_assoc()['total'];

$applied = $conn->query(
"SELECT COUNT(*) total
FROM applications
WHERE status='Applied'"
)->fetch_assoc()['total'];

$oaScheduled = $conn->query(
"SELECT COUNT(*) total
FROM applications
WHERE status='OA Scheduled'"
)->fetch_assoc()['total'];

$oaCleared = $conn->query(
"SELECT COUNT(*) total
FROM applications
WHERE status='OA Cleared'"
)->fetch_assoc()['total'];

$interviewScheduled = $conn->query(
"SELECT COUNT(*) total
FROM applications
WHERE status='Interview Scheduled'"
)->fetch_assoc()['total'];

$hrInterview = $conn->query(
"SELECT COUNT(*) total
FROM applications
WHERE status='HR Interview'"
)->fetch_assoc()['total'];

$totalSelected = $conn->query(
"SELECT COUNT(*) total
FROM applications
WHERE status='Selected'"
)->fetch_assoc()['total'];

$totalRejected = $conn->query(
"SELECT COUNT(*) total
FROM applications
WHERE status='Rejected'"
)->fetch_assoc()['total'];

$offerAccepted = $conn->query(
"SELECT COUNT(*) total
FROM applications
WHERE status='Offer Accepted'"
)->fetch_assoc()['total'];

$successRate = 0;

if($totalApplications > 0){
    $successRate = round(
        ($totalSelected / $totalApplications) * 100,
        2
    );
}

/* PACKAGE ANALYTICS */

$highestPackage = $conn->query(
"SELECT MAX(package_lpa) max_package
FROM companies"
)->fetch_assoc()['max_package'];

$averagePackage = $conn->query(
"SELECT ROUND(AVG(package_lpa),2) avg_package
FROM companies"
)->fetch_assoc()['avg_package'];

$recentApplications = $conn->query(

"SELECT
a.student_name,
c.company_name,
a.status,
a.applied_date

FROM applications a

JOIN companies c
ON a.company_id = c.id

ORDER BY a.id DESC

LIMIT 5"

);

$deadlines = $conn->query(

"SELECT
company_name,
job_role,
deadline

FROM companies

WHERE deadline >= CURDATE()

ORDER BY deadline ASC

LIMIT 5"

);

$selectedStudents = $conn->query(

"SELECT
a.student_name,
c.company_name,
a.applied_date

FROM applications a

JOIN companies c
ON a.company_id = c.id

WHERE a.status='Selected'

ORDER BY a.id DESC

LIMIT 5"

);

$rejectedStudents = $conn->query(

"SELECT
a.student_name,
c.company_name,
a.applied_date

FROM applications a

JOIN companies c
ON a.company_id = c.id

WHERE a.status='Rejected'

ORDER BY a.id DESC

LIMIT 5"

);
?>
<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Placement Tracker Dashboard</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* Modern Dashboard Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f0f2f5;
        display: flex;
        min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
        width: 260px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px 0;
        height: 100vh;
        position: fixed;
        overflow-y: auto;
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .sidebar h2 {
        padding: 0 20px 30px 20px;
        font-size: 22px;
        font-weight: 700;
        border-bottom: 1px solid rgba(255,255,255,0.2);
        margin-bottom: 20px;
        letter-spacing: 1px;
    }

    .sidebar a {
        display: flex;
        align-items: center;
        padding: 12px 25px;
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        transition: all 0.3s ease;
        margin: 3px 10px;
        border-radius: 8px;
        font-weight: 500;
    }

    .sidebar a i {
        margin-right: 12px;
        font-size: 20px;
        width: 24px;
    }

    .sidebar a:hover {
        background: rgba(255,255,255,0.2);
        color: white;
        transform: translateX(5px);
    }

    .sidebar a.active {
        background: rgba(255,255,255,0.25);
        color: white;
    }

    /* Main Content */
    .main-content {
        margin-left: 260px;
        flex: 1;
        padding: 25px 30px;
        background: #f0f2f5;
        min-height: 100vh;
        width: calc(100% - 260px);
    }

    /* Topbar */
    .topbar {
        background: white;
        padding: 20px 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .topbar h3 {
        margin: 0;
        font-weight: 700;
        color: #333;
        font-size: 24px;
    }

    .topbar h3 i {
        color: #667eea;
        margin-right: 10px;
    }

    .topbar strong {
        color: #667eea;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: white;
        padding: 22px 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        border-left: 5px solid #667eea;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .stat-card h2 {
        font-size: 32px;
        font-weight: 700;
        margin: 0 0 5px 0;
        color: #333;
    }

    .stat-card p {
        margin: 0;
        color: #888;
        font-weight: 500;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card.companies {
        border-left-color: #4facfe;
    }
    .stat-card.applications {
        border-left-color: #43e97b;
    }
    .stat-card.selected {
        border-left-color: #fa709a;
    }
    .stat-card.rejected {
        border-left-color: #f093fb;
    }
    .stat-card.offers {
        border-left-color: #4facfe;
    }

    /* Card Box */
    .card-box {
        background: white;
        border-radius: 12px;
        padding: 22px 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .card-box:hover {
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    .card-box h4 {
        font-weight: 700;
        color: #333;
        margin-bottom: 18px;
        font-size: 18px;
    }

    .card-box h4 i {
        margin-right: 10px;
        color: #667eea;
    }

    .card-box h5 {
        color: #888;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .card-box h2 {
        font-weight: 700;
        color: #333;
        font-size: 28px;
        margin: 0;
    }

    /* Tables */
    .table {
        margin-bottom: 0;
    }

    .table th {
        background: #f8f9fa;
        color: #555;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e9ecef;
    }

    .table td {
        vertical-align: middle;
        padding: 12px 15px;
    }

    .pipeline-table tr td:first-child {
        font-weight: 500;
        color: #555;
    }

    .pipeline-table tr td:last-child {
        font-weight: 700;
        color: #333;
        text-align: right;
    }

    /* Status Badges */
    .badge-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .badge-status.applied { background: #e3f2fd; color: #1976d2; }
    .badge-status.oa-scheduled { background: #fff3e0; color: #f57c00; }
    .badge-status.oa-cleared { background: #e8f5e9; color: #388e3c; }
    .badge-status.interview-scheduled { background: #fce4ec; color: #c62828; }
    .badge-status.hr-interview { background: #f3e5f5; color: #7b1fa2; }
    .badge-status.selected { background: #e8f5e9; color: #2e7d32; }
    .badge-status.rejected { background: #ffebee; color: #c62828; }
    .badge-status.offer-accepted { background: #e8f5e9; color: #1b5e20; }

    /* Motivation Corner */
    .motivation {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
    }

    .motivation h4 {
        color: white !important;
    }

    .motivation p {
        color: rgba(255,255,255,0.95);
        line-height: 1.8;
        font-size: 15px;
        margin: 0;
    }

    /* Tips List */
    .card-box ul {
        padding-left: 20px;
        margin: 0;
    }

    .card-box ul li {
        padding: 6px 0;
        color: #555;
        font-size: 14px;
        line-height: 1.6;
    }

    .card-box ul li::marker {
        color: #667eea;
    }

    /* Chart Container */
    canvas {
        max-height: 300px;
        width: 100% !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
            transform: translateX(-100%);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .main-content {
            margin-left: 0;
            width: 100%;
            padding: 15px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .topbar {
            flex-direction: column;
            gap: 10px;
            text-align: center;
        }

        .topbar h3 {
            font-size: 20px;
        }

        .stat-card h2 {
            font-size: 24px;
        }

        .mobile-toggle {
            display: block !important;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
            background: #667eea;
            color: white;
            border: none;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 20px;
            cursor: pointer;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        .sidebar-overlay.active {
            display: block;
        }
    }

    @media (min-width: 769px) {
        .mobile-toggle {
            display: none !important;
        }
        .sidebar-overlay {
            display: none !important;
        }
    }

    .mobile-toggle {
        display: none;
    }

    /* Footer */
    .footer-note {
        background: white;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        color: #888;
        font-size: 14px;
        margin-top: 20px;
    }

    .footer-note strong {
        color: #667eea;
    }
</style>

</head>

<body>

<!-- Mobile Toggle -->
<button class="mobile-toggle" onclick="toggleSidebar()">
    <i class="bi bi-list"></i>
</button>
<div class="sidebar-overlay" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">

    <h2>
        <i class="bi bi-graph-up-arrow"></i> Placement Tracker
    </h2>

    <a href="dashboard.php" class="active">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <a href="companies.php">
        <i class="bi bi-buildings"></i> Companies
    </a>

    <a href="applications.php">
        <i class="bi bi-file-earmark-text"></i> Applications
    </a>

    <a href="selected_students.php">
        <i class="bi bi-check-circle"></i> Selected
    </a>

    <a href="rejected_students.php">
        <i class="bi bi-x-circle"></i> Rejected
    </a>

    <a href="logout.php" style="margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 20px;">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>

</div>

<!-- Main Content -->
<div class="main-content">

    <!-- Topbar -->
    <div class="topbar">
        <h3>
            <i class="bi bi-graph-up"></i> Placement Dashboard
        </h3>
        <div>
            Welcome, <strong><?= $_SESSION['user_name']; ?></strong>
            <span class="badge bg-primary ms-2">
                <i class="bi bi-person-circle"></i>
            </span>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card companies">
            <h2><?= $totalCompanies ?></h2>
            <p><i class="bi bi-buildings me-1"></i> Total Companies</p>
        </div>
        <div class="stat-card applications">
            <h2><?= $totalApplications ?></h2>
            <p><i class="bi bi-file-earmark-text me-1"></i> Applications</p>
        </div>
        <div class="stat-card selected">
            <h2><?= $totalSelected ?></h2>
            <p><i class="bi bi-check-circle me-1"></i> Selected</p>
        </div>
        <div class="stat-card rejected">
            <h2><?= $totalRejected ?></h2>
            <p><i class="bi bi-x-circle me-1"></i> Rejected</p>
        </div>
        <div class="stat-card offers">
            <h2><?= $offerAccepted ?></h2>
            <p><i class="bi bi-award me-1"></i> Offer Accepted</p>
        </div>
    </div>

    <!-- Package Stats -->
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card-box text-center">
                <h5><i class="bi bi-trophy"></i> Highest Package</h5>
                <h2 class="text-success">₹ <?= $highestPackage ?> LPA</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-box text-center">
                <h5><i class="bi bi-bar-chart"></i> Average Package</h5>
                <h2 class="text-primary">₹ <?= $averagePackage ?> LPA</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-box text-center">
                <h5><i class="bi bi-arrow-up-circle"></i> Success Rate</h5>
                <h2 class="text-info"><?= $successRate ?>%</h2>
            </div>
        </div>
    </div>

    <!-- Placement Pipeline -->
    <div class="card-box mt-3">
        <h4><i class="bi bi-diagram-3"></i> Placement Pipeline</h4>
        <div class="table-responsive">
            <table class="table table-hover pipeline-table">
                <thead>
                    <tr>
                        <th>Stage</th>
                        <th class="text-end">Count</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Applied</td><td class="text-end"><span class="badge bg-info"><?= $applied ?></span></td></tr>
                    <tr><td>OA Scheduled</td><td class="text-end"><span class="badge bg-warning"><?= $oaScheduled ?></span></td></tr>
                    <tr><td>OA Cleared</td><td class="text-end"><span class="badge bg-success"><?= $oaCleared ?></span></td></tr>
                    <tr><td>Interview Scheduled</td><td class="text-end"><span class="badge bg-primary"><?= $interviewScheduled ?></span></td></tr>
                    <tr><td>HR Interview</td><td class="text-end"><span class="badge bg-purple"><?= $hrInterview ?></span></td></tr>
                    <tr><td>Selected</td><td class="text-end"><span class="badge bg-success"><?= $totalSelected ?></span></td></tr>
                    <tr><td>Rejected</td><td class="text-end"><span class="badge bg-danger"><?= $totalRejected ?></span></td></tr>
                    <tr><td>Offer Accepted</td><td class="text-end"><span class="badge bg-success"><?= $offerAccepted ?></span></td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-3 mt-2">
        <div class="col-md-6">
            <div class="card-box">
                <h4><i class="bi bi-pie-chart"></i> Placement Status</h4>
                <canvas id="statusChart" height="250"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-box">
                <h4><i class="bi bi-bar-chart-line"></i> Monthly Applications</h4>
                <canvas id="monthlyChart" height="250"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="card-box mt-3">
        <h4><i class="bi bi-clock-history"></i> Recent Applications</h4>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Company</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $recentApplications->fetch_assoc()){ ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($row['student_name']) ?></strong></td>
                        <td><?= htmlspecialchars($row['company_name']) ?></td>
                        <td>
                            <span class="badge-status <?= strtolower(str_replace(' ', '-', $row['status'])) ?>">
                                <?= htmlspecialchars($row['status']) ?>
                            </span>
                        </td>
                        <td><?= date('d M Y', strtotime($row['applied_date'])) ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Deadlines -->
    <div class="card-box mt-3">
        <h4><i class="bi bi-alarm"></i> Upcoming Deadlines</h4>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Role</th>
                        <th>Deadline</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $deadlines->fetch_assoc()){ ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($row['company_name']) ?></strong></td>
                        <td><?= htmlspecialchars($row['job_role']) ?></td>
                        <td>
                            <span class="badge bg-danger">
                                <?= date('d M Y', strtotime($row['deadline'])) ?>
                            </span>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Selected & Rejected -->
    <div class="row g-3 mt-2">
        <div class="col-md-6">
            <div class="card-box">
                <h4 class="text-success"><i class="bi bi-check-circle-fill"></i> Selected Students</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $selectedStudents->fetch_assoc()){ ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($row['student_name']) ?></strong></td>
                                <td><?= htmlspecialchars($row['company_name']) ?></td>
                                <td><?= date('d M Y', strtotime($row['applied_date'])) ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-box">
                <h4 class="text-danger"><i class="bi bi-x-circle-fill"></i> Rejected Students</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $rejectedStudents->fetch_assoc()){ ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($row['student_name']) ?></strong></td>
                                <td><?= htmlspecialchars($row['company_name']) ?></td>
                                <td><?= date('d M Y', strtotime($row['applied_date'])) ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Motivation & Tips -->
    <div class="row g-3 mt-2">
        <div class="col-md-6">
            <div class="card-box motivation">
                <h4><i class="bi bi-rocket-takeoff"></i> Motivation Corner</h4>
                <p>
                    Every rejection is feedback, not failure.<br>
                    Most software engineers receive many rejections before landing their first offer.
                    <br><br>
                    <strong>Keep improving:</strong><br>
                    ✔ DSA &nbsp; ✔ Projects &nbsp; ✔ Communication Skills<br>
                    ✔ Interview Preparation &nbsp; ✔ Resume Quality
                    <br><br>
                    <em>Consistency beats talent when talent does not stay consistent.</em><br>
                    Your next application could be your breakthrough.
                </p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-box">
                <h4><i class="bi bi-lightbulb"></i> Placement Tips</h4>
                <ul>
                    <li>Practice DSA daily on platforms like LeetCode & HackerRank</li>
                    <li>Keep your resume updated and ATS-friendly</li>
                    <li>Apply to multiple companies simultaneously</li>
                    <li>Prepare for common HR interview questions</li>
                    <li>Improve communication and soft skills</li>
                    <li>Maintain GitHub projects for portfolio</li>
                    <li>Network with alumni and industry professionals</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-note">
        <i class="bi bi-code-square"></i>
        <strong>Placement Tracker System</strong> &nbsp;|&nbsp;
        Built with PHP, MySQL, Bootstrap & Chart.js
        <br>
        <small class="text-muted">© <?= date('Y') ?> All Rights Reserved</small>
    </div>

</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Toggle sidebar for mobile
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
}

// Close sidebar when clicking outside
document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const toggle = document.querySelector('.mobile-toggle');
    const overlay = document.querySelector('.sidebar-overlay');
    
    if (!sidebar.contains(event.target) && !toggle.contains(event.target) && window.innerWidth <= 768) {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    }
});

// Initialize Status Chart
const statusCanvas = document.getElementById("statusChart");
if(statusCanvas){
    new Chart(statusCanvas, {
        type: "doughnut",
        data: {
            labels: [
                "Applied",
                "OA Scheduled",
                "OA Cleared",
                "Interview Scheduled",
                "HR Interview",
                "Selected",
                "Rejected",
                "Offer Accepted"
            ],
            datasets: [{
                data: [
                    <?= $applied ?>,
                    <?= $oaScheduled ?>,
                    <?= $oaCleared ?>,
                    <?= $interviewScheduled ?>,
                    <?= $hrInterview ?>,
                    <?= $totalSelected ?>,
                    <?= $totalRejected ?>,
                    <?= $offerAccepted ?>
                ],
                backgroundColor: [
                    '#4facfe',
                    '#f093fb',
                    '#43e97b',
                    '#fa709a',
                    '#667eea',
                    '#2e7d32',
                    '#c62828',
                    '#1b5e20'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                }
            }
        }
    });
}

// Initialize Monthly Chart
const monthlyCanvas = document.getElementById("monthlyChart");
if(monthlyCanvas){
    new Chart(monthlyCanvas, {
        type: "line",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
            datasets: [{
                label: "Applications",
                data: [2, 5, 8, 12, 15, 20],
                fill: true,
                backgroundColor: 'rgba(102, 126, 234, 0.2)',
                borderColor: '#667eea',
                borderWidth: 3,
                tension: 0.4,
                pointBackgroundColor: '#667eea',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}
</script>

</body>
</html>
