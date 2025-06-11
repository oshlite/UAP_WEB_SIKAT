<?php

require_once "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'] ?? '';
    $keperluan = $_POST['keperluan'] ?? '';
    $area = $_POST['area'] ?? '';
    $luar_provinsi = isset($_POST['luar_provinsi']) ? 1 : 0;
    
    $sql = "INSERT INTO petugas (nama, keperluan, area, luar_provinsi) VALUES (:nama, :keperluan, :area, :luar_provinsi)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nama' => $nama,
        ':keperluan' => $keperluan,
        ':area' => $area,
        ':luar_provinsi' => $luar_provinsi
    ]);
}


?>

<h2>Form Buku Tamu</h2>
<form method="POST" action="">
    <label>Nama:</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Keperluan:</label><br>
    <input type="text" name="keperluan" required><br><br>

    <label>Area:</label><br>
    <input type="text" name="area" required><br><br>

    <label>
        <input type="checkbox" name="luar_provinsi"> Luar Provinsi?
    </label><br><br>

    <button type="submit">Simpan</button>
</form>