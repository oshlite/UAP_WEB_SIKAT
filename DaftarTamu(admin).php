<?php
// Koneksi PDO
$host   = 'localhost';
$db     = 'database_sikatbukutamu';
$user   = 'root';
$pass   = '';
$charset= 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  exit('DB Connection Failed: ' . $e->getMessage());
}

// Simpan perubahan edit
if (isset($_POST['simpan']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $keperluan = $_POST['keperluan'];
    $area = $_POST['area'];
    $luar_provinsi = $_POST['luar_provinsi'];
    $waktu = $_POST['waktu'];

    $sql = "UPDATE tamu SET nama=?, keperluan=?, area=?, luar_provinsi=?, waktu=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nama, $keperluan, $area, $luar_provinsi, $waktu, $id]);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Hapus
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $pdo->prepare("DELETE FROM tamu WHERE id = ?")->execute([$id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Ambil data edit jika ada
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM tamu WHERE id = ?");
    $stmt->execute([$id]);
    $edit_data = $stmt->fetch();
}

// Ambil semua data
$stmt = $pdo->query("SELECT * FROM tamu ORDER BY waktu DESC");
$data = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tamu - SIKAT</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>tailwind.config={theme:{extend:{colors:{primary:'#FFD700',secondary:'#FFDAB9'},borderRadius:{'none':'0px','sm':'4px',DEFAULT:'8px','md':'12px','lg':'16px','xl':'20px','2xl':'24px','3xl':'32px','full':'9999px','button':'8px'}}}}</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.5.0/echarts.min.js"></script>
    <style>
        :where([class^="ri-"])::before { content: "\f3c2"; }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FFFAF0;
        }
        .font-serif {
            font-family: 'Playfair Display', serif;
        }
        .sidebar {
            background-color: white;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }
        .card {
            background-color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.08);
        }
        .batik-accent {
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M20 20.5C20 18.0147 22.0147 16 24.5 16C26.9853 16 29 18.0147 29 20.5C29 22.9853 26.9853 25 24.5 25C22.0147 25 20 22.9853 20 20.5ZM11 20.5C11 18.0147 13.0147 16 15.5 16C17.9853 16 20 18.0147 20 20.5C20 22.9853 17.9853 25 15.5 25C13.0147 25 11 22.9853 11 20.5ZM24.5 11C22.0147 11 20 13.0147 20 15.5C20 17.9853 22.0147 20 24.5 20C26.9853 20 29 17.9853 29 15.5C29 13.0147 26.9853 11 24.5 11ZM15.5 11C13.0147 11 11 13.0147 11 15.5C11 17.9853 13.0147 20 15.5 20C17.9853 20 20 17.9853 20 15.5C20 13.0147 17.9853 11 15.5 11Z' fill='%23FFD700' fill-opacity='0.1'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: bottom right;
        }
        .nav-item {
            transition: all 0.2s ease;
        }
        .nav-item:hover {
            background-color: rgba(255, 215, 0, 0.1);
        }
        .nav-item.active {
            background-color: rgba(255, 215, 0, 0.15);
            border-left: 3px solid #FFD700;
        }
        table thead th {
            background-color: rgba(255, 215, 0, 0.1);
        }
        .custom-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }
        .custom-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .switch-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        .switch-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .switch-slider {
            background-color: #FFD700;
        }
        input:checked + .switch-slider:before {
            transform: translateX(20px);
        }
        input[type="search"]::-webkit-search-decoration,
        input[type="search"]::-webkit-search-cancel-button,
        input[type="search"]::-webkit-search-results-button,
        input[type="search"]::-webkit-search-results-decoration {
            display: none;
        }
        input[type="date"]::-webkit-calendar-picker-indicator {
            background: transparent;
            bottom: 0;
            color: transparent;
            cursor: pointer;
            height: auto;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            width: auto;
        }
    </style>
</head>
<body class="flex min-h-screen">

<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

