<?php
include 'protect_user.php';

$db = new mysqli('sql210.infinityfree.com','if0_39298307','ROOTSIKAT123','if0_39298307_database_sikatbukutamu');
if($db->connect_error) {
  die('DB Error: '.$db->connect_error);
}

if($_SERVER['REQUEST_METHOD']==='POST') {
  $action   = $_POST['action']       ?? '';
  $id       = intval($_POST['id']     ?? 0);
  $nama     = $db->real_escape_string($_POST['nama']      ?? '');
  $des      = $db->real_escape_string($_POST['deskripsi'] ?? '');
  $areaId   = intval($_POST['area_id'] ?? 0);
  $ok = false;

  // Hanya izinkan edit dan delete
  if($action==='edit' && $id) {
    $ok = (bool)$db->query("
      UPDATE keperluan_kunjungan
      SET nama='$nama', deskripsi='$des', area_id=$areaId
      WHERE id=$id
    ");
  }
  elseif($action==='delete' && $id) {
    $ok = (bool)$db->query("
      DELETE FROM keperluan_kunjungan WHERE id=$id
    ");
  }

  $status = $ok ? 'success' : 'error';
  header("Location: ".basename(__FILE__)."?status={$status}");
  exit;
}

$areas = [];
$resA = $db->query("SELECT id,nama_area FROM area_duduk ORDER BY id");
while($r = $resA->fetch_assoc()) {
  $areas[$r['id']] = $r['nama_area'];
}

$keps = [];
$sql = "
  SELECT k.id,k.nama,k.deskripsi,k.area_id,a.nama_area
  FROM keperluan_kunjungan k
  LEFT JOIN area_duduk a ON k.area_id=a.id
  ORDER BY k.id
";
$res = $db->query($sql);
while($r = $res->fetch_assoc()) {
  $keps[] = $r;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Keperluan Kunjungan – SIKAT</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme:{extend:{
        colors:{primary:'#FFD700',secondary:'#FFDAB9'},
        borderRadius:{button:'8px'}
      }}
    };
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&
              family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet"/>
  <style>
    body{font-family:'Poppins',sans-serif;background:#FFFFF8}
    .font-serif{font-family:'Playfair Display',serif}
    .card{background:#fff;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,0.05);overflow:hidden;position:relative}
    .modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:50}
    .modal-content{background:#fff;margin:10% auto;padding:24px;border-radius:12px;width:400px;max-width:90%}
    .toast{display:none;position:fixed;top:20px;right:20px;background:#fff;border-left:4px solid #FFD700;padding:16px;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.1);z-index:100;align-items:center;}
    .toast.error{border-color:#F87171;}
    .sidebar-item{transition:all .2s ease}
    .sidebar-item:hover{background:rgba(255,218,185,.2)}
    .sidebar-item.active{background:rgba(255,215,0,.1);border-left:3px solid #FFD700}
  </style>
</head>
<body class="flex h-screen bg-gray-50">
  <?php include 'user_sidebar.php'; ?>
  <div class="flex-1 flex flex-col overflow-hidden">
    <header class="bg-white shadow-sm z-10">
      <div class="px-4 py-2 bg-gray-50 flex items-center text-sm">
        <a href="#" class="text-gray-500">Manajemen Tamu</a>
        <i class="ri-arrow-right-s-line mx-2 text-gray-400"></i>
        <span class="text-gray-700">Keperluan Kunjungan</span>
      </div>
    </header>

    <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
      <div class="mb-6 flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-serif font-semibold text-gray-800">Keperluan Kunjungan</h1>
          <p class="text-gray-600 text-sm">Edit / Hapus keperluan kunjungan</p>
        </div>
        <!-- Tombol tambah disembunyikan -->
      </div>

      <div class="card p-4">
        <div class="overflow-x-auto">
          <table class="w-full text-sm text-left" id="tbl">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
              <tr>
                <th class="px-4 py-3">No</th>
                <th class="px-4 py-3">Nama Keperluan</th>
                <th class="px-4 py-3">Area Duduk</th>
                <th class="px-4 py-3 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($keps as $i=>$k): ?>
              <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-3"><?= $i+1 ?></td>
                <td class="px-4 py-3 font-medium"><?= htmlspecialchars($k['nama']) ?></td>
                <td class="px-4 py-3"><?= htmlspecialchars($k['nama_area'] ?? '-') ?></td>
                <td class="px-4 py-3 text-right space-x-2">
                  <button class="edit-btn text-gray-500 hover:text-primary"
                          data-id="<?= $k['id'] ?>"
                          data-nama="<?= htmlspecialchars($k['nama']) ?>"
                          data-des="<?= htmlspecialchars($k['deskripsi']) ?>"
                          data-area="<?= $k['area_id'] ?>">
                    <i class="ri-edit-line"></i>
                  </button>
                  <button class="delete-btn text-gray-500 hover:text-red-500"
                          data-id="<?= $k['id'] ?>">
                    <i class="ri-delete-bin-line"></i>
                  </button>
                </td>
              </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

  <!-- Modal hanya untuk edit -->
  <div id="modal" class="modal">
    <div class="modal-content">
      <h2 id="modalTitle" class="text-xl font-medium text-gray-800 mb-4">Edit Keperluan</h2>
      <form id="form" method="post" class="space-y-4">
        <input type="hidden" name="action" id="actionInput" value="edit">
        <input type="hidden" name="id"     id="idInput">
        <div>
          <label class="block text-sm font-medium text-gray-700">Nama Keperluan</label>
          <input type="text" name="nama" id="namaInput" required
                 class="w-full p-2.5 border border-gray-200 rounded-lg text-sm">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
          <textarea name="deskripsi" id="desInput" rows="3"
                    class="w-full p-2.5 border border-gray-200 rounded-lg text-sm"></textarea>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Area Duduk</label>
          <select name="area_id" id="areaInput" required
                  class="w-full p-2.5 border border-gray-200 rounded-lg text-sm">
            <?php foreach($areas as $id=>$nm): ?>
            <option value="<?= $id ?>"><?= htmlspecialchars($nm) ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="flex justify-end space-x-2 mt-4">
          <button type="button" id="btnCancel"
                  class="px-4 py-2 border border-gray-200 rounded-lg text-sm text-gray-700">
            Batal
          </button>
          <button type="submit"
                  class="px-4 py-2 bg-primary text-white rounded-lg text-sm">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>

  <div id="toast" class="toast flex">
    <span id="toastMsg" class="text-gray-800 font-medium"></span>
    <button id="toastClose" class="ml-4 text-gray-400"><i class="ri-close-line ri-lg"></i></button>
  </div>

  <script>
  document.addEventListener('DOMContentLoaded', ()=>{
    const modal      = document.getElementById('modal'),
          btnCancel  = document.getElementById('btnCancel'),
          form       = document.getElementById('form'),
          actionIn   = document.getElementById('actionInput'),
          idIn       = document.getElementById('idInput'),
          namaIn     = document.getElementById('namaInput'),
          desIn      = document.getElementById('desInput'),
          areaIn     = document.getElementById('areaInput'),
          toast      = document.getElementById('toast'),
          toastMsg   = document.getElementById('toastMsg'),
          toastClose = document.getElementById('toastClose'),
          title      = document.getElementById('modalTitle');

    document.querySelectorAll('.edit-btn').forEach(b=>{
      b.onclick=()=>{
        actionIn.value='edit'; idIn.value=b.dataset.id;
        namaIn.value=b.dataset.nama; desIn.value=b.dataset.des; 
        areaIn.value=b.dataset.area;
        title.textContent='Edit Keperluan'; modal.style.display='block';
      };
    });
    document.querySelectorAll('.delete-btn').forEach(b=>{
      b.onclick=()=>{
        if(!confirm('Hapus keperluan ini?')) return;
        const f=document.createElement('form');
        f.method='post'; f.style.display='none';
        f.innerHTML=
          '<input name="action" value="delete">'+
          '<input name="id"     value="'+b.dataset.id+'">';
        document.body.appendChild(f); f.submit();
      };
    });
    btnCancel.onclick = ()=> modal.style.display='none';
    toastClose.onclick = ()=> toast.style.display='none';
    const st = new URLSearchParams(location.search).get('status');
    if(st==='success'||st==='error'){
      toastMsg.textContent = st==='success' ? 'Berhasil!' : 'Terjadi kesalahan!';
      toast.classList.toggle('error', st==='error');
      toast.style.display='flex';
      setTimeout(()=> toast.style.display='none',3000);
    }
  });
  </script>
</body>
</html>
