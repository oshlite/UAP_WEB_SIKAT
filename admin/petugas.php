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
    mysqli_query($db, "DELETE FROM petugas WHERE id=$id");
    header("Location: petugas.php");
    exit;
}

// Proses Tambah
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $kontak = $_POST['kontak'];
    mysqli_query($db, "INSERT INTO petugas (nama, kontak) VALUES ('$nama', '$kontak')");
    header("Location: petugas.php");
    exit;
}

// Proses Edit
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kontak = $_POST['kontak'];
    mysqli_query($db, "UPDATE petugas SET nama='$nama', kontak='$kontak' WHERE id=$id");
    header("Location: petugas.php");
    exit;
}

$petugas = mysqli_query($db, "SELECT * FROM petugas");
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Petugas - SIKAT</title>
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
      <h1 class="text-2xl font-serif text-gold">Data Petugas</h1>
      <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="bg-gold-dark hover:bg-gold text-white px-4 py-2 rounded-button shadow">+ Tambah Petugas</button>
    </div>
    <div class="bg-white rounded-2xl border border-gold shadow overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-yellow-100">
          <tr>
            <th class="px-4 py-2 text-left">No</th>
            <th class="px-4 py-2 text-left">Nama</th>
            <th class="px-4 py-2 text-left">Kontak</th>
            <th class="px-4 py-2 text-left">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; while ($row = mysqli_fetch_assoc($petugas)) : ?>
          <tr class="border-b hover:bg-yellow-50">
            <td class="px-4 py-2"><?= $no++ ?></td>
            <td class="px-4 py-2"><?= htmlspecialchars($row['nama']) ?></td>
            <td class="px-4 py-2"><?= htmlspecialchars($row['kontak']) ?></td>
            <td class="px-4 py-2">
              <button onclick="editPetugas(<?= $row['id'] ?>, '<?= addslashes($row['nama']) ?>', '<?= addslashes($row['kontak']) ?>')" class="text-blue-600 hover:underline">Edit</button>
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
    <h2 class="text-xl font-semibold text-gray-700 mb-4">Tambah Petugas</h2>
    <input type="text" name="nama" placeholder="Nama Petugas" required class="w-full border px-3 py-2 rounded mb-3" />
    <input type="text" name="kontak" placeholder="Kontak" required class="w-full border px-3 py-2 rounded mb-4" />
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
    <h2 class="text-xl font-semibold text-gray-700 mb-4">Edit Petugas</h2>
    <input type="text" name="nama" id="editNama" required class="w-full border px-3 py-2 rounded mb-3" />
    <input type="text" name="kontak" id="editKontak" required class="w-full border px-3 py-2 rounded mb-4" />
    <div class="text-right">
      <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')" class="mr-3">Batal</button>
      <button name="edit" class="bg-gold-dark hover:bg-gold text-white px-4 py-2 rounded">Update</button>
    </div>
  </form>
</div>

<script>
function editPetugas(id, nama, kontak) {
  document.getElementById('editId').value = id;
  document.getElementById('editNama').value = nama;
  document.getElementById('editKontak').value = kontak;
  document.getElementById('modalEdit').classList.remove('hidden');
}
</script>
</body>
</html>
