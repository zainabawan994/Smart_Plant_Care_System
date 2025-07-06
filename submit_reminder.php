<?php
// submit_reminder.php
// Handles form submission and saves reminder to the database
include 'db_connect.php';

$success = false;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $username = isset($_SESSION['username']) ? $conn->real_escape_string($_SESSION['username']) : null;
    $plant_name = isset($_POST['plant_name']) ? $conn->real_escape_string($_POST['plant_name']) : '';
    $reminder_date = isset($_POST['reminder_date']) ? $conn->real_escape_string($_POST['reminder_date']) : '';
    $reminder_time = isset($_POST['reminder-time']) ? $conn->real_escape_string($_POST['reminder-time']) : '';
    $notes = isset($_POST['notes']) ? $conn->real_escape_string($_POST['notes']) : '';

    if ($username && $plant_name && $reminder_date && $reminder_time) {
        $sql = "INSERT INTO reminders (username, plant_name, reminder_date, reminder_time, notes) VALUES ('$username', '$plant_name', '$reminder_date', '$reminder_time', '$notes')";
        if ($conn->query($sql) === TRUE) {
            $success = true;
            $message = "Reminder added successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }
    } else {
        $message = "Please fill in all required fields.";
    }
}

$conn->close();

if ($success) {
    echo "<script>alert('Reminder added successfully!'); window.location.href='remainder.html';</script>";
    exit();
} elseif ($message) {
    echo "<script>alert('" . addslashes($message) . "'); window.location.href='remainder.html';</script>";
    exit();
}
?>
