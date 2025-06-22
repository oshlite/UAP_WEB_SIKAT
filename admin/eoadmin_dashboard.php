<?php
// Mulai sesi jika belum aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Gunakan koneksi dari file koneksi.php
require_once('../koneksi.php');

// Periksa apakah user sudah login
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header("Location: ../login.php");
    exit;
}

// Query statistik menggunakan PDO
try {
    $totalTamu = $pdo->query("SELECT COUNT(*) FROM tamu")->fetchColumn();
    $totalLuarProvinsi = $pdo->query("SELECT COUNT(*) FROM tamu WHERE luar_provinsi = 'Ya'")->fetchColumn();
    $totalPetugas = $pdo->query("SELECT COUNT(*) FROM petugas")->fetchColumn();
    $totalTamuPrio = $pdo->query("SELECT COUNT(*) FROM tamu_prio")->fetchColumn();
} catch (PDOException $e) {
    die("Error mengambil data statistik: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin | SIKAT</title>

  <!-- Tailwind CSS & Fonts -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            gold: '#FFD700',
            'gold-dark': '#E5B600',
            peach: '#FFDAB9'
          },
          fontFamily: {
            sans: ['Poppins', 'sans-serif'],
            serif: ['Playfair Display', 'serif'],
            script: ['Pacifico', 'cursive']
          }
        }
      }
    }
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Playfair+Display&family=Pacifico&display=swap" rel="stylesheet">

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gradient-to-br from-peach via-white to-gold bg-opacity-30 min-h-screen font-sans">
  <div class="flex min-h-screen">
    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-6">
      <h1 class="text-3xl font-serif text-gold mb-6">Dashboard Admin</h1>

      <!-- Statistik -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white shadow-xl rounded-2xl p-6 text-center border border-gold">
          <p class="text-gray-500 font-medium">Total Tamu</p>
          <h3 class="text-3xl font-bold text-gold-dark mt-2"><?= $totalTamu ?></h3>
        </div>
        <div class="bg-white shadow-xl rounded-2xl p-6 text-center border border-gold">
          <p class="text-gray-500 font-medium">Tamu Luar Provinsi</p>
          <h3 class="text-3xl font-bold text-gold-dark mt-2"><?= $totalLuarProvinsi ?></h3>
        </div>
        <div class="bg-white shadow-xl rounded-2xl p-6 text-center border border-gold">
          <p class="text-gray-500 font-medium">Total Petugas</p>
          <h3 class="text-3xl font-bold text-gold-dark mt-2"><?= $totalPetugas ?></h3>
        </div>
        <div class="bg-white shadow-xl rounded-2xl p-6 text-center border border-gold">
          <p class="text-gray-500 font-medium">Tamu Prioritas</p>
          <h3 class="text-3xl font-bold text-gold-dark mt-2"><?= $totalTamuPrio ?></h3>
        </div>
      </div>

      <!-- Grafik -->
      <div class="bg-white border border-gold rounded-2xl shadow-xl p-6 mt-6">
        <h2 class="text-xl font-serif text-gray-700 mb-4">Grafik Statistik Tamu</h2>
        <canvas id="statistikChart" height="100"></canvas>
      </div>
    </main>
  </div>

  <script>
    const ctx = document.getElementById('statistikChart').getContext('2d');
    const statistikChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Total Tamu', 'Tamu Luar Provinsi', 'Petugas', 'Tamu Prioritas'],
        datasets: [{
          label: 'Jumlah',
          data: [<?= $totalTamu ?>, <?= $totalLuarProvinsi ?>, <?= $totalPetugas ?>, <?= $totalTamuPrio ?>],
          backgroundColor: ['#FFD700', '#FACC15', '#E5B600', '#FBBF24'],
          borderColor: ['#E5B600', '#EAB308', '#D4A100', '#D97706'],
          borderWidth: 1,
          borderRadius: 8
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return ` ${context.dataset.label}: ${context.raw}`;
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              precision: 0
            }
          }
        }
      }
    });
  </script>
</body>
</html>
