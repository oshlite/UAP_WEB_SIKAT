<?php
session_start();
if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in'] || $_SESSION['user_role'] !== 'pengantin') {
    header('Location: login.php');
    exit();
}
