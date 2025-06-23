<?php

$db = new mysqli('localhost','root','','database_sikatbukutamu');
if($db->connect_error) {
  die('DB Error: '.$db->connect_error);
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
  $id = intval($_POST['id']);
  $ok = (bool)$db->query("DELETE FROM tamu_prio WHERE id=$id");
  header('Location: user_tamuprio.php?status=' . ($ok ? 'success' : 'error'));
  exit;
}

$id = intval($_GET['id'] ?? 0);
if(!$id) {
  header('Location: user_tamuprio.php?status=error');
  exit;
}
$res = $db->query("SELECT name FROM tamu_prio WHERE id=$id");
if(!$res || !$res->num_rows) {
  header('Location: user_tamuprio.php?status=error');
  exit;
}
$row  = $res->fetch_assoc();
$name = $row['name'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Hapus Tamu Undangan - SIKAT</title>
  <script src="https://cdn.tailwindcss.com/3.4.16"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#FFD700',
            secondary: '#FFDAB9'
          },
          borderRadius: {
            button: '8px'
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background: #FFFFF8; }
    .font-serif { font-family: 'Playfair Display', serif; }
    .card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      position: relative;
      overflow: hidden;
    }
    .card::after {
      content: "";
      position: absolute;
      bottom: 0; right: 0;
      width: 60px; height: 60px;
      background-image: url("data:image/svg+xml,%3Csvg width='60' height='60'%3E%3Cpath d='M30 0C30 16.5685 16.5685 30 0 30C0 13.4315 13.4315 0 30 0Z' fill='%23FFDAB9' fill-opacity='0.2'/%3E%3Cpath d='M60 30C60 46.5685 46.5685 60 30 60C30 43.4315 43.4315 30 60 30Z' fill='%23FFD700' fill-opacity='0.2'/%3E%3C/svg%3E");
      background-repeat:no-repeat;
      background-position:bottom right;
      opacity:.5;
      pointer-events:none;
    }
    .sidebar-item { transition: all .2s ease; }
    .sidebar-item:hover { background: rgba(255,218,185,.2); }
    .sidebar-item.active { background: rgba(255,215,0,.1); border-left: 3px solid #FFD700; }
  </style>
</head>
<body>
  <div class="flex h-screen bg-gray-50">
    <?php include 'user_sidebar.php'; ?>
    <div class="flex-1 flex flex-col overflow-hidden">
      <header class="bg-white shadow-sm z-10">
        <div class="px-4 py-2 bg-gray-50 flex items-center text-sm">
          <a href="user_tamuprio.php" class="text-gray-500">Manajemen Tamu</a>
          <i class="ri-arrow-right-s-line mx-2 text-gray-400"></i>
          <span class="text-gray-700">Hapus Tamu Undangan</span>
        </div>
      </header>
      <main class="flex-1 overflow-y-auto p-4 bg-gray-50">
        <div class="card mx-auto mt-8 p-6 max-w-lg">
          <h2 class="text-xl font-serif font-semibold text-gray-800">Konfirmasi Hapus Tamu</h2>
          <p class="text-gray-700 mt-4">
            Anda yakin ingin menghapus tamu 
            <span class="font-medium"><?= htmlspecialchars($name) ?></span>?
          </p>
          <p class="text-xs text-gray-500 mt-1">Tindakan ini tidak dapat dibatalkan.</p>
          <form method="post" class="mt-6 flex justify-end space-x-2">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id"     value="<?= $id ?>">
            <a href="user_tamuprio.php"
               class="px-4 py-2 border border-gray-200 text-gray-700 rounded-lg text-sm">
              Batal
            </a>
            <button type="submit"
                    class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm">
              Hapus
            </button>
          </form>
        </div>
      </main>
    </div>
  </div>
</body>
</html>
