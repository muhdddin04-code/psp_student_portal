<?php
class Student {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function login($ic) {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE ic = ?");
        $stmt->bind_param("s", $ic);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getStudentById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getAllStudents() {
        return $this->conn->query("SELECT * FROM students");
    }

    public function addStudent($name, $ic, $program, $marks, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO students (name, ic, program, marks, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $name, $ic, $program, $marks, $hashed_password);
        return $stmt->execute();
    }

    public function updateStudent($id, $name, $ic, $program, $marks) {
        $stmt = $this->conn->prepare("UPDATE students SET name = ?, ic = ?, program = ?, marks = ? WHERE id = ?");
        $stmt->bind_param("sssii", $name, $ic, $program, $marks, $id);
        return $stmt->execute();
    }

    public function deleteStudent($id) {
        $stmt = $this->conn->prepare("DELETE FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function updatePassword($id, $new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE students SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed_password, $id);
        return $stmt->execute();
    }
}
?>