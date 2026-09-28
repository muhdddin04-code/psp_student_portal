<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if session is not set
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection and student model
require_once '../config/database.php';
require_once '../Model/Student.php';

$studentModel = new Student($conn); // Menggunakan pembolehubah $conn dari database.php
$student = $studentModel->getStudentById($_SESSION['student_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - PSP Portal</title>
    <!-- Masukkan rujukan Bootstrap CSS mengikut projek asal anda -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Student Dashboard</h4>
                    </div>
                    <div class="card-body text-center">
                        
                        <!-- Paparan Mesej Kejayaan / Ralat Muat Naik -->
                        <?php if (isset($_GET['upload']) && $_GET['upload'] == 'success'): ?>
                            <div class="alert alert-success">Profile picture successfully uploaded!</div>
                        <?php endif; ?>

                        <!-- Paparan Gambar Profil -->
                        <div class="mb-3">
                            <?php if (!empty($student['profile_pic'])): ?>
                                <img src="../uploads/<?php echo htmlspecialchars($student['profile_pic']); ?>" alt="Profile Picture" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/150" alt="Default Profile" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                            <?php endif; ?>
                        </div>

                        <h3>Welcome, <?php echo isset($student['name']) ? htmlspecialchars($student['name']) : 'Student'; ?>!</h3>
                        <p class="text-muted">IC Number: <?php echo isset($student['ic']) ? htmlspecialchars($student['ic']) : '-'; ?></p>
                        <p class="text-muted">Programme: <?php echo isset($student['program']) ? htmlspecialchars($student['program']) : '-'; ?></p>

                        <hr>

                        <!-- Borang Muat Naik Gambar Profil (Mesti ada enctype="multipart/form-data") -->
                        <form action="../Controller/StudentController.php" method="POST" enctype="multipart/form-data" class="text-start mt-4">
                            <div class="mb-3">
                                <label for="profile_pic" class="form-label"><b>Update Profile Picture(.jpg, .jpeg, .png | Max: 2MB):</b></label>
                                <input type="file" class="form-control" id="profile_pic" name="profile_pic" accept=".jpg, .jpeg, .png" required>
                            </div>
                            <button type="submit" name="upload_pic" class="btn btn-success w-100">Upload Picture</button>
                        </form>

                        <div class="mt-4">
                            <a href="logout.php" class="btn btn-danger">Logout</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>