<?php
require_once "../koneksi.php";

try {
    $stmt = $pdo->query("SELECT * FROM petugas ORDER BY waktu DESC");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Gagal mengambil data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Data Buku Tamu</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans p-8">

  <div class="max-w-7xl mx-auto bg-gray-800 rounded-lg p-6 shadow">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h2 class="text-2xl font-bold">Buku Tamu</h2>
        <p class="text-sm text-gray-400">Daftar kehadiran tamu dan keperluannya</p>
      </div>
      <a href="tambah.php" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500 text-sm">
        Tambah Tamu
      </a>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full table-auto">
        <thead class="bg-gray-700">
          <tr>
            <th class="px-4 py-2 text-left text-sm font-semibold">Nama</th>
            <th class="px-4 py-2 text-left text-sm font-semibold">Keperluan</th>
            <th class="px-4 py-2 text-left text-sm font-semibold">Area</th>
            <th class="px-4 py-2 text-left text-sm font-semibold">Luar Provinsi</th>
            <th class="px-4 py-2 text-left text-sm font-semibold">Waktu</th>
            <th class="px-4 py-2 text-right text-sm font-semibold">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-700">
          <?php if ($data): ?>
            <?php foreach ($data as $row): ?>
              <tr class="hover:bg-gray-700">
                <td class="px-4 py-3"><?= htmlspecialchars($row['nama']) ?></td>
                <td class="px-4 py-3"><?= htmlspecialchars($row['keperluan']) ?></td>
                <td class="px-4 py-3"><?= htmlspecialchars($row['area']) ?></td>
                <td class="px-4 py-3">
                  <span class="inline-block px-2 py-1 text-xs rounded 
                    <?= $row['luar_provinsi'] ? 'bg-red-600 text-white' : 'bg-green-600 text-white' ?>">
                    <?= $row['luar_provinsi'] ? 'Ya' : 'Tidak' ?>
                  </span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-300"><?= $row['waktu'] ?></td>
                <td class="px-4 py-3 text-right">
                  <a href="edit.php?id=<?= $row['id'] ?>" class="text-indigo-400 hover:underline text-sm mx-5">Edit</a>
                  <a href="delete.php?id=<?= $row['id'] ?>" class="text-red-400 hover:underline text-sm">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center px-4 py-3 text-gray-400">Tidak ada data.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
