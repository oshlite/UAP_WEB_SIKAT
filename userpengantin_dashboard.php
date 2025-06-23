<?php
include 'protect_user.php';
// Dashboard Pengantin - Konsisten dengan user_*.php
$db = new mysqli('sql210.infinityfree.com','if0_39298307','ROOTSIKAT123','if0_39298307_database_sikatbukutamu');
if($db->connect_error) die('DB Error: '.$db->connect_error);

// Jika ada ?export=1, trigger download export_tamu.php setelah load
if (isset($_GET['export']) && $_GET['export'] == '1') {
  echo "<script>window.onload = function() { window.open('export_tamu.php', '_blank'); };</script>";
}

// Statistik
$tglHariIni = date('Y-m-d');
$totalTamuHariIni = $db->query("SELECT COUNT(*) FROM tamu WHERE DATE(waktu) = '$tglHariIni'")->fetch_row()[0];
$totalTamu = $db->query("SELECT COUNT(*) FROM tamu")->fetch_row()[0];
$totalArea = $db->query("SELECT COUNT(*) FROM area_duduk")->fetch_row()[0];
$areaTersedia = $totalArea; // Tidak ada kolom status, jadi anggap semua tersedia
$totalPetugas = $db->query("SELECT COUNT(*) FROM petugas")->fetch_row()[0];
$petugasAktif = $totalPetugas; // Tidak ada kolom status, jadi anggap semua aktif

// Data tamu per hari (7 hari terakhir)
$hariLabels = [];
$tamuPerHari = [];
$res = $db->query("SELECT DATE(waktu) as tgl, COUNT(*) as jumlah FROM tamu GROUP BY DATE(waktu) ORDER BY tgl DESC LIMIT 7");
$dataHari = [];
while($row = $res->fetch_assoc()) {
  $dataHari[$row['tgl']] = $row['jumlah'];
}
$dates = [];
for ($i = 6; $i >= 0; $i--) {
  $tgl = date('Y-m-d', strtotime("-$i days"));
  $hariLabels[] = date('d M', strtotime($tgl));
  $tamuPerHari[] = isset($dataHari[$tgl]) ? (int)$dataHari[$tgl] : 0;
}

