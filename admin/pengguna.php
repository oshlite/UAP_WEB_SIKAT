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
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            gold: '#FFD700',
            'gold-dark': '#E5B600',
            peach: '#FFDAB9',
            primary: '#FFD700'
          },
          fontFamily: {
            sans: ['Poppins', 'sans-serif'],
            script: ['Pacifico', 'cursive']
          },
          borderRadius: {
            button: '8px'
          }
        }
      }
    }
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-peach via-white to-gold bg-opacity-30 font-sans min-h-screen">
<div class="flex min-h-screen">
  <?php include 'sidebar.php'; ?>
  <main class="flex-1 p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-serif text-gold">Data Pengguna</h1>
      <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="bg-gold-dark hover:bg-gold text-white px-4 py-2 rounded-button shadow">+ Tambah Pengguna</button>
    </div>
    <div class="bg-white rounded-2xl border border-gold shadow overflow-x-auto">
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
          <tr class="border-b hover:bg-yellow-50">
            <td class="px-4 py-2"><?= $no++ ?></td>
            <td class="px-4 py-2"><?= htmlspecialchars($row['username']) ?></td>
            <td class="px-4 py-2">
              <button onclick="editPengguna(<?= $row['id'] ?>, '<?= addslashes($row['username']) ?>')" class="text-blue-600 hover:underline">Edit</button>
              <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin hapus?')" class="text-red-600 hover:underline ml-4">Hapus</a>
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
  <form method="POST" class="bg-white p-6 rounded-xl shadow-lg w-96 border border-gold">
    <h2 class="text-xl font-semibold text-gray-700 mb-4">Tambah Pengguna</h2>
    <input type="text" name="username" placeholder="Username" required class="w-full border px-3 py-2 rounded mb-3" />
    <input type="password" name="password" placeholder="Password" required class="w-full border px-3 py-2 rounded mb-4" />
    <div class="text-right">
      <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="mr-3">Batal</button>
      <button name="tambah" class="bg-gold-dark hover:bg-gold text-white px-4 py-2 rounded">Simpan</button>
    </div>
  </form>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
  <form method="POST" class="bg-white p-6 rounded-xl shadow-lg w-96 border border-gold">
    <input type="hidden" name="id" id="editId">
    <h2 class="text-xl font-semibold text-gray-700 mb-4">Edit Pengguna</h2>
    <input type="text" name="username" id="editUsername" required class="w-full border px-3 py-2 rounded mb-3" />
    <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="w-full border px-3 py-2 rounded mb-4" />
    <div class="text-right">
      <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')" class="mr-3">Batal</button>
      <button name="edit" class="bg-gold-dark hover:bg-gold text-white px-4 py-2 rounded">Update</button>
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
