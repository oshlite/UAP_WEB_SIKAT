<?php
require_once "../koneksi.php";

// Query SELECT
$sql = "SELECT * FROM petugas";
$stmt = $pdo->query($sql);

// Tampilkan data

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "Nama: " . $row["nama"] . " | Keperluan: " . $row["keperluan"] .
        " | Area: " . $row["area"] . " | Luar Provinsi: " .
        ($row["luar_provinsi"] ? "Ya" : "Tidak") .
        " | Waktu: " . $row["waktu"] . "<br>";
}
