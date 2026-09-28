<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: ../login.php");
    exit();
}

require_once "../config/database.php";
require_once "../Model/Student.php";

$studentModel = new Student($conn);
$message = "";
$msgType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $student_id = $_SESSION['student_id']; 

    $user = $studentModel->getStudentById($student_id);

    if (password_verify($old_password, $user['password'])) {
        if ($new_password === $confirm_password) {
            if ($studentModel->updatePassword($student_id, $new_password)) {
                $message = "Password successfully updated!";
                $msgType = "success";
            } else {
                $message = "Failed to update password in database.";
                $msgType = "danger";
            }
        } else {
            $message = "New password and confirm password do not match.";
            $msgType = "warning";
        }
    } else {
        $message = "Incorrect old password provided.";
        $msgType = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - PSP Student Portal</title>
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
            <div class="col-md-5 col-lg-4">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-primary text-white py-3 rounded-top-3">
                        <h5 class="mb-0 fw-bold">Change Password</h5>
                        <small class="text-white-50">Secure your account with a new password</small>
                    </div>
                    <div class="card-body p-4">
                        <?php if($message != ""): ?>
                            <div class="alert alert-<?php echo $msgType; ?> text-center p-2 mb-3" role="alert">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Current Password</label>
                                <input type="password" name="old_password" class="form-control" placeholder="Enter current password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">New Password</label>
                                <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Confirm New Password</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Re-enter new password" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="student.php" class="btn btn-outline-secondary px-4">Back</a>
                                <button type="submit" class="btn btn-primary px-4 fw-bold">Save Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>