<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: ../login.php");
    exit();
}

require_once "../config/database.php";
require_once "../Controller/StudentController.php";

$controller = new StudentController($conn);
$studentModel = $controller->getStudentModel();

$controller->updateStudent();

$id = $_GET['id'] ?? null;
$student = $studentModel->getStudentById($id);

if (!$student) {
    header("Location: student.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student - PSP Student Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="student.php">PSP Student Portal</a>
            <div class="d-flex">
                <a href="student.php" class="btn btn-outline-light btn-sm">Dashboard</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-warning text-dark py-3 rounded-top-3">
                        <h5 class="mb-0 fw-bold">Update Student Details</h5>
                        <small class="text-muted">Modify student information below</small>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="">
                            <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($student['name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">NRIC Number</label>
                                <input type="text" name="ic" class="form-control" value="<?php echo htmlspecialchars($student['ic']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Program / Course</label>
                                <input type="text" name="program" class="form-control" value="<?php echo htmlspecialchars($student['program']); ?>" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Marks</label>
                                <input type="number" name="marks" class="form-control" value="<?php echo $student['marks']; ?>" min="0" max="100" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="student.php" class="btn btn-outline-secondary px-4">Back</a>
                                <button type="submit" name="update" class="btn btn-warning px-4 fw-bold text-dark">Update Record</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>