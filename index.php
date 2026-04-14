
<?php
session_start();

// 1. Protection: If not logged in, send to login page
if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit(); 
} 

$role = $_SESSION['role'];
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .card { border: none; border-radius: 15px; transition: 0.3s; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
        .btn-custom { border-radius: 10px; padding: 12px; font-weight: 600; }
        .navbar-brand { font-weight: bold; letter-spacing: 1px; }
        .welcome-text { font-size: 0.9rem; color: #ced4da; margin-right: 15px; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-4 shadow">
    <div class="container">
        <span class="navbar-brand"><i class="fas fa-university me-2"></i>MUST Portal</span>
        <div class="d-flex align-items-center">
            <span class="welcome-text">Logged in as: <strong><?= ucfirst($username) ?> (<?= ucfirst($role) ?>)</strong></span>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row mb-4 text-center">
        <div class="col">
            <h2 class="display-6 fw-bold text-dark"><?= ($role == 'admin') ? 'Administrative Dashboard' : 'Teacher Portal' ?></h2>
            <p class="text-muted">Welcome back. Select an action below to manage the system.</p>
        </div>
    </div>

    <div class="row g-4 justify-content-center">
        
        <?php if($role == 'admin'): ?>
        <div class="col-md-4">
            <div class="card shadow-sm h-100 p-4 border-top border-primary border-5">
                <div class="text-center mb-3">
                    <i class="fas fa-user-graduate fa-3x text-primary"></i>
                </div>
                <h5 class="text-center">Students</h5>
                <hr>
                <div class="d-grid gap-2">
                    <a href="register_students.php" class="btn btn-primary btn-custom">Register Student</a>
                    <a href="view_students.php" class="btn btn-outline-primary btn-custom">View All Students</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100 p-4 border-top border-warning border-5">
                <div class="text-center mb-3">
                    <i class="fas fa-book fa-3x text-warning"></i>
                </div>
                <h5 class="text-center">Units & Courses</h5>
                <hr>
                <div class="d-grid gap-2">
                    <a href="add_unit.php" class="btn btn-warning btn-custom text-dark">Add New Unit</a>
                    <a href="view_units.php" class="btn btn-outline-warning btn-custom text-dark">Manage Units</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="col-md-4">
            <div class="card shadow-sm h-100 p-4 border-top border-success border-5">
                <div class="text-center mb-3">
                    <i class="fas fa-file-invoice fa-3x text-success"></i>
                </div>
                <h5 class="text-center">Examinations</h5>
                <hr>
                <div class="d-grid gap-2">
                    <a href="enter_marks.php" class="btn btn-success btn-custom">Enter Marks</a>
                    <a href="view_marks.php" class="btn btn-info btn-custom text-white">View Performance</a>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-5">
        <div class="col text-center">
            <div class="p-4 bg-white rounded shadow-sm border">
                <p class="mb-1 text-muted"><strong>Course:</strong> DICT Year 1 - Meru University (Town Campus)</p>
                <p class="mb-0 text-muted"><strong>System Status:</strong> <span class="badge bg-success">Online</span></p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>