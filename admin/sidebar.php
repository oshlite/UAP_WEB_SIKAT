<aside class="sidebar w-64 h-full flex-shrink-0 hidden md:block overflow-y-auto bg-white shadow-md">
  <div class="p-4 flex items-center justify-center border-b border-gray-100">
    <span class="font-script text-2xl text-yellow-500">SIKAT</span>
  </div>
  <div class="py-4">
    <div class="px-4 py-2 text-xs text-gray-400 uppercase font-semibold">Menu Utama</div>

    <a href="eoadmin_dashboard.php" class="nav-item flex items-center px-4 py-3 <?= $currentPage == 'eoadmin_dashboard.php' ? 'bg-yellow-100 border-l-4 border-yellow-400 text-gray-900 font-semibold' : 'text-gray-700' ?>">
      <div class="w-6 h-6 flex items-center justify-center mr-3"><i class="ri-dashboard-line"></i></div>
      <span>Dashboard</span>
    </a>

    <a href="DaftarTamu(admin).php" class="nav-item flex items-center px-4 py-3 <?= $currentPage == 'DaftarTamu(admin).php' ? 'bg-yellow-100 border-l-4 border-yellow-400 text-gray-900 font-semibold' : 'text-gray-700' ?>">
      <div class="w-6 h-6 flex items-center justify-center mr-3"><i class="ri-user-3-line"></i></div>
      <span>Manajemen Tamu</span>
    </a>

    <a href="keperluan.php" class="nav-item flex items-center px-4 py-3 <?= $currentPage == 'keperluan.php' ? 'bg-yellow-100 border-l-4 border-yellow-400 text-gray-900 font-semibold' : 'text-gray-700' ?>">
      <div class="w-6 h-6 flex items-center justify-center mr-3"><i class="ri-file-list-3-line"></i></div>
      <span>Keperluan Kunjungan</span>
    </a>

    <a href="area.php" class="nav-item flex items-center px-4 py-3 <?= $currentPage == 'area.php' ? 'bg-yellow-100 border-l-4 border-yellow-400 text-gray-900 font-semibold' : 'text-gray-700' ?>">
      <div class="w-6 h-6 flex items-center justify-center mr-3"><i class="ri-map-pin-line"></i></div>
      <span>Area Duduk</span>
    </a>

    <a href="petugas.php" class="nav-item flex items-center px-4 py-3 <?= $currentPage == 'petugas.php' ? 'bg-yellow-100 border-l-4 border-yellow-400 text-gray-900 font-semibold' : 'text-gray-700' ?>">
      <div class="w-6 h-6 flex items-center justify-center mr-3"><i class="ri-team-line"></i></div>
      <span>Petugas</span>
    </a>

    <div class="px-4 py-2 mt-4 text-xs text-gray-400 uppercase font-semibold">Pengaturan</div>

    <a href="pengguna.php" class="nav-item flex items-center px-4 py-3 <?= $currentPage == 'pengguna.php' ? 'bg-yellow-100 border-l-4 border-yellow-400 text-gray-900 font-semibold' : 'text-gray-700' ?>">
      <div class="w-6 h-6 flex items-center justify-center mr-3"><i class="ri-user-settings-line"></i></div>
      <span>Pengguna</span>
    </a>

    <a href="../logout.php" class="nav-item flex items-center px-4 py-3 <?= $currentPage == 'logout.php' ? 'bg-yellow-100 border-l-4 border-yellow-400 text-gray-900 font-semibold' : 'text-gray-700' ?>">
      <div class="w-6 h-6 flex items-center justify-center mr-3"><i class="ri-settings-3-line"></i></div>
      <span>Logout</span>
    </a>
  </div>
</aside>
