<?php
// get_reminders.php
// Returns all reminders for the current logged-in user (with date and time)
require 'db_connect.php';
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['username'])) {
    echo json_encode([]);
    exit;
}
$username = $_SESSION['username'];
// Adjust query as needed for your reminders table structure
$result = $conn->query("SELECT plant_name, reminder_date, reminder_time FROM reminders WHERE username = '" . $conn->real_escape_string($username) . "'");
$reminders = [];
while ($row = $result->fetch_assoc()) {
    $reminders[] = $row;
}
echo json_encode($reminders);
?>
