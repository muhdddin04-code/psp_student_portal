<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../Model/Student.php";

class StudentController {
    private $student;

    public function __construct($conn) {
        $this->student = new Student($conn);
    }

    public function getStudentModel() {
        return $this->student;
    }

    public function addStudent() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
            $name = $_POST['name'];
            $ic = $_POST['ic'];
            $program = $_POST['program'];
            $marks = $_POST['marks'];
            $password = $_POST['password'];

            if ($this->student->addStudent($name, $ic, $program, $marks, $password)) {
                header("Location: student.php");
                exit();
            }
        }
    }

    public function updateStudent() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $ic = $_POST['ic'];
            $program = $_POST['program'];
            $marks = $_POST['marks'];

            if ($this->student->updateStudent($id, $name, $ic, $program, $marks)) {
                header("Location: student.php");
                exit();
            }
        }
    }

    public function deleteStudent() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_student'])) {
            $id = $_POST['id'];
            if ($this->student->deleteStudent($id)) {
                header("Location: student.php");
                exit();
            }
        }
    }
}
?>