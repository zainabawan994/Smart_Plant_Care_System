<?php
// login.php
require 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $stmt = $conn->prepare('SELECT id, password, role FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hash, $role);
        $stmt->fetch();
        if (password_verify($password, $hash)) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            echo 'success';
            exit;
        }
    }
    echo 'Invalid username or password.';
}
?>
