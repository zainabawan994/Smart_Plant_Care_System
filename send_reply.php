<?php
// send_reply.php
require 'db_connect.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'expert') {
    echo 'Unauthorized.';
    exit;
}
$sender = 'expert';
$receiver = trim($_POST['receiver']);
$message = trim($_POST['message']);
if ($receiver === '' || $message === '') {
    echo 'Receiver and message required.';
    exit;
}
$stmt = $conn->prepare('INSERT INTO messages (sender, receiver, message) VALUES (?, ?, ?)');
$stmt->bind_param('sss', $sender, $receiver, $message);
if ($stmt->execute()) {
    echo 'success';
} else {
    echo 'Failed to send reply.';
}
?>
