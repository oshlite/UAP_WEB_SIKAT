<?php
// === KONFIGURASI KONEKSI DATABASE LANGSUNG DI SINI ===
$server = "localhost";
$user = "root";
$password = "";
$nama_database = "database_sikatbukutamu";

$db = mysqli_connect($server, $user, $password, $nama_database);
if (!$db || !$db instanceof mysqli) {
    die("Gagal terhubung ke database: " . mysqli_connect_error());
}

// Proses Hapus
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($db, "DELETE FROM users WHERE id=$id");
    header("Location: pengguna.php");
    exit;
}

// Proses Tambah
if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    mysqli_query($db, "INSERT INTO users (username, password) VALUES ('$username', '$password')");
    header("Location: pengguna.php");
    exit;
}

// Proses Edit
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        mysqli_query($db, "UPDATE users SET username='$username', password='$password' WHERE id=$id");
    } else {
        mysqli_query($db, "UPDATE users SET username='$username' WHERE id=$id");
    }
    header("Location: pengguna.php");
    exit;
}

$pengguna = mysqli_query($db, "SELECT * FROM users");
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengguna - SIKAT</title>
  <script src="https://cdn.tailwindcss.com/3.4.16"></script>
  <script>tailwind.config={theme:{extend:{colors:{primary:'#FFD700'}}}}</script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background-color: #FFFAF0; }
    .nav-item:hover { background-color: rgba(255,215,0,0.1); }
    .nav-item.active { background-color: rgba(255,215,0,0.15); border-left: 3px solid #FFD700; }
  </style>
</head>
<body>
<div class="flex h-screen overflow-hidden">
  <?php include 'sidebar.php'; ?>
  <main class="flex-1 overflow-y-auto p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-xl font-bold text-gray-800">Data Pengguna</h1>
      <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="bg-primary text-white px-4 py-2 rounded-button">
        + Tambah Pengguna
      </button>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-yellow-100">
          <tr>
            <th class="px-4 py-2 text-left">No</th>
            <th class="px-4 py-2 text-left">Username</th>
            <th class="px-4 py-2 text-left">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; while ($row = mysqli_fetch_assoc($pengguna)) : ?>
          <tr class="border-b">
            <td class="px-4 py-2"><?= $no++ ?></td>
            <td class="px-4 py-2"><?= htmlspecialchars($row['username']) ?></td>
            <td class="px-4 py-2">
              <button onclick="editPengguna(<?= $row['id'] ?>, '<?= addslashes($row['username']) ?>')" class="text-blue-500">Edit</button>
              <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin hapus?')" class="text-red-500 ml-2">Hapus</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<!-- Modal Tambah -->
<div id="modalTambah" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
  <form method="POST" class="bg-white p-6 rounded-md w-96">
    <h2 class="text-lg font-semibold mb-4">Tambah Pengguna</h2>
    <input type="text" name="username" placeholder="Username" required class="w-full border px-3 py-2 rounded mb-3" />
    <input type="password" name="password" placeholder="Password" required class="w-full border px-3 py-2 rounded mb-4" />
    <div class="text-right">
      <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="mr-3">Batal</button>
      <button name="tambah" class="bg-primary text-white px-4 py-2 rounded-button">Simpan</button>
    </div>
  </form>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
  <form method="POST" class="bg-white p-6 rounded-md w-96">
    <input type="hidden" name="id" id="editId">
    <h2 class="text-lg font-semibold mb-4">Edit Pengguna</h2>
    <input type="text" name="username" id="editUsername" required class="w-full border px-3 py-2 rounded mb-3" />
    <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="w-full border px-3 py-2 rounded mb-4" />
    <div class="text-right">
      <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')" class="mr-3">Batal</button>
      <button name="edit" class="bg-primary text-white px-4 py-2 rounded-button">Update</button>
    </div>
  </form>
</div>

<script>
function editPengguna(id, username) {
  document.getElementById('editId').value = id;
  document.getElementById('editUsername').value = username;
  document.getElementById('modalEdit').classList.remove('hidden');
}
</script>
</body>
</html>
