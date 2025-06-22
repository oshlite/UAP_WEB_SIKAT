<?php
require_once "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'] ?? '';
    $keperluan = $_POST['keperluan'] ?? '';
    $area = $_POST['area'] ?? '';
    $luar_provinsi = isset($_POST['luar_provinsi']) ? 1 : 0;

    $sql = "INSERT INTO petugas (nama, keperluan, area, luar_provinsi) 
            VALUES (:nama, :keperluan, :area, :luar_provinsi)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nama' => $nama,
        ':keperluan' => $keperluan,
        ':area' => $area,
        ':luar_provinsi' => $luar_provinsi
    ]);
    header('Location: bukuTamu.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Tambah Buku Tamu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">

    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-xl">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-700">Tambah Data Tamu</h2>
                <a href="bukuTamu.php" class="text-sm text-indigo-600 hover:underline flex items-center gap-1">
                    <i class="ri-arrow-left-line"></i> Kembali
                </a>
            </div>

            <form method="POST" action="" class="space-y-5">
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Nama</label>
                    <input
                        type="text"
                        name="nama"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>

                <div>
                    <label class="block mb-1 font-medium text-gray-700">Keperluan</label>
                    <input
                        type="text"
                        name="keperluan"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>

                <div>
                    <label class="block mb-1 font-medium text-gray-700">Area</label>
                    <input
                        type="text"
                        name="area"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>

                <div class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        name="luar_provinsi"
                        class="h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label class="text-sm text-gray-700">Luar Provinsi?</label>
                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2 rounded-lg shadow">
                        <i class="ri-save-line mr-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>