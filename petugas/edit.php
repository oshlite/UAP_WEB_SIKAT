 <?php
    require_once "../koneksi.php";

    $id = $_GET['id'] ?? null;
    if (!$id) {
        die("ID tidak valid untuk update.");
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama = $_POST['nama'] ?? '';
        $keperluan = $_POST['keperluan'] ?? '';
        $area = $_POST['area'] ?? '';
        $luar_provinsi = isset($_POST['luar_provinsi']) ? 1 : 0;

        $sql = "UPDATE petugas 
            SET nama = :nama, keperluan = :keperluan, area = :area, luar_provinsi = :luar_provinsi 
            WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nama' => $nama,
            ':keperluan' => $keperluan,
            ':area' => $area,
            ':luar_provinsi' => $luar_provinsi,
            ':id' => $id
        ]);
        header('Location: bukuTamu.php');
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