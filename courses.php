<?php
require_once 'config.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$message = '';

if (isset($_POST['register_course'])) {
    $course_id = $_POST['course_id'];

    $check = $conn->prepare("SELECT id FROM registrations WHERE student_id = ? AND course_id = ?");
    $check->bind_param("ii", $student_id, $course_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $message = '<div class="alert alert-warning">You are already registered for this course!</div>';
    } else {
        $stmt = $conn->prepare("INSERT INTO registrations (student_id, course_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $student_id, $course_id);
        if ($stmt->execute()) {
            $message = '<div class="alert alert-success">Course registered successfully!</div>';
        } else {
            $message = '<div class="alert alert-danger">Failed to register course!</div>';
        }
    }
}

$courses = $conn->query("SELECT * FROM courses ORDER BY course_code");

$registered = $conn->prepare("SELECT course_id FROM registrations WHERE student_id = ?");
$registered->bind_param("i", $student_id);
$registered->execute();
$registered_result = $registered->get_result();
$registered_courses = [];
while ($row = $registered_result->fetch_assoc()) {
    $registered_courses[] = $row['course_id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">University Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="courses.php">Courses</a></li>
                    <li class="nav-item"><a class="nav-link" href="my_courses.php">My Courses</a></li>
                    <li class="nav-item"><span class="nav-link">Welcome, <?php echo $_SESSION['student_name']; ?></span></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="mb-4">Available Courses</h2>
        <?php echo $message; ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Credits</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($course = $courses->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($course['course_code']); ?></td>
                        <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                        <td><?php echo $course['credits']; ?></td>
                        <td>
                            <?php if(in_array($course['id'], $registered_courses)): ?>
                                <span class="badge bg-success">Registered</span>
                            <?php else: ?>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                    <button type="submit" name="register_course" class="btn btn-primary btn-sm">Register</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>