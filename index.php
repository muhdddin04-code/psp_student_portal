<?php

session_start();

if (isset($_SESSION['student_id'])) {
    header("Location: View/student.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}

?>