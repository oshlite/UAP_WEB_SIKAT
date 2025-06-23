<div class="w-64 bg-white shadow-md hidden md:block">
  <div class="p-4 flex items-center">
    <h1 class="text-2xl font-['Pacifico'] text-primary">SIKAT</h1>
    <span class="ml-2 text-xs bg-secondary bg-opacity-30 text-gray-700 px-2 py-1 rounded-full">User Pengantin</span>
  </div>
  <div class="mt-6">
    <?php 
    $menu=[
      ['label'=>'Dashboard', 'icon'=>'ri-dashboard-line', 'href'=>'userpengantin_dashboard.php'],
      ['label'=>'Manajemen Tamu', 'icon'=>'ri-user-3-line', 'href'=>'user_tamuprio.php'],
      ['label'=>'Keperluan Kunjungan', 'icon'=>'ri-question-answer-line', 'href'=>'user_keperluankunjungan.php'],
      ['label'=>'Area Duduk', 'icon'=>'ri-map-pin-line', 'href'=>'user_areaduduk.php'],
      ['label'=>'Petugas', 'icon'=>'ri-team-line', 'href'=>'user_kelolapetugas.php'],
      ['label'=>'Laporan', 'icon'=>'ri-file-chart-line', 'href'=>'userpengantin_dashboard.php?export=1'],
      ['label'=>'Logout', 'icon'=>'ri-logout-box-r-line', 'href'=>'logout.php'],
    ];
    $current = basename($_SERVER['PHP_SELF']);
    foreach($menu as $item):
      $active = ($current == $item['href']) ? ' active' : '';
    ?>
    <a href="<?= $item['href'] ?>" class="sidebar-item<?= $active ?> px-4 py-3 flex items-center">
      <div class="w-8 h-8 flex items-center justify-center text-<?= $active?'primary':'gray-600' ?>">
        <i class="<?= $item['icon'] ?> ri-lg"></i>
      </div>
      <span class="ml-2 text-gray-800"><?= $item['label'] ?></span>
    </a>
    <?php endforeach; ?>
  </div>
  <div class="mt-auto p-4 border-t">
    <div class="flex items-center">
      <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
        <i class="ri-user-line ri-lg"></i>
      </div>
      <div class="ml-3">
        <p class="text-sm font-medium text-gray-800">Pengantin A & B</p>
        <p class="text-xs text-gray-500">User Pengantin</p>
      </div>
      <div class="ml-auto w-8 h-8 flex items-center justify-center">
        <i class="ri-logout-box-r-line text-gray-500"></i>
      </div>
    </div>
  </div>
</div>
