<?php
include 'protect_user.php';

$db = new mysqli('localhost','root','','database_sikatbukutamu');
if($db->connect_error) {
  die('DB Error: '.$db->connect_error);
}

$categoryMap = [
  'Keluarga mempelai wanita' => ['Meja Keluarga Wanita', 'bg-blue-100 text-blue-700'],
  'Keluarga mempelai pria'   => ['Meja Keluarga Pria',   'bg-green-100 text-green-700'],
  'Teman dekat mempelai'     => ['Area Umum',            'bg-gray-100 text-gray-700'],
  'Rekan kerja prioritas'    => ['Area Umum',            'bg-gray-100 text-gray-700'],
  'Tokoh masyarakat'         => ['Meja VIP',             'bg-yellow-100 text-yellow-700'],
  'Tamu luar provinsi'       => ['Meja VIP',             'bg-yellow-100 text-yellow-700']
];

// Ambil parameter pencarian dan filter
$search = trim($_GET['search'] ?? '');
$filter = trim($_GET['kategori'] ?? '');

$where = [];
if($search !== '') {
  $where[] = "name LIKE '%".$db->real_escape_string($search)."%'";

}
if($filter !== '' && isset($categoryMap[$filter])) {
  $where[] = "kategori = '".$db->real_escape_string($filter)."'";
}
$whereSql = $where ? ('WHERE '.implode(' AND ', $where)) : '';

if($_SERVER['REQUEST_METHOD']==='POST' && ($_POST['action'] ?? '')==='delete') {
  $id = intval($_POST['id']);
  $ok = (bool)$db->query("DELETE FROM tamu_prio WHERE id=$id");
  $status = $ok ? 'success' : 'error';
  header('Location: '.basename(__FILE__).'?status='.$status);
  exit;
}

