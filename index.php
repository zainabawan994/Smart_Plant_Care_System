<?php
// index.php (acts as the entry point)
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header('Location: login.html');
    exit();
}
header('Location: remainder.html'); // or your main page after login
exit();
