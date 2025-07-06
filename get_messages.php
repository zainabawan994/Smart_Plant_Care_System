<?php
// get_messages.php
require 'db_connect.php';
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    echo json_encode([]);
    exit;
}
$username = $_SESSION['username'];
$role = $_SESSION['role'];
if ($role === 'client') {
    // Client: get messages sent by expert to this client or sent by this client
    $stmt = $conn->prepare('SELECT * FROM messages WHERE (sender = ? AND receiver = "expert") OR (sender = "expert" AND receiver = ?) ORDER BY timestamp ASC');
    $stmt->bind_param('ss', $username, $username);
} else {
    // Expert: get all messages (unchanged, or you can filter as needed)
    $stmt = $conn->prepare('SELECT * FROM messages ORDER BY timestamp ASC');
}
$stmt->execute();
$result = $stmt->get_result();
$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}
echo json_encode($messages);
?>