<!-- Sidebar -->
<aside class="sidebar w-64 h-full flex-shrink-0 hidden md:block overflow-y-auto bg-white shadow-md">
  <div class="p-4 flex items-center justify-center border-b border-gray-100">
    <span class="font-['Pacifico'] text-2xl text-primary">SIKAT</span>
  </div>
  <div class="py-4">
    <div class="px-4 py-2 text-xs text-gray-400 uppercase font-semibold">Menu Utama</div>

    <a href="eoadmin_dashboard.php" class="nav-item flex items-center px-4 py-3 <?= $currentPage == 'eoadmin_dashboard.php' ? 'bg-yellow-100 border-l-4 border-yellow-400 text-gray-900 font-semibold' : 'text-gray-700' ?>">
      <div class="w-6 h-6 flex items-center justify-center mr-3">
        <i class="ri-dashboard-line"></i>
      </div>
      <span>Dashboard</span>
    </a>

    <a href="DaftarTamu(admin).php" class="nav-item flex items-center px-4 py-3 <?= $currentPage == 'DaftarTamu(admin).php' ? 'bg-yellow-100 border-l-4 border-yellow-400 text-gray-900 font-semibold' : 'text-gray-700' ?>">
      <div class="w-6 h-6 flex items-center justify-center mr-3">
        <i class="ri-user-3-line"></i>
      </div>
      <span>Manajemen Tamu</span>
    </a>

    <a href="keperluan.php" class="nav-item flex items-center px-4 py-3 <?= $currentPage == 'keperluan.php' ? 'bg-yellow-100 border-l-4 border-yellow-400 text-gray-900 font-semibold' : 'text-gray-700' ?>">
      <div class="w-6 h-6 flex items-center justify-center mr-3">
        <i class="ri-file-list-3-line"></i>
      </div>
      <span>Keperluan Kunjungan</span>
    </a>

    <a href="area.php" class="nav-item flex items-center px-4 py-3 <?= $currentPage == 'area.php' ? 'bg-yellow-100 border-l-4 border-yellow-400 text-gray-900 font-semibold' : 'text-gray-700' ?>">
      <div class="w-6 h-6 flex items-center justify-center mr-3">
        <i class="ri-map-pin-line"></i>
      </div>
      <span>Area Duduk</span>
    </a>

    <a href="petugas.php" class="nav-item flex items-center px-4 py-3 <?= $currentPage == 'petugas.php' ? 'bg-yellow-100 border-l-4 border-yellow-400 text-gray-900 font-semibold' : 'text-gray-700' ?>">
      <div class="w-6 h-6 flex items-center justify-center mr-3">
        <i class="ri-team-line"></i>
      </div>
      <span>Petugas</span>
    </a>

    <div class="px-4 py-2 mt-4 text-xs text-gray-400 uppercase font-semibold">Pengaturan</div>

    <a href="pengguna.php" class="nav-item flex items-center px-4 py-3 <?= $currentPage == 'pengguna.php' ? 'bg-yellow-100 border-l-4 border-yellow-400 text-gray-900 font-semibold' : 'text-gray-700' ?>">
      <div class="w-6 h-6 flex items-center justify-center mr-3">
        <i class="ri-user-settings-line"></i>
      </div>
      <span>Pengguna</span>
    </a>

    <a href="laporan.php" class="nav-item flex items-center px-4 py-3 <?= $currentPage == 'laporan.php' ? 'bg-yellow-100 border-l-4 border-yellow-400 text-gray-900 font-semibold' : 'text-gray-700' ?>">
      <div class="w-6 h-6 flex items-center justify-center mr-3">
        <i class="ri-file-chart-line"></i>
      </div>
      <span>Laporan</span>
    </a>

    <a href="pengaturan.php" class="nav-item flex items-center px-4 py-3 <?= $currentPage == 'pengaturan.php' ? 'bg-yellow-100 border-l-4 border-yellow-400 text-gray-900 font-semibold' : 'text-gray-700' ?>">
      <div class="w-6 h-6 flex items-center justify-center mr-3">
        <i class="ri-settings-3-line"></i>
      </div>
      <span>Pengaturan</span>
    </a>
  </div>
