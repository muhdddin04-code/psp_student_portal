<?php
session_start();
require_once "config/database.php";
require_once "Model/Student.php";

$studentModel = new Student($conn);
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ic = $_POST['ic'];
    $password = $_POST['password'];
    
    $user = $studentModel->login($ic);
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['student_id'] = $user['id'];
        header("Location: View/student.php");
        exit();
    } else {
        $error = "Invalid password or ID number!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-primary text-white text-center py-3 rounded-top-3">
                        <h4 class="mb-0 fw-bold">PSP Student Portal</h4>
                        <small class="text-white-50">Please login to your account</small>
                    </div>
                    <div class="card-body p-4">
                        <?php if($error != ""): ?>
                            <div class="alert alert-danger text-center p-2 mb-3" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="" autocomplete="off">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">NRIC (Identity Card)</label>
                                <input type="text" name="ic" class="form-control" placeholder="e.g. 010101-01-0101" autocomplete="off" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter password" autocomplete="new-password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>