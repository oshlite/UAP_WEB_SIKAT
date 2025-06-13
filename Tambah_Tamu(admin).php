<?php
// ---------- KONEKSI PDO ----------
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

// ---------- SIMPAN DATA BARU ----------
if (isset($_POST['simpan'])) {
    $nama          = $_POST['nama'];
    $keperluan     = $_POST['keperluan'];
    $area          = $_POST['area'];
    $luar_provinsi = $_POST['luar_provinsi'];
    $waktu         = $_POST['waktu'];

    $sql = "INSERT INTO tamu (nama, keperluan, area, luar_provinsi, waktu)
            VALUES (?,?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nama, $keperluan, $area, $luar_provinsi, $waktu]);

    header("Location: DaftarTamu(admin).php");
    exit;
}

// ---------- BATAL ----------
if (isset($_POST['batal'])) {
    header("Location: DaftarTamu(admin).php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Tamu - SIKAT</title>
  <script src="https://cdn.tailwindcss.com/3.4.16"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: { primary: '#FFD700', secondary: '#FFDAB9' },
          borderRadius: { button: '8px' },
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background-color: #FFFAF0; }
    .card { background:white; box-shadow:0 4px 12px rgba(0,0,0,.05); }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4">

  <div class="card w-full max-w-xl p-8 rounded-2xl">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Tambah Tamu</h2>

    <form method="POST" class="grid grid-cols-1 gap-4">
      <!-- Nama -->
      <div>
        <label class="block text-sm font-medium text-gray-700">Nama</label>
        <input type="text" name="nama" required
               class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2" />
      </div>

      <!-- Keperluan -->
      <div>
        <label class="block text-sm font-medium text-gray-700">Keperluan</label>
        <select name="keperluan" required
                class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2">
          <option value="">-- Pilih Keperluan --</option>
          <option value="Keluarga">Keluarga</option>
          <option value="Teman">Teman</option>
          <option value="Rekan">Rekan</option>
        </select>
      </div>

      <!-- Area -->
      <div>
        <label class="block text-sm font-medium text-gray-700">Area</label>
        <select name="area" required
                class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2">
          <option value="">- Pilih Area -</option>
          <option value="Pengantin Pria">Pengantin Pria</option>
          <option value="Pengantin Wanitas">Pengantin Wanita</option>
          <option value="Tamu luar provinsi">Tamu luar provinsi</option>
        </select>
      </div>

      <!-- Luar Provinsi -->
      <div>
        <label class="block text-sm font-medium text-gray-700">Luar Provinsi</label>
        <select name="luar_provinsi" required
                class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2">
          <option value="">- Pilih -</option>
          <option value="Ya">Ya</option>
          <option value="Tidak">Tidak</option>
        </select>
      </div>

      <!-- Waktu -->
      <div>
        <label class="block text-sm font-medium text-gray-700">Waktu</label>
        <input type="datetime-local" name="waktu" required
               class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2" />
      </div>

      <!-- Tombol -->
      <div class="flex justify-between mt-4">
        <button type="submit" name="simpan"
                class="bg-primary hover:bg-yellow-400 text-white font-semibold px-6 py-2 rounded-button">
          Simpan
        </button>
        <button type="submit" name="batal"
                class="text-gray-600 hover:text-black font-semibold px-6 py-2 border border-gray-300 rounded-button">
          Batal
        </button>
      </div>
    </form>
  </div>

</body>
</html>
