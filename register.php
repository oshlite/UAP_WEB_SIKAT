<?php
require 'koneksi.php';

$username = 'admin';
$password = password_hash('12345678', PASSWORD_DEFAULT);
$role = 'admin';

$stmt = $pdo->prepare("INSERT INTO users (username, password, role, is_active, created_at, updated_at) VALUES (?, ?, ?, 1, NOW(), NOW())");
$stmt->execute([$username, $password, $role]);

echo "User berhasil dibuat!";
?>