// Daftar tamu terbaru
$tamuTerbaru = [];
$res = $db->query("SELECT t.nama, t.keperluan, t.area, t.waktu FROM tamu t ORDER BY t.waktu DESC LIMIT 5");
while($r = $res->fetch_assoc()) $tamuTerbaru[] = $r;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Pengantin - SIKAT</title>
  <script src="https://cdn.tailwindcss.com/3.4.16"></script>
  <script>
    tailwind.config={theme:{extend:{colors:{primary:'#FFD700',secondary:'#FFDAB9'},borderRadius:{button:'8px'}}}};
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body{font-family:'Poppins',sans-serif;background:#FFFFF8}
    .font-serif{font-family:'Playfair Display',serif}
    .card{background:#fff;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,0.05);overflow:hidden;position:relative}
    .batik-accent{background-image:url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M20 20.5C20 18.0147 22.0147 16 24.5 16C26.9853 16 29 18.0147 29 20.5C29 22.9853 26.9853 25 24.5 25C22.0147 25 20 22.9853 20 20.5ZM11 20.5C11 18.0147 13.0147 16 15.5 16C17.9853 16 20 18.0147 20 20.5C20 22.9853 17.9853 25 15.5 25C13.0147 25 11 22.9853 11 20.5ZM24.5 11C22.0147 11 20 13.0147 20 15.5C20 17.9853 22.0147 20 24.5 20C26.9853 20 29 17.9853 29 15.5C29 13.0147 26.9853 11 24.5 11ZM15.5 11C13.0147 11 11 13.0147 11 15.5C11 17.9853 13.0147 20 15.5 20C17.9853 20 20 17.9853 20 15.5C20 13.0147 17.9853 11 15.5 11Z' fill='%23FFD700' fill-opacity='0.1'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:bottom right}
    .sidebar-item{transition:all .2s ease}
    .sidebar-item:hover{background:rgba(255,218,185,.2)}
    .sidebar-item.active{background:rgba(255,215,0,.1);border-left:3px solid #FFD700}
    table thead th{background:rgba(255,215,0,0.1)}
  </style>
</head>
<body class="flex h-screen bg-gray-50">
  <?php include 'user_sidebar.php'; ?>
  <div class="flex-1 flex flex-col overflow-hidden">
    <header class="bg-white shadow-sm z-10">
      <div class="px-4 py-2 bg-gray-50 flex items-center text-sm">
        <a href="#" class="text-gray-500">Dashboard</a>
        <i class="ri-arrow-right-s-line mx-2 text-gray-400"></i>
        <span class="text-gray-700">Overview</span>
      </div>
    </header>
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
      <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
          <h1 class="text-2xl font-serif font-bold text-gray-800">Dashboard Overview</h1>
          <p class="text-gray-600 mt-1">Selamat datang kembali, Pengantin A & B</p>
        </div>
      </div>
      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="card rounded-md p-6 batik-accent">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-500 mb-1">Total Tamu Hari Ini</p>
              <h3 class="text-2xl font-bold text-gray-800"><?= $totalTamuHariIni ?></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-primary bg-opacity-10 flex items-center justify-center text-primary">
              <div class="w-6 h-6 flex items-center justify-center">
                <i class="ri-user-3-line"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="card rounded-md p-6 batik-accent">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-500 mb-1">Tamu Terdaftar</p>
              <h3 class="text-2xl font-bold text-gray-800"><?= $totalTamu ?></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-500 bg-opacity-10 flex items-center justify-center text-blue-500">
              <div class="w-6 h-6 flex items-center justify-center">
                <i class="ri-group-line"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="card rounded-md p-6 batik-accent">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-500 mb-1">Area Tersedia</p>
              <h3 class="text-2xl font-bold text-gray-800"><?= $areaTersedia ?>/<?= $totalArea ?></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-500 bg-opacity-10 flex items-center justify-center text-green-500">
              <div class="w-6 h-6 flex items-center justify-center">
                <i class="ri-map-pin-line"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="card rounded-md p-6 batik-accent">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-500 mb-1">Petugas Aktif</p>
              <h3 class="text-2xl font-bold text-gray-800"><?= $petugasAktif ?></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-purple-500 bg-opacity-10 flex items-center justify-center text-purple-500">
              <div class="w-6 h-6 flex items-center justify-center">
                <i class="ri-team-line"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Grafik Statistik -->
      <div class="bg-white border border-primary rounded-2xl shadow-xl p-6 mt-6 mb-6">
        <h2 class="text-xl font-serif text-gray-700 mb-4">Grafik Statistik Tamu Hari Ini</h2>
        <canvas id="statistikChart" height="100"></canvas>
      </div>
      <!-- Daftar Tamu Terbaru -->
      <div class="card rounded-md overflow-hidden">
        <div class="p-6 border-b border-gray-100">
          <h3 class="text-lg font-medium text-gray-800">Daftar Tamu Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tamu</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keperluan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Area Duduk</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Kedatangan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
              <?php foreach($tamuTerbaru as $t): ?>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($t['nama']) ?></div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($t['keperluan']) ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($t['area']) ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= date('d M Y, H:i', strtotime($t['waktu'])) ?></td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    Hadir
                  </span>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
  <script>
    // Data PHP ke JS
    const hariLabels = <?= json_encode($hariLabels) ?>;
    const tamuPerHari = <?= json_encode($tamuPerHari) ?>;

    // Chart.js statistik tamu hari ini
    const ctx = document.getElementById('statistikChart').getContext('2d');
    const statistikChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: hariLabels, // label tanggal
        datasets: [{
          label: 'Jumlah Tamu',
          data: tamuPerHari, // data jumlah tamu per hari
          backgroundColor: '#FFD700',
          borderColor: '#E5B600',
          borderWidth: 1,
          borderRadius: 8
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: function(context) {
                return ` ${context.dataset.label}: ${context.raw}`;
              }
            }
          }
        },
        scales: {
          y: { beginAtZero: true, ticks: { precision:0 } }
        }
      }
    });
  </script>
</body>
</html>

