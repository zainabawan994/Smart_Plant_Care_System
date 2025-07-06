<?php
// redirect.php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header('Location: login.html');
    exit();
}
if ($_SESSION['role'] === 'client') {
    header('Location: client_portal.php');
    exit();
} elseif ($_SESSION['role'] === 'expert') {
    header('Location: expert_portal.php');
    exit();
}
// Default fallback
header('Location: index.html');
exit();
?>
