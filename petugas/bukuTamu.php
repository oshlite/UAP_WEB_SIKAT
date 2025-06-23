<?php
require_once "../koneksi.php";

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

try {
  $stmt = $pdo->query("SELECT * FROM tamu ORDER BY waktu DESC");
  $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Gagal mengambil data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Buku Tamu - SIKAT</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">

  <div class="flex min-h-screen">

    <!-- Content Area -->
    <main class="flex-1 p-8">
      <div class="flex justify-between items-center mb-6">
        <div>
          <h2 class="text-2xl font-bold">Buku Tamu</h2>
          <p class="text-sm text-gray-500">Daftar kehadiran tamu dan keperluannya</p>
        </div>
        <a href="tambah.php" class="bg-yellow-500 hover:bg-yellow-400 text-white px-4 py-2 rounded flex items-center gap-2">
          <i class="ri-user-add-line"></i> Tambah Tamu
        </a>
      </div>

      <div class="overflow-x-auto bg-white p-6 rounded shadow">
        <table class="min-w-full">
          <thead class="bg-gray-100">
            <tr class="text-left text-sm font-semibold text-gray-600">
              <th class="py-2 px-4">Nama</th>
              <th class="py-2 px-4">Keperluan</th>
              <th class="py-2 px-4">Area</th>
              <th class="py-2 px-4">Luar Provinsi</th>
              <th class="py-2 px-4">Waktu</th>
              <th class="py-2 px-4 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
            <?php if ($data): ?>
              <?php foreach ($data as $row): ?>
                <tr class="hover:bg-yellow-50">
                  <td class="py-2 px-4 font-medium"><?= htmlspecialchars($row['nama']) ?></td>
                  <td class="py-2 px-4"><?= htmlspecialchars($row['keperluan']) ?></td>
                  <td class="py-2 px-4"><?= htmlspecialchars($row['area']) ?></td>
                  <td class="py-2 px-4">
                    <span class="inline-block px-2 py-1 text-xs rounded font-semibold <?= $row['luar_provinsi'] ? 'bg-red-500 text-white' : 'bg-green-500 text-white' ?>">
                      <?= $row['luar_provinsi'] ? 'Ya' : 'Tidak' ?>
                    </span>
                  </td>
                  <td class="py-2 px-4 text-gray-500"><?= $row['waktu'] ?></td>
                  <td class="py-2 px-4 text-right space-x-3">
                    <a href="edit.php?id=<?= $row['id'] ?>" class="text-indigo-600 hover:underline text-sm"><i class="ri-edit-line"></i></a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="text-red-600 hover:underline text-sm"><i class="ri-delete-bin-line"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center py-4 text-gray-400">Tidak ada data.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      <div class="flex justify-between items-center mt-6">
        <a href="index.php" class="bg-yellow-500 hover:bg-yellow-400 text-white px-4 py-2 rounded flex items-center gap-2">
          Kembali
        </a>
      </div>
    </main>
  </div>


</body>

</html>