$invitedGuests = [];
$res = $db->query("SELECT * FROM tamu_prio $whereSql ORDER BY id");
while($row = $res->fetch_assoc()) {
  list($area,$cls) = $categoryMap[$row['kategori']] 
                     ?? ['Area Umum','bg-gray-100 text-gray-700'];
  $invitedGuests[] = [
    'id'         => $row['id'],
    'nama'       => $row['name'],
    'kategori'   => $row['kategori'],
    'area'       => $area,
    'badgeClass' => $cls
  ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Daftar Tamu Undangan - SIKAT</title>
  <script src="https://cdn.tailwindcss.com/3.4.16"></script>
  <script>
    tailwind.config = {
      theme:{extend:{
        colors:{primary:'#FFD700',secondary:'#FFDAB9'},
        borderRadius:{'button':'8px'}
      }}
    };
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet">
  <style>
    body { font-family:'Poppins',sans-serif; background:#FFFFF8; }
    .font-serif { font-family:'Playfair Display',serif; }
    .card { background:#fff; border-radius:12px;
      box-shadow:0 4px 12px rgba(0,0,0,0.05); position:relative; overflow:hidden;
    }
    .card::after { content:""; position:absolute; bottom:0; right:0; width:60px; height:60px;
      background-image:url("data:image/svg+xml,%3Csvg width='60' height='60'%3E
        %3Cpath d='M30 0C30 16.5685 16.5685 30 0 30C0 13.4315 13.4315 0 30 0Z' fill='%23FFDAB9' fill-opacity='0.2'/%3E
        %3Cpath d='M60 30C60 46.5685 46.5685 60 30 60C30 43.4315 43.4315 30 60 30Z' fill='%23FFD700' fill-opacity='0.2'/%3E
      %3C/svg%3E"); background-repeat:no-repeat; background-position:bottom right; opacity:.5;
    }
    .sidebar-item { transition:all .2s ease; }
    .sidebar-item:hover { background:rgba(255,218,185,.2); }
    .sidebar-item.active { background:rgba(255,215,0,.1); border-left:3px solid #FFD700; }
    .toast {
  display: none;
  position: fixed;
  top: 20px; right: 20px;
  background: #fff;
  border-left: 4px solid #FFD700;
  padding: 16px;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  z-index: 1000;
  align-items: center;
}
.toast.error {
  border-color: #F87171;
}
 }
  </style>
</head>
<body>
  <div class="flex h-screen bg-gray-50">
    <?php include 'user_sidebar.php'; ?>
    <div class="flex-1 flex flex-col overflow-hidden">
      <header class="bg-white shadow-sm z-10">
        <div class="px-4 py-2 bg-gray-50 flex items-center text-sm">
          <a href="#" class="text-gray-500">Manajemen Tamu</a>
          <i class="ri-arrow-right-s-line mx-2 text-gray-400"></i>
          <span class="text-gray-700">Daftar Tamu Undangan</span>
        </div>
      </header>

      <main class="flex-1 overflow-y-auto p-4 bg-gray-50">
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
          <div>
            <h1 class="text-2xl font-serif font-semibold text-gray-800">Daftar Tamu Undangan</h1>
            <p class="text-gray-600 text-sm">Kelola tamu resmi undangan pengantin</p>
          </div>
          <form method="get" class="flex flex-wrap gap-2 items-center">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari nama tamu..." class="border border-gray-200 rounded-lg px-3 py-2 text-sm" />
            <select name="kategori" class="border border-gray-200 rounded-lg px-3 py-2 text-sm">
              <option value="">Semua Kategori</option>
              <?php foreach(array_keys($categoryMap) as $cat): ?>
                <option value="<?= htmlspecialchars($cat) ?>" <?= $filter===$cat?'selected':'' ?>><?= htmlspecialchars($cat) ?></option>
              <?php endforeach; ?>
            </select>
            <button type="submit" class="bg-primary text-white px-3 py-2 rounded-lg text-sm flex items-center">
              <i class="ri-search-line mr-1"></i> Cari
            </button>
          </form>
          <a href="user_tamuprio_tambah.php"
             class="bg-primary text-white px-4 py-2 rounded-lg text-sm flex items-center !rounded-button">
            <i class="ri-add-line mr-2"></i> Tambah Tamu
          </a>
        </div>

        <div class="card p-4 mb-6">
          <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
              <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                  <th class="px-4 py-3">No</th>
                  <th class="px-4 py-3">Nama Tamu</th>
                  <th class="px-4 py-3">Keperluan</th>
                  <th class="px-4 py-3">Area Duduk</th>
                  <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($invitedGuests as $i => $g): ?>
                <tr class="border-b hover:bg-gray-50">
                  <td class="px-4 py-3"><?= $i+1 ?></td>
                  <td class="px-4 py-3 font-medium"><?= htmlspecialchars($g['nama']) ?></td>
                  <td class="px-4 py-3"><?= htmlspecialchars($g['kategori']) ?></td>
                  <td class="px-4 py-3">
                    <span class="px-2 py-1 <?= $g['badgeClass'] ?> rounded-full text-xs">
                      <?= htmlspecialchars($g['area']) ?>
                    </span>
                  </td>
                  <td class="px-4 py-3 text-right space-x-2">
                    <a href="user_tamuprio_edit.php?id=<?= $g['id'] ?>"
                       class="text-gray-500 hover:text-primary">
                      <i class="ri-edit-line"></i>
                    </a>
                    <a href="user_tamuprio_hapus.php?id=<?= $g['id'] ?>"
   class="text-gray-500 hover:text-red-500">
  <i class="ri-delete-bin-line"></i>
</a>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

      </main>
    </div>
  </div>

<script>
document.addEventListener('DOMContentLoaded', ()=>{
  const status = new URLSearchParams(location.search).get('status');
  if(!status) return;

  const toast     = document.getElementById('toast'),
        toastMsg  = document.getElementById('toastMsg'),
        toastClose= document.getElementById('toastClose');

  toastMsg.textContent = status==='success'
    ? 'Oke berhasil!'
    : 'Terjadi kesalahan!';
  toast.classList.toggle('error', status!=='success');

  toast.style.display = 'flex';
  setTimeout(()=> toast.style.display = 'none', 3000);

  toastClose.onclick = ()=> toast.style.display = 'none';
});
</script>


<div id="toast" class="toast">
  <i class="ri-checkbox-circle-line ri-lg text-primary"></i>
  <span id="toastMsg" class="ml-2 text-sm font-medium text-gray-800"></span>
  <button id="toastClose" class="ml-auto text-gray-400"><i class="ri-close-line ri-lg"></i></button>
</div>

</body>
</html>
