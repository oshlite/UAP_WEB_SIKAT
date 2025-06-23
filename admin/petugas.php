<?php
require_once 'auth.php';              // otentikasi login
require_once '../koneksi.php';        // koneksi PDO => $pdo

// ──────── HAPUS DATA ────────
if (isset($_GET['hapus'])) {
    $pdo->prepare("DELETE FROM petugas WHERE id = ?")->execute([$_GET['hapus']]);
    header("Location: petugas.php"); exit;
}

// ──────── TAMBAH DATA ────────
if (isset($_POST['tambah'])) {
    $stmt = $pdo->prepare("INSERT INTO petugas (nama, kontak) VALUES (?, ?)");
    $stmt->execute([$_POST['nama'], $_POST['kontak']]);
    header("Location: petugas.php"); exit;
}

// ──────── EDIT DATA ────────
if (isset($_POST['edit'])) {
    $stmt = $pdo->prepare("UPDATE petugas SET nama = ?, kontak = ? WHERE id = ?");
    $stmt->execute([$_POST['nama'], $_POST['kontak'], $_POST['id']]);
    header("Location: petugas.php"); exit;
}

// ──────── AMBIL SEMUA DATA ────────
$petugas = $pdo->query("SELECT * FROM petugas ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Petugas - SIKAT</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            gold: '#FFD700', 'gold-dark': '#E5B600', peach: '#FFDAB9'
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
  <?php $currentPage = basename('petugas.php'); ?>
  <?php include 'sidebar.php'; ?>

  <!-- MAIN SECTION -->
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
          <?php foreach ($petugas as $no => $row): ?>
          <tr class="border-b hover:bg-yellow-50">
            <td class="px-4 py-2"><?= $no + 1 ?></td>
            <td class="px-4 py-2"><?= htmlspecialchars($row['nama']) ?></td>
            <td class="px-4 py-2"><?= htmlspecialchars($row['kontak']) ?></td>
            <td class="px-4 py-2">
              <button class="btn-edit text-blue-600 hover:underline"
                      data-id="<?= $row['id'] ?>"
                      data-nama="<?= htmlspecialchars($row['nama'], ENT_QUOTES) ?>"
                      data-kontak="<?= htmlspecialchars($row['kontak'], ENT_QUOTES) ?>">
                Edit
              </button>
              <a href="?hapus=<?= $row['id'] ?>"
                 onclick="return confirm('Yakin ingin hapus?')"
                 class="text-red-600 hover:underline ml-4">Hapus</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<!-- MODAL TAMBAH -->
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

<!-- MODAL EDIT -->
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
// JS Edit Event
document.querySelectorAll('.btn-edit').forEach(btn => {
  btn.addEventListener('click', () => {
    document.getElementById('editId').value = btn.dataset.id;
    document.getElementById('editNama').value = btn.dataset.nama;
    document.getElementById('editKontak').value = btn.dataset.kontak;
    document.getElementById('modalEdit').classList.remove('hidden');
  });
});
</script>
</body>
</html>
