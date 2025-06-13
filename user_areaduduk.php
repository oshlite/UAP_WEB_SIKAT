<?php

$db = new mysqli('localhost','root','','database_sikatbukutamu');
if($db->connect_error) die('DB Error: '.$db->connect_error);

$return = $_GET['return'] ?? '';

if($_SERVER['REQUEST_METHOD']==='POST'){
  $action    = $_POST['action']     ?? '';
  $id        = intval($_POST['id']  ?? 0);
  $nama_area = $db->real_escape_string($_POST['nama_area'] ?? '');
  $ok = false;

  if($action==='add'){
    $ok = (bool)$db->query(
      "INSERT INTO area_duduk (nama_area) VALUES('$nama_area')"
    );
  }
  elseif($action==='edit' && $id){
    $ok = (bool)$db->query(
      "UPDATE area_duduk 
         SET nama_area='$nama_area' 
       WHERE id=$id"
    );
  }
  elseif($action==='delete' && $id){
    $ok = (bool)$db->query(
      "DELETE FROM area_duduk WHERE id=$id"
    );
  }

  $status = $ok ? 'success' : 'error';
  $loc = basename(__FILE__)."?status=$status";
  if($return==='keperluan') $loc .= "&return=keperluan";
  header("Location: $loc");
  exit;
}

$areas = [];
$res = $db->query("SELECT * FROM area_duduk ORDER BY id");
while($r = $res->fetch_assoc()){
  $areas[] = $r;
}
?>
<!DOCTYPE html>
<html lang="id"><head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Area Duduk – SIKAT</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config={theme:{extend:{
      colors:{primary:'#FFD700',secondary:'#FFDAB9'},
      borderRadius:{button:'8px'}
    }}};
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
</head><body class="flex h-screen bg-gray-50">
  <div class="w-64 bg-white shadow-md hidden md:block">
    <div class="p-4 flex items-center">
      <h1 class="text-2xl font-['Pacifico'] text-primary">SIKAT</h1>
      user_tamuprio<span class="ml-2 text-xs bg-secondary bg-opacity-30 text-gray-700 px-2 py-1 rounded-full">User Pengantin</span>
    </div>
    <div class="mt-6">
      <?php 
      $menu=['Dashboard'=>'ri-dashboard-line','Manajemen Tamu'=>'ri-user-3-line',
             'Keperluan Kunjungan'=>'ri-question-answer-line','Area Duduk'=>'ri-map-pin-line',
             'Petugas'=>'ri-team-line','Pengguna'=>'ri-user-settings-line',
             'Laporan'=>'ri-file-chart-line','Pengaturan'=>'ri-settings-3-line'];
      foreach($menu as $lbl=>$icon):
        $active=($lbl==='Area Duduk')?' active':'';
      ?>
      <div class="sidebar-item<?= $active ?> px-4 py-3 flex items-center">
        <i class="<?= $icon ?> ri-lg text-<?= $active?'primary':'gray-600' ?>"></i>
        <span class="ml-2 text-gray-800"><?= $lbl ?></span>
      </div>
      <?php endforeach ?>
    </div>
    <div class="mt-auto p-4 border-t flex items-center">
      <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
        <i class="ri-user-line ri-lg"></i>
      </div>
      <div class="ml-3">
        <p class="text-sm font-medium text-gray-800">Adi Nugroho</p>
        <p class="text-xs text-gray-500">Administrator</p>
      </div>
      <i class="ri-logout-box-r-line text-gray-500 ml-auto"></i>
    </div>
  </div>

  <div class="flex-1 flex flex-col overflow-hidden">
    <header class="bg-white shadow-sm z-10">
      <div class="px-4 py-2 bg-gray-50 flex items-center text-sm">
        <a href="#" class="text-gray-500">Manajemen Tamu</a>
        <i class="ri-arrow-right-s-line mx-2 text-gray-400"></i>
        <span class="text-gray-700">Area Duduk</span>
      </div>
    </header>

    <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
      <?php if($return==='keperluan'): ?>
      <div class="mb-4">
        <a href="user_keperluankunjungan.php?openAdd=1"
           class="text-primary underline text-sm">
          ← Kembali & Tambah Keperluan
        </a>
      </div>
      <?php endif ?>

      <div class="mb-6 flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-serif font-semibold text-gray-800">Area Duduk</h1>
          <p class="text-gray-600 text-sm">Tambah / Edit / Hapus area duduk</p>
        </div>
        <button id="btnAdd" class="bg-primary text-white px-4 py-2 rounded-lg flex items-center text-sm">
          <i class="ri-add-line mr-2"></i> Tambah Area
        </button>
      </div>

      <div class="card p-4">
        <div class="overflow-x-auto">
          <table class="w-full text-sm text-left" id="tbl">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
              <tr>
                <th class="px-4 py-3">No</th>
                <th class="px-4 py-3">Nama Area</th>
                <th class="px-4 py-3 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($areas as $i=>$r): ?>
              <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-3"><?= $i+1 ?></td>
                <td class="px-4 py-3 font-medium"><?= htmlspecialchars($r['nama_area']) ?></td>
                <td class="px-4 py-3 text-right space-x-2">
                  <button class="edit-btn text-gray-500 hover:text-primary"
                          data-id="<?= $r['id'] ?>"
                          data-nama="<?= htmlspecialchars($r['nama_area']) ?>">
                    <i class="ri-edit-line"></i>
                  </button>
                  <button class="delete-btn text-gray-500 hover:text-red-500"
                          data-id="<?= $r['id'] ?>">
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

  <div id="modal" class="modal">
    <div class="modal-content">
      <h2 id="modalTitle" class="text-xl font-medium text-gray-800 mb-4">Tambah Area</h2>
      <form id="form" method="post" class="space-y-4">
        <input type="hidden" name="action" id="actionInput" value="add">
        <input type="hidden" name="id"     id="idInput">
        <div>
          <label class="block text-sm font-medium text-gray-700">Nama Area</label>
          <input type="text" name="nama_area" id="namaInput" required
                 class="w-full p-2.5 border border-gray-200 rounded-lg text-sm">
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
          btnAdd     = document.getElementById('btnAdd'),
          btnCancel  = document.getElementById('btnCancel'),
          form       = document.getElementById('form'),
          actionIn   = document.getElementById('actionInput'),
          idIn       = document.getElementById('idInput'),
          namaIn     = document.getElementById('namaInput'),
          toast      = document.getElementById('toast'),
          toastMsg   = document.getElementById('toastMsg'),
          toastClose = document.getElementById('toastClose'),
          title      = document.getElementById('modalTitle');

    btnAdd.onclick = ()=>{
      actionIn.value='add'; idIn.value=''; form.reset();
      title.textContent='Tambah Area'; modal.style.display='block';
    };
    document.querySelectorAll('.edit-btn').forEach(b=>{
      b.onclick=()=>{
        actionIn.value='edit'; idIn.value=b.dataset.id;
        namaIn.value=b.dataset.nama;
        title.textContent='Edit Area'; modal.style.display='block';
      };
    });
    document.querySelectorAll('.delete-btn').forEach(b=>{
      b.onclick=()=>{
        if(!confirm('Hapus area ini?')) return;
        const f=document.createElement('form');
        f.method='post'; f.style.display='none';
        f.innerHTML =
          '<input name="action" value="delete">'+
          '<input name="id"     value="'+b.dataset.id+'">';
        document.body.appendChild(f);
        f.submit();
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
