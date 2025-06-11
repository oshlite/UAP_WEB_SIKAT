<?php
require 'koneksi.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="daftar_tamu_' . date('Y-m-d') . '.csv"');

$output = fopen('php://output', 'w');

// Header kolom
fputcsv($output, ['No', 'Nama', 'Keperluan', 'Area', 'Luar Provinsi', 'Waktu']);

// Ambil data tamu
$stmt = $pdo->prepare("SELECT * FROM tamu ORDER BY waktu DESC");
$stmt->execute();
$tamuList = $stmt->fetchAll();

$no = 1;
foreach ($tamuList as $row) {
    fputcsv($output, [
        $no++,
        $row['nama'],
        $row['keperluan'],
        $row['area'],
        $row['luar_provinsi'],
        $row['waktu']
    ]);
}

fclose($output);
exit;
