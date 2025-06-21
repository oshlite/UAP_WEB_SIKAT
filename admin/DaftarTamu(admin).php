<?php
/* ---------- KONEKSI DB ---------- */
$pdo = new PDO(
    "mysql:host=localhost;dbname=database_sikatbukutamu;charset=utf8mb4",
    'root','',
    [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]
);

/* ---------- PILIHAN DROP‑DOWN (digunakan utk kategori & keperluan) ---------- */
$keperluans = $pdo->query("SELECT nama FROM keperluan_kunjungan ORDER BY nama")->fetchAll(PDO::FETCH_COLUMN);
$areas      = $pdo->query("SELECT nama_area FROM area_duduk ORDER BY nama_area")->fetchAll(PDO::FETCH_COLUMN);

/* ---------- CRUD TAMU (tabel tamu) ---------- */
if (isset($_POST['simpan']) && isset($_POST['id'])) {
    $pdo->prepare("UPDATE tamu SET nama=?,keperluan=?,area=?,luar_provinsi=?,waktu=? WHERE id=?")
        ->execute([$_POST['nama'],$_POST['keperluan'],$_POST['area'],$_POST['luar_provinsi'],$_POST['waktu'],$_POST['id']]);
    header("Location: ".$_SERVER['PHP_SELF']); exit;
}
if (isset($_GET['hapus'])) {
    $pdo->prepare("DELETE FROM tamu WHERE id=?")->execute([$_GET['hapus']]);
    header("Location: ".$_SERVER['PHP_SELF']); exit;
}
$edit = null;
if (isset($_GET['edit'])) {
    $st=$pdo->prepare("SELECT * FROM tamu WHERE id=?"); $st->execute([$_GET['edit']]); $edit=$st->fetch();
}

/* ---------- CRUD TAMU PRIO (tabel tamu_prio) ---------- */
if (isset($_POST['simpan_prio']) && isset($_POST['id_prio'])) {
    $pdo->prepare("UPDATE tamu_prio SET name=?,kategori=?,waktu=? WHERE id=?")
        ->execute([$_POST['name'],$_POST['kategori'],$_POST['waktu'],$_POST['id_prio']]);
    header("Location: ".$_SERVER['PHP_SELF']); exit;
}
if (isset($_GET['hapus_prio'])) {
    $pdo->prepare("DELETE FROM tamu_prio WHERE id=?")->execute([$_GET['hapus_prio']]);
    header("Location: ".$_SERVER['PHP_SELF']); exit;
}
$editPrio = null;
if (isset($_GET['edit_prio'])) {
    $st=$pdo->prepare("SELECT * FROM tamu_prio WHERE id=?"); $st->execute([$_GET['edit_prio']]); $editPrio=$st->fetch();
}

/* ---------- DATA UNTUK TABEL ---------- */
$data      = $pdo->query("SELECT * FROM tamu ORDER BY waktu DESC")->fetchAll();
$data_prio = $pdo->query("SELECT * FROM tamu_prio ORDER BY waktu DESC")->fetchAll();

