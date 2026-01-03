<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Course Registration System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        .feature-box {
            padding: 30px;
            margin: 20px 0;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">University Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <?php if(isset($_SESSION['student_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="courses.php">Courses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="my_courses.php">My Courses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php elseif(isset($_SESSION['admin_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">Admin Panel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1 class="display-3 fw-bold">Welcome to University Portal</h1>
            <p class="lead fs-3">Student Course Registration System</p>
            <div class="mt-5">
                <?php if(!isset($_SESSION['student_id']) && !isset($_SESSION['admin_id'])): ?>
                    <a href="login.php" class="btn btn-light btn-lg me-3">Login</a>
                    <a href="register.php" class="btn btn-outline-light btn-lg">Register Now</a>
                <?php else: ?>
                    <a href="courses.php" class="btn btn-light btn-lg">View Courses</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container my-5">
        <h2 class="text-center mb-5">System Features</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="feature-box bg-light">
                    <h4>📚 Browse Courses</h4>
                    <p>View all available courses with detailed information including course codes, names, and credit values.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box bg-light">
                    <h4>✅ Easy Registration</h4>
                    <p>Register for your desired courses with just a few clicks and manage your academic schedule.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box bg-light">
                    <h4>📊 Track Progress</h4>
                    <p>View your registered courses and monitor your total credit hours in real-time.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <p>&copy; 2024 University Portal. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>