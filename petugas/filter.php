<?php
require_once "../koneksi.php";

$search = '';
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search = $_POST['search'] ?? '';

    try {
        $stmt = $pdo->prepare("SELECT * FROM petugas WHERE nama LIKE :search ORDER BY waktu DESC");
        $stmt->execute([':search' => '%' . $search . '%']);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Gagal mengambil data: " . $e->getMessage());
    }
} else {
    // Menampilkan semua data saat pertama kali dibuka
    $stmt = $pdo->query("SELECT * FROM petugas ORDER BY waktu DESC");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pencarian Buku Tamu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">

    <div class="min-h-screen p-8">
        <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-700">Pencarian Buku Tamu</h2>
                <a href="index.php" class="text-sm text-indigo-600 hover:underline flex items-center gap-1">
                    <i class="ri-arrow-left-line"></i> Kembali
                </a>
            </div>

            <form method="POST" class="mb-6">
                <div class="flex flex-col md:flex-row md:items-center gap-3">
                    <input
                        type="text"
                        name="search"
                        value="<?= htmlspecialchars($search) ?>"
                        placeholder="Masukkan nama tamu..."
                        class="w-full md:w-1/3 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded-lg text-white flex items-center gap-1">
                        <i class="ri-search-line"></i> Cari
                    </button>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border-collapse">
                    <thead class="bg-indigo-100 text-indigo-700">
                        <tr>
                            <th class="px-4 py-2 text-left">Nama</th>
                            <th class="px-4 py-2 text-left">Keperluan</th>
                            <th class="px-4 py-2 text-left">Area</th>
                            <th class="px-4 py-2 text-left">Luar Provinsi</th>
                            <th class="px-4 py-2 text-left">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if ($data): ?>
                            <?php foreach ($data as $row): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 text-gray-700"><?= htmlspecialchars($row['nama']) ?></td>
                                    <td class="px-4 py-2 text-gray-700"><?= htmlspecialchars($row['keperluan']) ?></td>
                                    <td class="px-4 py-2 text-gray-700"><?= htmlspecialchars($row['area']) ?></td>
                                    <td class="px-4 py-2">
                                        <span class="inline-block px-2 py-1 text-xs rounded 
                    <?= $row['luar_provinsi'] ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' ?>">
                                            <?= $row['luar_provinsi'] ? 'Ya' : 'Tidak' ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-500"><?= $row['waktu'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center px-4 py-3 text-gray-400">Data tidak ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>