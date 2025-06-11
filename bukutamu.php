<?php
// index.php
require 'koneksi.php';

$success     = false;
$guestName   = '';
$areaRedirect= '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama      = trim($_POST['nama']);
    $keperluan = $_POST['keperluan'];
    $prov      = $_POST['luar_provinsi'] ?? '';

    // simpan ke database
    $stmt = $pdo->prepare("INSERT INTO tamu (nama, keperluan, luar_provinsi) VALUES (?, ?, ?)");
    $stmt->execute([$nama, $keperluan, $prov]);

    $success      = true;
    $guestName    = htmlspecialchars($nama);
    $areaRedirect = htmlspecialchars($prov);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Buku Tamu Pernikahan</title>
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" />
</head>
<body class="bg-peach bg-opacity-20 min-h-screen flex flex-col">

  <!-- NAVBAR -->
  <nav class="bg-white shadow-md">
    <div class="max-w-4xl mx-auto px-6 py-4 flex justify-between items-center">
      <h1 class="text-3xl font-script text-gold">SIKAT</h1>
      <span class="text-sm bg-gold bg-opacity-20 text-gold px-3 py-1 rounded-full">
        Buku Tamu
      </span>
    </div>
  </nav>

  <!-- CONTENT -->
  <main class="flex-1 w-full max-w-3xl mx-auto px-6 py-12">
    <header class="text-center mb-10">
      <h2 class="text-4xl font-serif text-gray-800 mb-2">
        Selamat Datang di Pernikahan A & B
      </h2>
      <p class="text-gray-600">Isi data diri Anda & petugas akan mengarahkan Anda.</p>
    </header>

    <section class="bg-white rounded-3xl shadow-lg p-8">
      <form method="post" class="space-y-6">
        <!-- Nama -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
          <input name="nama" type="text" required
            class="w-full border border-gray-200 p-3 rounded-xl focus:ring-2 focus:ring-gold focus:border-transparent transition" />
        </div>

        <!-- Keperluan -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Keperluan</label>
          <select name="keperluan" required
            class="w-full border border-gray-200 p-3 rounded-xl focus:ring-2 focus:ring-gold focus:border-transparent transition">
            <option value="">Pilih Keperluan</option>
            <option value="Keluarga">Keluarga</option>
            <option value="Teman">Teman</option>
            <option value="Rekan">Rekan</option>
          </select>
        </div>

        <!-- Luar Provinsi -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tamu Luar Provinsi?</label>
          <select name="luar_provinsi" required
            class="w-full border border-gray-200 p-3 rounded-xl focus:ring-2 focus:ring-gold focus:border-transparent transition">
            <option value="">Pilih</option>
            <option value="Ya">Ya</option>
            <option value="Tidak">Tidak</option>
          </select>
        </div>

        <!-- Submit -->
        <button type="submit"
          class="w-full bg-gold text-white py-3 rounded-xl font-medium hover:bg-gold-dark transition">
          Kirim & Lihat Petunjuk
        </button>
      </form>
    </section>
  </main>

  <!-- FOOTER -->
  <footer class="py-6 text-center text-gray-500 text-sm">
    © 2025 [Nama Pengantin]. Dibuat dengan ❤️
  </footer>

  <!-- MODAL REDIRECT -->
  <div id="redirectModal"
       class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-opacity">
    <div class="bg-white rounded-2xl p-6 w-11/12 max-w-md text-center relative">
      <button id="closeModal"
        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
        <i class="ri-close-line ri-lg"></i>
      </button>
      <i class="ri-checkbox-circle-line text-gold text-4xl mb-4"></i>
      <h3 class="text-xl font-medium text-gray-800 mb-2">Terima Kasih, <?= $guestName ?>!</h3>
      <p class="text-gray-600 mb-4">
        Silakan menuju Loby,
        Petugas akan membantu Anda❤️
      </p>
      <button id="modalOk"
        class="bg-gold text-white px-6 py-2 rounded-xl hover:bg-gold-dark transition">
        Oke
      </button>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      <?php if ($success): ?>
        const m = document.getElementById('redirectModal');
        m.classList.remove('opacity-0', 'pointer-events-none');
        ['closeModal', 'modalOk'].forEach(id => {
          document.getElementById(id).addEventListener('click', () => {
            m.classList.add('opacity-0', 'pointer-events-none');
          });
        });
      <?php endif; ?>
    });
  </script>
</body>
</html>
