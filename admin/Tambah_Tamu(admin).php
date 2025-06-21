<?php
/* ---------- KONEKSI DATABASE ---------- */
$pdo = new PDO(
    "mysql:host=localhost;dbname=database_sikatbukutamu;charset=utf8mb4",
    'root','',
    [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]
);

/* ---------- DATA DROP‑DOWN ---------- */
$keperluans = $pdo->query("SELECT nama FROM keperluan_kunjungan ORDER BY nama")->fetchAll(PDO::FETCH_COLUMN);
$areas      = $pdo->query("SELECT nama_area FROM area_duduk ORDER BY nama_area")->fetchAll(PDO::FETCH_COLUMN);

/* ---------- SIMPAN TAMU BIASA ---------- */
if (isset($_POST['simpan'])) {
    $pdo->prepare("INSERT INTO tamu (nama, keperluan, area, luar_provinsi, waktu)
                   VALUES (?,?,?,?,?)")
        ->execute([
            $_POST['nama'], $_POST['keperluan'], $_POST['area'],
            $_POST['luar_provinsi'], $_POST['waktu']
        ]);
    header("Location: DaftarTamu(admin).php"); exit;
}

/* ---------- SIMPAN TAMU PRIORITAS ---------- */
if (isset($_POST['simpan_prio'])) {
    $pdo->prepare("INSERT INTO tamu_prio (name, kategori, waktu)
                   VALUES (?,?,?)")
        ->execute([
            $_POST['nama'],           // kolom name
            $_POST['keperluan'],      // kolom kategori
            $_POST['waktu']
        ]);
    header("Location: DaftarTamu(admin).php"); exit;
}

/* ---------- BATAL ---------- */
if (isset($_POST['batal'])) {
    header("Location: DaftarTamu(admin).php"); exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Tamu & Tamu Prioritas</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-yellow-50 min-h-screen flex items-center justify-center">
  <div class="bg-white shadow-md p-8 rounded-xl w-full max-w-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Form Tambah Tamu</h2>

    <!-- ==== FORM ==== -->
    <form method="POST" class="grid gap-4">

      <!-- JENIS TAMU -->
      <div class="flex items-center justify-center gap-6 mb-2">
        <label class="inline-flex items-center gap-2">
          <input type="radio" name="jenis" value="biasa" checked
                 class="accent-yellow-500">
          <span>Tamu Biasa</span>
        </label>
        <label class="inline-flex items-center gap-2">
          <input type="radio" name="jenis" value="prio"
                 class="accent-yellow-500">
          <span>Tamu Prioritas</span>
        </label>
      </div>

      <input type="text" name="nama" required placeholder="Nama Tamu"
             class="w-full border rounded px-3 py-2" />

      <!-- Keperluan / Kategori -->
      <select name="keperluan" required class="w-full border rounded px-3 py-2">
        <option value="">-- Pilih Keperluan/Kategori --</option>
        <?php foreach ($keperluans as $k): ?>
          <option><?= htmlspecialchars($k) ?></option>
        <?php endforeach; ?>
      </select>

      <!-- Area (hanya relevan utk tamu biasa, tapi tidak masalah di‑POST) -->
      <select name="area" class="w-full border rounded px-3 py-2">
        <option value="">-- Pilih Area Duduk --</option>
        <?php foreach ($areas as $a): ?>
          <option><?= htmlspecialchars($a) ?></option>
        <?php endforeach; ?>
      </select>

      <!-- Luar Provinsi (hanya utk tamu biasa) -->
      <select name="luar_provinsi" class="w-full border rounded px-3 py-2">
        <option value="">-- Luar Provinsi? --</option>
        <option>Ya</option>
        <option>Tidak</option>
      </select>

      <input type="datetime-local" name="waktu"
             value="<?= date('Y-m-d\TH:i') ?>"
             class="w-full border rounded px-3 py-2" required>

      <!-- TOMBOL -->
      <div class="flex justify-between mt-4">
        <!-- JavaScript akan menentukan tombol mana yang diklik -->
        <button id="btnSimpan"  name="simpan"      class="bg-yellow-500 text-white px-4 py-2 rounded">Simpan</button>
        <button id="btnSimpanP"name="simpan_prio" class="bg-yellow-500 text-white px-4 py-2 rounded hidden">Simpan</button>
        <button name="batal" class="bg-gray-300 text-black px-4 py-2 rounded">Batal</button>
      </div>
    </form>
  </div>

  <script>
    // ganti tombol submit sesuai radio
    const radioBiasa = document.querySelector('input[value="biasa"]');
    const radioPrio  = document.querySelector('input[value="prio"]');
    const btnBiasa   = document.getElementById('btnSimpan');
    const btnPrio    = document.getElementById('btnSimpanP');

    function toggleButtons() {
      if (radioPrio.checked) {
        btnPrio.classList.remove('hidden');
        btnBiasa.classList.add('hidden');
      } else {
        btnBiasa.classList.remove('hidden');
        btnPrio.classList.add('hidden');
      }
    }
    radioBiasa.addEventListener('change', toggleButtons);
    radioPrio.addEventListener('change', toggleButtons);
    toggleButtons();
  </script>
</body>
</html>
