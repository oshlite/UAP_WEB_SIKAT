<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../koneksi.php');

$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header("Location: ../login.php");
    exit;
}

// Statistik dari database menggunakan PDO
$totalTamu = $pdo->query("SELECT COUNT(*) FROM tamu")->fetchColumn();
$totalLuarProvinsi = $pdo->query("SELECT COUNT(*) FROM tamu WHERE luar_provinsi = 'Ya'")->fetchColumn();
$totalPetugas = $pdo->query("SELECT COUNT(*) FROM petugas")->fetchColumn();
$totalTamuPrio = $pdo->query("SELECT COUNT(*) FROM tamu_prio")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | SIKAT</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <?php include '../partials/sidebar.php'; ?>

        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold text-gray-700 mb-6">Dashboard Admin</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white shadow rounded-xl p-4 text-center">
                    <p class="text-gray-600">Total Tamu</p>
                    <h3 class="text-2xl font-bold text-blue-600"><?= $totalTamu ?></h3>
                </div>
                <div class="bg-white shadow rounded-xl p-4 text-center">
                    <p class="text-gray-600">Tamu Luar Provinsi</p>
                    <h3 class="text-2xl font-bold text-green-600"><?= $totalLuarProvinsi ?></h3>
                </div>
                <div class="bg-white shadow rounded-xl p-4 text-center">
                    <p class="text-gray-600">Total Petugas</p>
                    <h3 class="text-2xl font-bold text-purple-600"><?= $totalPetugas ?></h3>
                </div>
                <div class="bg-white shadow rounded-xl p-4 text-center">
                    <p class="text-gray-600">Tamu Prioritas</p>
                    <h3 class="text-2xl font-bold text-red-600"><?= $totalTamuPrio ?></h3>
                </div>
            </div>

            <!-- Tambahan konten dashboard di bawah sini jika dibutuhkan -->

        </main>
    </div>
</body>
</html>
