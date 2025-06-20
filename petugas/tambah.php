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
</head>
<body class="bg-gray-900 text-white p-6 font-sans">

<div class="max-w-xl mx-auto bg-gray-800 p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Tambah Data Tamu</h2>
    
    <form method="POST" action="" class="space-y-4">
        <div>
            <label class="block mb-1 font-medium">Nama:</label>
            <input 
                type="text" 
                name="nama" 
                required
                class="w-full px-4 py-2 rounded bg-gray-700 text-white focus:outline-none focus:ring focus:ring-indigo-500"
            >
        </div>

        <div>
            <label class="block mb-1 font-medium">Keperluan:</label>
            <input 
                type="text" 
                name="keperluan" 
                required
                class="w-full px-4 py-2 rounded bg-gray-700 text-white focus:outline-none focus:ring focus:ring-indigo-500"
            >
        </div>

        <div>
            <label class="block mb-1 font-medium">Area:</label>
            <input 
                type="text" 
                name="area" 
                required
                class="w-full px-4 py-2 rounded bg-gray-700 text-white focus:outline-none focus:ring focus:ring-indigo-500"
            >
        </div>

        <div class="flex items-center gap-2">
            <input 
                type="checkbox" 
                name="luar_provinsi" 
                class="form-checkbox h-5 w-5 text-indigo-600 bg-gray-700 border-gray-600 rounded"
            >
            <label class="text-sm">Luar Provinsi?</label>
        </div>

        <div class="flex justify-end">
            <button 
                type="submit" 
                class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2 rounded shadow"
            >
                Simpan
            </button>
        </div>
    </form>
</div>

</body>
</html>