</aside>

  <!-- Konten utama -->
  <main class="flex-1 p-6">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Daftar Tamu</h2>

    <?php if ($edit_data): ?>
    <form method="POST" class="grid grid-cols-1 gap-4 max-w-xl bg-white p-6 rounded-xl shadow mb-10">
      <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">

      <div>
        <label class="block text-sm font-medium text-gray-700">Nama</label>
        <input type="text" name="nama" required value="<?= htmlspecialchars($edit_data['nama']) ?>" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2"/>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Keperluan</label>
        <select name="keperluan" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
          <option value="">-- Pilih Keperluan --</option>
          <option value="Keluarga" <?= $edit_data['keperluan'] == 'Keluarga' ? 'selected' : '' ?>>Keluarga</option>
          <option value="Teman" <?= $edit_data['keperluan'] == 'Teman' ? 'selected' : '' ?>>Teman</option>
          <option value="Rekan" <?= $edit_data['keperluan'] == 'Rekan' ? 'selected' : '' ?>>Rekan</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Area</label>
        <select name="area" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
          <option value="">- Pilih Area -</option>
          <option value="Lobi" <?= $edit_data['area'] == 'Lobi' ? 'selected' : '' ?>>Lobi</option>
          <option value="Meeting Room" <?= $edit_data['area'] == 'Meeting Room' ? 'selected' : '' ?>>Meeting Room</option>
          <option value="Ruang Tamu" <?= $edit_data['area'] == 'Ruang Tamu' ? 'selected' : '' ?>>Ruang Tamu</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Luar Provinsi</label>
        <select name="luar_provinsi" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
          <option value="">- Pilih -</option>
          <option value="Ya" <?= $edit_data['luar_provinsi'] == 'Ya' ? 'selected' : '' ?>>Ya</option>
          <option value="Tidak" <?= $edit_data['luar_provinsi'] == 'Tidak' ? 'selected' : '' ?>>Tidak</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Waktu</label>
        <input type="datetime-local" name="waktu" required value="<?= date('Y-m-d\TH:i', strtotime($edit_data['waktu'])) ?>" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2"/>
      </div>

      <div class="flex gap-4">
        <button type="submit" name="simpan" class="bg-primary hover:bg-yellow-400 text-white font-semibold px-4 py-2 rounded-button">
          Update
        </button>
        <a href="<?= $_SERVER['PHP_SELF'] ?>" class="text-gray-600 hover:text-black font-semibold px-4 py-2 border border-gray-300 rounded-button">
          Batal
        </a>
      </div>
    </form>
    <?php else: ?>
    <div class="mb-6">
      <a href="tambah_tamu.php" class="bg-primary hover:bg-yellow-400 text-white font-semibold px-4 py-2 rounded-button inline-block">
        + Tambah Tamu
      </a>
    </div>
    <?php endif; ?>

    <table class="w-full mt-4 table-auto border border-gray-200 shadow rounded-xl overflow-hidden">
      <thead class="bg-yellow-100">
        <tr>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">No</th>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Nama</th>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Keperluan</th>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Area</th>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Luar Provinsi</th>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Waktu</th>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; foreach($data as $row): ?>
        <tr class="hover:bg-yellow-50">
          <td class="px-4 py-2"><?= $no++ ?></td>
          <td class="px-4 py-2"><?= htmlspecialchars($row['nama']) ?></td>
          <td class="px-4 py-2"><?= htmlspecialchars($row['keperluan']) ?></td>
          <td class="px-4 py-2"><?= htmlspecialchars($row['area']) ?></td>
          <td class="px-4 py-2"><?= htmlspecialchars($row['luar_provinsi']) ?></td>
          <td class="px-4 py-2"><?= $row['waktu'] ?></td>
          <td class="px-4 py-2 space-x-2">
            <a href="?edit=<?= $row['id'] ?>" class="inline-block bg-orange-400 hover:bg-orange-500 text-white px-3 py-1 rounded-md">Edit</a>
            <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')" class="inline-block bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md">Hapus</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </main>
</body>
</html>
