<?php
// register.php
require 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    if (!$username || !$password || !in_array($role, ['client', 'expert'])) {
        header('Content-Type: text/plain');
        echo 'Invalid input.';
        exit;
    }
    $stmt = $conn->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        header('Content-Type: text/plain');
        echo 'Username already exists.';
        exit;
    }
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare('INSERT INTO users (username, password, role) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $username, $hash, $role);
    if ($stmt->execute()) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        header('Content-Type: text/plain');
        echo 'success';
    } else {
        header('Content-Type: text/plain');
        echo 'Registration failed.';
    }
    $stmt->close();
}