$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Tamu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            gold: '#FFD700',
            'gold-dark': '#E5B600',
            peach: '#FFDAB9',
            primary: '#FACC15'
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
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Playfair+Display&family=Pacifico&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-peach via-white to-gold bg-opacity-30 min-h-screen font-sans">
  <div class="flex">
    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-8 space-y-10">
      <h1 class="text-3xl font-serif text-gold mb-4">Manajemen Tamu</h1>

      <?php if ($edit): ?>
      <form method="POST" class="bg-white p-6 rounded-xl shadow-md max-w-xl border border-gold">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Edit Tamu</h2>
        <input type="hidden" name="id" value="<?= $edit['id'] ?>">
        <input type="text" name="nama" value="<?= htmlspecialchars($edit['nama']) ?>" class="w-full mb-3 border rounded px-3 py-2" required>
        <select name="keperluan" required class="w-full mb-3 border rounded px-3 py-2">
          <option value="">-- Pilih Keperluan --</option>
          <?php foreach ($keperluans as $k): ?>
            <option <?= $edit['keperluan']===$k?'selected':'' ?>><?= htmlspecialchars($k) ?></option>
          <?php endforeach; ?>
        </select>
        <select name="area" required class="w-full mb-3 border rounded px-3 py-2">
          <option value="">-- Pilih Area --</option>
          <?php foreach ($areas as $a): ?>
            <option <?= $edit['area']===$a?'selected':'' ?>><?= htmlspecialchars($a) ?></option>
          <?php endforeach; ?>
        </select>
        <select name="luar_provinsi" required class="w-full mb-3 border rounded px-3 py-2">
          <option value="">-- Luar Provinsi? --</option>
          <option <?= $edit['luar_provinsi']==='Ya'?'selected':'' ?>>Ya</option>
          <option <?= $edit['luar_provinsi']==='Tidak'?'selected':'' ?>>Tidak</option>
        </select>
        <input type="datetime-local" name="waktu" value="<?= date('Y-m-d\TH:i',strtotime($edit['waktu'])) ?>" class="w-full mb-3 border rounded px-3 py-2" required>
        <div class="flex justify-between">
          <button name="simpan" class="bg-gold-dark text-white px-4 py-2 rounded hover:bg-gold">Update</button>
          <a href="<?= $_SERVER['PHP_SELF'] ?>" class="bg-gray-300 text-black px-4 py-2 rounded">Batal</a>
        </div>
      </form>
      <?php endif; ?>

      <?php if ($editPrio): ?>
      <form method="POST" class="bg-white p-6 rounded-xl shadow-md max-w-xl border border-gold">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Edit Tamu Prioritas</h2>
        <input type="hidden" name="id_prio" value="<?= $editPrio['id'] ?>">
        <input type="text" name="name" value="<?= htmlspecialchars($editPrio['name']) ?>" class="w-full mb-3 border rounded px-3 py-2" required>
        <select name="kategori" required class="w-full mb-3 border rounded px-3 py-2">
          <option value="">-- Pilih Kategori --</option>
          <?php foreach ($keperluans as $k): ?>
            <option <?= $editPrio['kategori']===$k?'selected':'' ?>><?= htmlspecialchars($k) ?></option>
          <?php endforeach; ?>
        </select>
        <input type="datetime-local" name="waktu" value="<?= date('Y-m-d\TH:i',strtotime($editPrio['waktu'])) ?>" class="w-full mb-3 border rounded px-3 py-2" required>
        <div class="flex justify-between">
          <button name="simpan_prio" class="bg-gold-dark text-white px-4 py-2 rounded hover:bg-gold">Update</button>
          <a href="<?= $_SERVER['PHP_SELF'] ?>" class="bg-gray-300 text-black px-4 py-2 rounded">Batal</a>
        </div>
      </form>
      <?php endif; ?>

      <div class="space-x-4">
        <a href="Tambah_Tamu(admin).php" class="bg-gold-dark text-white px-4 py-2 rounded hover:bg-gold">+ Tambah Tamu</a>
      </div>

      <section>
        <h2 class="text-2xl font-serif text-gray-700 mb-4">Daftar Tamu</h2>
        <div class="overflow-x-auto">
          <table class="w-full table-auto bg-white shadow rounded-xl border border-gold">
            <thead class="bg-yellow-100">
              <tr>
                <th class="px-4 py-2 text-left">No</th>
                <th class="px-4 py-2 text-left">Nama</th>
                <th class="px-4 py-2 text-left">Keperluan</th>
                <th class="px-4 py-2 text-left">Area</th>
                <th class="px-4 py-2 text-left">Luar Provinsi</th>
                <th class="px-4 py-2 text-left">Waktu</th>
                <th class="px-4 py-2 text-left">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no=1; foreach ($data as $r): ?>
              <tr class="hover:bg-yellow-50">
                <td class="px-4 py-2"><?= $no++ ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($r['nama']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($r['keperluan']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($r['area']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($r['luar_provinsi']) ?></td>
                <td class="px-4 py-2"><?= $r['waktu'] ?></td>
                <td class="px-4 py-2 space-x-2">
                  <a href="?edit=<?= $r['id'] ?>" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Edit</a>
                  <a href="?hapus=<?= $r['id'] ?>" onclick="return confirm('Yakin?')" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>

      <section>
        <h2 class="text-2xl font-serif text-gray-700 mt-10 mb-4">Daftar Tamu Prioritas</h2>
        <div class="overflow-x-auto">
          <table class="w-full table-auto bg-white shadow rounded-xl border border-gold">
            <thead class="bg-yellow-100">
              <tr>
                <th class="px-4 py-2 text-left">No</th>
                <th class="px-4 py-2 text-left">Nama</th>
                <th class="px-4 py-2 text-left">Kategori</th>
                <th class="px-4 py-2 text-left">Waktu</th>
                <th class="px-4 py-2 text-left">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no=1; foreach ($data_prio as $r): ?>
              <tr class="hover:bg-yellow-50">
                <td class="px-4 py-2"><?= $no++ ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($r['name']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($r['kategori']) ?></td>
                <td class="px-4 py-2"><?= $r['waktu'] ?></td>
                <td class="px-4 py-2 space-x-2">
                  <a href="?edit_prio=<?= $r['id'] ?>" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Edit</a>
                  <a href="?hapus_prio=<?= $r['id'] ?>" onclick="return confirm('Yakin?')" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
