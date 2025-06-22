<?php
// auth.php  ── dipanggil di setiap halaman yang butuh autentikasi
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
