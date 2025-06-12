<?php
require_once "../koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM petugas WHERE id = :id");
        $stmt->execute(['id' => $id]);

        header("Location: bukuTamu.php");
        exit;
    } catch (PDOException $e) {
        echo "Gagal menghapus data: " . $e->getMessage();
    }
} else {
    echo "ID tidak ditemukan.";
}
?>
