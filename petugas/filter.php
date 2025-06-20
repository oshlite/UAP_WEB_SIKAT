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
</head>
<body class="bg-gray-900 text-white p-8">

<div class="max-w-7xl mx-auto bg-gray-800 p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Cari Nama Tamu</h2>

    <form method="POST" class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center gap-3">
            <input 
                type="text" 
                name="search" 
                value="<?= htmlspecialchars($search) ?>"
                placeholder="Masukkan nama tamu..." 
                class="w-full md:w-1/3 px-4 py-2 rounded bg-gray-700 text-white focus:outline-none focus:ring focus:ring-indigo-500"
            >
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded text-white">
                Cari
            </button>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Keperluan</th>
                    <th class="px-4 py-2 text-left">Area</th>
                    <th class="px-4 py-2 text-left">Luar Provinsi</th>
                    <th class="px-4 py-2 text-left">Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                <?php if ($data): ?>
                    <?php foreach ($data as $row): ?>
                        <tr class="hover:bg-gray-700">
                            <td class="px-4 py-2"><?= htmlspecialchars($row['nama']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($row['keperluan']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($row['area']) ?></td>
                            <td class="px-4 py-2">
                                <span class="inline-block h-6 px-2 py-1 text-xs rounded align-middle
                                    <?= $row['luar_provinsi'] ? 'bg-red-600 text-white' : 'bg-green-600 text-white' ?>">
                                    <?= $row['luar_provinsi'] ? 'Ya' : 'Tidak' ?>
                                </span>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-300"><?= $row['waktu'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center px-4 py-3 text-gray-400">Data tidak ditemukan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
