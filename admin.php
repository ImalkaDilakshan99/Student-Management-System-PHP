<?php
require_once 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$message = '';

// Add Course
if (isset($_POST['add_course'])) {
    $course_code = trim($_POST['course_code']);
    $course_name = trim($_POST['course_name']);
    $credits = $_POST['credits'];

    $stmt = $conn->prepare("INSERT INTO courses (course_code, course_name, credits) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $course_code, $course_name, $credits);
    if ($stmt->execute()) {
        $message = '<div class="alert alert-success">Course added successfully!</div>';
    } else {
        $message = '<div class="alert alert-danger">Failed to add course. Course code may already exist.</div>';
    }
}

// Edit Course
if (isset($_POST['edit_course'])) {
    $course_id = $_POST['course_id'];
    $course_code = trim($_POST['course_code']);
    $course_name = trim($_POST['course_name']);
    $credits = $_POST['credits'];

    $stmt = $conn->prepare("UPDATE courses SET course_code = ?, course_name = ?, credits = ? WHERE id = ?");
    $stmt->bind_param("ssii", $course_code, $course_name, $credits, $course_id);
    if ($stmt->execute()) {
        $message = '<div class="alert alert-success">Course updated successfully!</div>';
    } else {
        $message = '<div class="alert alert-danger">Failed to update course.</div>';
    }
}

// Delete Course
if (isset($_GET['delete_course'])) {
    $course_id = $_GET['delete_course'];
    // First delete all registrations for this course
    $conn->query("DELETE FROM registrations WHERE course_id = $course_id");
    // Then delete the course
    $stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
    $stmt->bind_param("i", $course_id);
    if ($stmt->execute()) {
        $message = '<div class="alert alert-success">Course deleted successfully!</div>';
    } else {
        $message = '<div class="alert alert-danger">Failed to delete course.</div>';
    }
}

// Get all courses
$courses = $conn->query("SELECT * FROM courses ORDER BY course_code");

// Get all students and their course count
$students_query = "SELECT s.id, s.name, s.student_id, s.email, COUNT(r.id) as course_count 
                   FROM students s 
                   LEFT JOIN registrations r ON s.id = r.student_id 
                   GROUP BY s.id 
                   ORDER BY s.name";
$students = $conn->query($students_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">University Portal - Admin</a>
            <div class="ms-auto">
                <a class="btn btn-outline-light" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <?php echo $message; ?>

        <ul class="nav nav-tabs mb-4" id="adminTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="courses-tab" data-bs-toggle="tab" data-bs-target="#courses" type="button">
                    Manage Courses
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="students-tab" data-bs-toggle="tab" data-bs-target="#students" type="button">
                    View Students
                </button>
            </li>
        </ul>

        <div class="tab-content" id="adminTabContent">
            <!-- Courses Tab -->
            <div class="tab-pane fade show active" id="courses" role="tabpanel">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5>Add New Course</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST">
                                    <div class="mb-3">
                                        <label for="course_code" class="form-label">Course Code</label>
                                        <input type="text" class="form-control" id="course_code" name="course_code" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="course_name" class="form-label">Course Name</label>
                                        <input type="text" class="form-control" id="course_name" name="course_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="credits" class="form-label">Credits</label>
                                        <input type="number" class="form-control" id="credits" name="credits" min="1" max="10" required>
                                    </div>
                                    <button type="submit" name="add_course" class="btn btn-primary w-100">Add Course</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                <h5>All Courses</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Course Code</th>
                                                <th>Course Name</th>
                                                <th>Credits</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($course = $courses->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($course['course_code']); ?></td>
                                                <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                                                <td><?php echo $course['credits']; ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" 
                                                            data-bs-target="#editModal<?php echo $course['id']; ?>">Edit</button>
                                                    <a href="?delete_course=<?php echo $course['id']; ?>" 
                                                       class="btn btn-sm btn-danger" 
                                                       onclick="return confirm('Are you sure? This will delete all student registrations for this course.')">Delete</a>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editModal<?php echo $course['id']; ?>" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Course</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form method="POST">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Course Code</label>
                                                                    <input type="text" class="form-control" name="course_code" 
                                                                           value="<?php echo htmlspecialchars($course['course_code']); ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Course Name</label>
                                                                    <input type="text" class="form-control" name="course_name" 
                                                                           value="<?php echo htmlspecialchars($course['course_name']); ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Credits</label>
                                                                    <input type="number" class="form-control" name="credits" 
                                                                           value="<?php echo $course['credits']; ?>" min="1" max="10" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" name="edit_course" class="btn btn-primary">Save Changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students Tab -->
            <div class="tab-pane fade" id="students" role="tabpanel">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5>Registered Students</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Courses Registered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($student = $students->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                                        <td><?php echo htmlspecialchars($student['name']); ?></td>
                                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                                        <td><?php echo $student['course_count']; ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>