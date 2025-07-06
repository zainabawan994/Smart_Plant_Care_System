<?php
// send_message.php
require 'db_connect.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'client') {
    echo 'Unauthorized.';
    exit;
}
$sender = $_SESSION['username'];
$receiver = 'expert';
$message = trim($_POST['message']);
if ($message === '') {
    echo 'Message cannot be empty.';
    exit;
}
$stmt = $conn->prepare('INSERT INTO messages (sender, receiver, message) VALUES (?, ?, ?)');
$stmt->bind_param('sss', $sender, $receiver, $message);
if ($stmt->execute()) {
    echo 'success';
} else {
    echo 'Failed to send message.';
}
?>
