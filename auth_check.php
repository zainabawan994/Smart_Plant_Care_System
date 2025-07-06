<?php
// auth_check.php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header('Location: login.html');
    exit();
}
?>
