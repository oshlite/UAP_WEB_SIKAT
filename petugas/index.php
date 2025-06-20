<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIKAT - Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>tailwind.config={theme:{extend:{colors:{primary:'#FFD700',secondary:'#FFDAB9'},borderRadius:{'none':'0px','sm':'4px',DEFAULT:'8px','md':'12px','lg':'16px','xl':'20px','2xl':'24px','3xl':'32px','full':'9999px','button':'8px'}}}}</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.5.0/echarts.min.js"></script>
    <style>
        :where([class^="ri-"])::before { content: "\f3c2"; }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FFFCF7;
        }
        .heading-font {
            font-family: 'Playfair Display', serif;
        }
        .logo-font {
            font-family: 'Pacifico', serif;
        }
        .card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }
        .sidebar-item {
            transition: all 0.2s ease;
        }
        .sidebar-item:hover {
            background-color: rgba(255, 215, 0, 0.1);
        }
        .sidebar-item.active {
            background-color: rgba(255, 215, 0, 0.2);
            border-right: 3px solid #FFD700;
        }
        .custom-switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 24px;
        }
        .custom-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #e2e8f0;
            transition: .4s;
            border-radius: 24px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #FFD700;
        }
        input:checked + .slider:before {
            transform: translateX(22px);
        }
        .batik-accent {
            position: absolute;
            width: 60px;
            height: 60px;
            opacity: 0.1;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0C13.4315 0 0 13.4315 0 30C0 46.5685 13.4315 60 30 60C46.5685 60 60 46.5685 60 30C60 13.4315 46.5685 0 30 0ZM30 15C37.1797 15 43 20.8203 43 28C43 35.1797 37.1797 41 30 41C22.8203 41 17 35.1797 17 28C17 20.8203 22.8203 15 30 15ZM30 19C25.0294 19 21 23.0294 21 28C21 32.9706 25.0294 37 30 37C34.9706 37 39 32.9706 39 28C39 23.0294 34.9706 19 30 19Z' fill='%23FFD700'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-size: contain;
        }
        .custom-checkbox {
            appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #d1d5db;
            border-radius: 4px;
            background-color: white;
            cursor: pointer;
            position: relative;
        }
        .custom-checkbox:checked {
            background-color: #FFD700;
            border-color: #FFD700;
        }
        .custom-checkbox:checked::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        .custom-radio {
            appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #d1d5db;
            border-radius: 50%;
            background-color: white;
            cursor: pointer;
            position: relative;
        }
        .custom-radio:checked {
            border-color: #FFD700;
        }
        .custom-radio:checked::after {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #FFD700;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            min-width: 200px;
            z-index: 50;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        .table-row:hover {
            background-color: rgba(255, 215, 0, 0.05);
        }
        input[type="range"] {
            -webkit-appearance: none;
            width: 100%;
            height: 6px;
            background: #e2e8f0;
            border-radius: 5px;
            outline: none;
        }
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #FFD700;
            cursor: pointer;
        }
        input[type="range"]::-moz-range-thumb {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #FFD700;
            cursor: pointer;
            border: none;
        }
    </style>
</head>
<body>
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 border-r border-gray-200">
                <div class="flex items-center justify-center h-16 px-4 border-b border-gray-200 bg-white">
                    <h1 class="text-2xl font-bold logo-font text-primary">SIKAT</h1>
                </div>
                <div class="flex flex-col flex-grow overflow-y-auto bg-white">
                    <div class="px-4 py-5">
                        <div class="flex flex-col items-center mb-6">
                            <div class="relative w-20 h-20 mb-3">
                                <img class="rounded-full object-cover w-full h-full" src="https://readdy.ai/api/search-image?query=professional%20portrait%20of%20Indonesian%20man%20in%20formal%20attire%2C%20wearing%20batik%2C%20warm%20lighting%2C%20professional%20headshot%2C%20high%20quality&width=200&height=200&seq=admin1&orientation=squarish" alt="Admin">
                                <div class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-2 border-white rounded-full"></div>
                            </div>
                            <h2 class="text-sm font-semibold">Budi Santoso</h2>
                            <p class="text-xs text-gray-500">Admin EO</p>
                        </div>
                    </div>
                    <nav class="flex-1 px-2 pb-4">
                        <div class="space-y-1">
                            <a href="#" class="sidebar-item active flex items-center px-3 py-2 text-sm font-medium rounded-md group">
                                <div class="w-6 h-6 mr-3 flex items-center justify-center text-primary">
                                    <i class="ri-dashboard-line ri-lg"></i>
                                </div>
                                <span>Dashboard</span>
                            </a>
                            <a href="bukuTamu.php" class="sidebar-item flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md group">
                                <div class="w-6 h-6 mr-3 flex items-center justify-center text-gray-500">
                                    <i class="ri-user-3-line ri-lg"></i>
                                </div>
                                <span>Buku Tamu</span>
                            </a>
                            <a href="#" class="sidebar-item flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md group">
                                <div class="w-6 h-6 mr-3 flex items-center justify-center text-gray-500">
                                    <i class="ri-file-list-3-line ri-lg"></i>
                                </div>
                                <span>Daftar Tamu</span>
                            </a>
                            <a href="filter.php" class="sidebar-item flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md group">
                                <div class="w-6 h-6 mr-3 flex items-center justify-center text-gray-500">
                                    <i class="ri-map-pin-line ri-lg"></i>
                                </div>
                                <span>Filter & Pencarian</span>
                            </a>
                            <a href="#" class="sidebar-item flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md group">
                                <div class="w-6 h-6 mr-3 flex items-center justify-center text-gray-500">
                                    <i class="ri-settings-3-line ri-lg"></i>
                                </div>
                                <span>Logout</span>
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white border-b border-gray-200">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <!-- Mobile menu button -->
                        <div class="flex items-center md:hidden">
                            <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary">
                                <i class="ri-menu-line ri-lg"></i>
                            </button>
                        </div>
                        
                        <!-- Search bar -->
                        <div class="flex-1 flex justify-center md:justify-start">
                            <div class="w-full max-w-lg lg:max-w-xs relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="ri-search-line text-gray-400"></i>
                                </div>
                                <input class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-gray-50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-primary focus:ring-1 focus:ring-primary text-sm" placeholder="Cari tamu, area, atau petugas..." type="search">
                            </div>
                        </div>
                        
                        <!-- Right side buttons -->
                        <div class="flex items-center space-x-4">
                            <!-- Date display -->
                            <div class="hidden md:flex items-center text-sm text-gray-500">
                                <i class="ri-calendar-line mr-1"></i>
                                <span>09 Juni 2025</span>
                            </div>
                            
                            <!-- Notifications -->
                            <div class="relative">
                                <button class="p-1 text-gray-400 rounded-full hover:bg-gray-100 focus:outline-none">
                                    <div class="w-8 h-8 flex items-center justify-center relative">
                                        <i class="ri-notification-3-line ri-lg"></i>
                                        <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500"></span>
                                    </div>
                                </button>
                            </div>
                            
                            <!-- Profile dropdown -->
                            <div class="relative dropdown">
                                <button class="flex items-center max-w-xs text-sm rounded-full focus:outline-none">
                                    <img class="h-8 w-8 rounded-full object-cover" src="https://readdy.ai/api/search-image?query=professional%20portrait%20of%20Indonesian%20man%20in%20formal%20attire%2C%20wearing%20batik%2C%20warm%20lighting%2C%20professional%20headshot%2C%20high%20quality&width=200&height=200&seq=admin1&orientation=squarish" alt="Admin">
                                </button>
                                <div class="dropdown-content mt-2 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Anda</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan</a>
                                    <div class="border-t border-gray-100"></div>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Keluar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Breadcrumb -->
                <div class="px-4 sm:px-6 lg:px-8 py-2 bg-gray-50 border-b border-gray-200">
                    <div class="flex items-center space-x-2 text-sm text-gray-500">
                        <a href="#" class="hover:text-primary">Beranda</a>
                        <i class="ri-arrow-right-s-line"></i>
                        <span class="font-medium text-gray-700">Dashboard</span>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-4 sm:p-6 lg:p-8">
                <!-- Page Header -->
                <div class="mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h1 class="text-2xl font-bold heading-font text-gray-900">Dashboard</h1>
                            <p class="mt-1 text-sm text-gray-500">Selamat datang di Sistem Informasi Kunjungan Tamu Andalan</p>
                        </div>
                        <div class="mt-4 md:mt-0 flex space-x-3">
                            <button class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-button bg-white text-gray-700 hover:bg-gray-50 whitespace-nowrap">
                                <i class="ri-calendar-line mr-2"></i>
                                Pilih Tanggal
                            </button>
                            <button class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-button text-white bg-primary hover:bg-yellow-500 whitespace-nowrap">
                                <i class="ri-add-line mr-2"></i>
                                Tambah Tamu
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <!-- Total Tamu Hari Ini -->
                    <div class="card p-5 relative overflow-hidden">
                        <div class="batik-accent top-0 right-0"></div>
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-primary bg-opacity-10 text-primary">
                                <i class="ri-user-3-line ri-lg"></i>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-500">Total Tamu Hari Ini</h2>
                                <p class="text-2xl font-bold text-gray-900">127</p>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-xs text-green-600">
                            <i class="ri-arrow-up-line mr-1"></i>
                            <span>12% lebih tinggi dari kemarin</span>
                        </div>
                    </div>

                    <!-- Tamu Terdaftar -->
                    <div class="card p-5 relative overflow-hidden">
                        <div class="batik-accent top-0 right-0"></div>
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-secondary bg-opacity-20 text-orange-500">
                                <i class="ri-user-add-line ri-lg"></i>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-500">Tamu Terdaftar</h2>
                                <p class="text-2xl font-bold text-gray-900">1,843</p>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-xs text-green-600">
                            <i class="ri-arrow-up-line mr-1"></i>
                            <span>5% lebih tinggi dari minggu lalu</span>
                        </div>
                    </div>

                    <!-- Area Tersedia -->
                    <div class="card p-5 relative overflow-hidden">
                        <div class="batik-accent top-0 right-0"></div>
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-green-100 text-green-600">
                                <i class="ri-map-pin-line ri-lg"></i>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-500">Area Tersedia</h2>
                                <p class="text-2xl font-bold text-gray-900">6/8</p>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-xs text-yellow-600">
                            <i class="ri-information-line mr-1"></i>
                            <span>2 area hampir penuh</span>
                        </div>
                    </div>

                    <!-- Petugas Aktif -->
                    <div class="card p-5 relative overflow-hidden">
                        <div class="batik-accent top-0 right-0"></div>
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-blue-100 text-blue-600">
                                <i class="ri-team-line ri-lg"></i>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-500">Petugas Aktif</h2>
                                <p class="text-2xl font-bold text-gray-900">12</p>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-xs text-gray-600">
                            <i class="ri-time-line mr-1"></i>
                            <span>4 petugas di pintu masuk</span>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Visitor Chart -->
                    <div class="card p-5 lg:col-span-2 relative overflow-hidden">
                        <div class="batik-accent top-0 right-0"></div>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium heading-font">Statistik Kunjungan</h3>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 text-xs font-medium rounded-full bg-primary bg-opacity-10 text-primary">Hari Ini</button>
                                <button class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700">Minggu Ini</button>
                                <button class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700">Bulan Ini</button>
                            </div>
                        </div>
                        <div id="visitor-chart" class="h-64"></div>
                    </div>

                    <!-- Area Distribution -->
                    <div class="card p-5 relative overflow-hidden">
                        <div class="batik-accent top-0 right-0"></div>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium heading-font">Distribusi Area</h3>
                            <button class="text-sm text-gray-500 hover:text-primary">
                                <i class="ri-more-2-fill"></i>
                            </button>
                        </div>
                        <div id="area-chart" class="h-64"></div>
                    </div>
                </div>

                <!-- Recent Guests Table -->
                <div class="card p-5 mb-6 relative overflow-hidden">
                    <div class="batik-accent top-0 right-0"></div>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium heading-font">Tamu Terbaru</h3>
                        <div class="flex items-center space-x-2">
                            <div class="relative">
                                <select class="appearance-none pl-3 pr-8 py-1 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary text-sm">
                                    <option>Semua Keperluan</option>
                                    <option>Keluarga</option>
                                    <option>Teman</option>
                                    <option>Rekan</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <i class="ri-arrow-down-s-line"></i>
                                </div>
                            </div>
                            <button class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm font-medium rounded-button bg-white text-gray-700 hover:bg-gray-50 whitespace-nowrap">
                                <i class="ri-download-line mr-1"></i>
                                Export
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tamu</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keperluan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Area Duduk</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Kedatangan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Petugas</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="table-row">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover" src="https://readdy.ai/api/search-image?query=portrait%20of%20Indonesian%20woman%20in%20elegant%20dress%2C%20warm%20lighting%2C%20professional%20headshot%2C%20high%20quality&width=100&height=100&seq=guest1&orientation=squarish" alt="Guest">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Ratna Dewi</div>
                                                <div class="text-sm text-gray-500">Luar Provinsi</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Keluarga</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Meja Keluarga Wanita</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">09 Jun 2025, 10:15</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Siti Nurhaliza</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hadir</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <button class="text-indigo-600 hover:text-indigo-900">
                                                <i class="ri-edit-line"></i>
                                            </button>
                                            <button class="text-red-600 hover:text-red-900">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="table-row">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover" src="https://readdy.ai/api/search-image?query=portrait%20of%20Indonesian%20man%20in%20formal%20attire%2C%20wearing%20batik%2C%20warm%20lighting%2C%20professional%20headshot%2C%20high%20quality&width=100&height=100&seq=guest2&orientation=squarish" alt="Guest">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Agus Widodo</div>
                                                <div class="text-sm text-gray-500">Jakarta</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Rekan</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Meja VIP</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">09 Jun 2025, 10:08</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Bambang Sutrisno</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hadir</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <button class="text-indigo-600 hover:text-indigo-900">
                                                <i class="ri-edit-line"></i>
                                            </button>
                                            <button class="text-red-600 hover:text-red-900">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="table-row">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover" src="https://readdy.ai/api/search-image?query=portrait%20of%20Indonesian%20woman%20in%20elegant%20kebaya%2C%20warm%20lighting%2C%20professional%20headshot%2C%20high%20quality&width=100&height=100&seq=guest3&orientation=squarish" alt="Guest">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Maya Anggraini</div>
                                                <div class="text-sm text-gray-500">Surabaya</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Teman</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Meja Tamu Luar Provinsi</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">09 Jun 2025, 09:55</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Dewi Safitri</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hadir</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <button class="text-indigo-600 hover:text-indigo-900">
                                                <i class="ri-edit-line"></i>
                                            </button>
                                            <button class="text-red-600 hover:text-red-900">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="table-row">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover" src="https://readdy.ai/api/search-image?query=portrait%20of%20Indonesian%20man%20in%20traditional%20formal%20attire%2C%20warm%20lighting%2C%20professional%20headshot%2C%20high%20quality&width=100&height=100&seq=guest4&orientation=squarish" alt="Guest">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Hendra Wijaya</div>
                                                <div class="text-sm text-gray-500">Bandung</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Keluarga</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Meja Keluarga Pria</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">09 Jun 2025, 09:47</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rudi Hartono</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hadir</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <button class="text-indigo-600 hover:text-indigo-900">
                                                <i class="ri-edit-line"></i>
                                            </button>
                                            <button class="text-red-600 hover:text-red-900">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="table-row">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover" src="https://readdy.ai/api/search-image?query=portrait%20of%20Indonesian%20woman%20in%20modern%20formal%20attire%2C%20warm%20lighting%2C%20professional%20headshot%2C%20high%20quality&width=100&height=100&seq=guest5&orientation=squarish" alt="Guest">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Anisa Rahma</div>
                                                <div class="text-sm text-gray-500">Yogyakarta</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Komunitas</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Meja Komunitas</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">09 Jun 2025, 09:30</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rina Marlina</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hadir</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <button class="text-indigo-600 hover:text-indigo-900">
                                                <i class="ri-edit-line"></i>
                                            </button>
                                            <button class="text-red-600 hover:text-red-900">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <div class="text-sm text-gray-500">
                            Menampilkan 5 dari 127 tamu
                        </div>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50 whitespace-nowrap">
                                <i class="ri-arrow-left-s-line"></i>
                                Sebelumnya
                            </button>
                            <button class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50 whitespace-nowrap">
                                Selanjutnya
                                <i class="ri-arrow-right-s-line"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Bottom Cards -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Quick Actions -->
                    <div class="card p-5 relative overflow-hidden">
                        <div class="batik-accent top-0 right-0"></div>
                        <h3 class="text-lg font-medium heading-font mb-4">Aksi Cepat</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <button class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-primary bg-opacity-10 text-primary mb-2">
                                    <i class="ri-user-add-line ri-lg"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Tambah Tamu</span>
                            </button>
                            <button class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 mb-2">
                                    <i class="ri-map-pin-add-line ri-lg"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Tambah Area</span>
                            </button>
                            <button class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-green-100 text-green-600 mb-2">
                                    <i class="ri-file-list-3-line ri-lg"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Tambah Keperluan</span>
                            </button>
                            <button class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-purple-100 text-purple-600 mb-2">
                                    <i class="ri-team-line ri-lg"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Tambah Petugas</span>
                            </button>
                            <button class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-yellow-100 text-yellow-600 mb-2">
                                    <i class="ri-file-chart-line ri-lg"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Lihat Laporan</span>
                            </button>
                            <button class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-red-100 text-red-600 mb-2">
                                    <i class="ri-settings-3-line ri-lg"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Pengaturan</span>
                            </button>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="card p-5 relative overflow-hidden">
                        <div class="batik-accent top-0 right-0"></div>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium heading-font">Aktivitas Terbaru</h3>
                            <button class="text-sm text-primary hover:underline">Lihat Semua</button>
                        </div>
                        <div class="space-y-4">
                            <div class="flex">
                                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-600">
                                    <i class="ri-user-add-line"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-700">
                                        <span class="font-medium">Siti Nurhaliza</span> menambahkan tamu baru 
                                        <span class="font-medium">Ratna Dewi</span>
                                    </p>
                                    <p class="text-xs text-gray-500">5 menit yang lalu</p>
                                </div>
                            </div>
                            <div class="flex">
                                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-green-100 text-green-600">
                                    <i class="ri-edit-line"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-700">
                                        <span class="font-medium">Bambang Sutrisno</span> mengubah area duduk untuk 
                                        <span class="font-medium">Agus Widodo</span>
                                    </p>
                                    <p class="text-xs text-gray-500">15 menit yang lalu</p>
                                </div>
                            </div>
                            <div class="flex">
                                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-yellow-100 text-yellow-600">
                                    <i class="ri-map-pin-add-line"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-700">
                                        <span class="font-medium">Budi Santoso</span> menambahkan area baru 
                                        <span class="font-medium">Meja Komunitas</span>
                                    </p>
                                    <p class="text-xs text-gray-500">1 jam yang lalu</p>
                                </div>
                            </div>
                            <div class="flex">
                                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-red-100 text-red-600">
                                    <i class="ri-delete-bin-line"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-700">
                                        <span class="font-medium">Dewi Safitri</span> menghapus data tamu ganda
                                    </p>
                                    <p class="text-xs text-gray-500">2 jam yang lalu</p>
                                </div>
                            </div>
                            <div class="flex">
                                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-purple-100 text-purple-600">
                                    <i class="ri-file-chart-line"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-700">
                                        <span class="font-medium">Rudi Hartono</span> mengekspor laporan tamu
                                    </p>
                                    <p class="text-xs text-gray-500">3 jam yang lalu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script id="charts-initialization">
        document.addEventListener('DOMContentLoaded', function() {
            // Visitor Chart
            const visitorChart = echarts.init(document.getElementById('visitor-chart'));
            const visitorOption = {
                animation: false,
                color: ['rgba(87, 181, 231, 1)'],
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: 'rgba(255, 255, 255, 0.8)',
                    borderColor: '#e2e8f0',
                    borderWidth: 1,
                    textStyle: {
                        color: '#1f2937'
                    }
                },
                grid: {
                    top: 10,
                    right: 10,
                    bottom: 30,
                    left: 40
                },
                xAxis: {
                    type: 'category',
                    data: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00'],
                    axisLine: {
                        lineStyle: {
                            color: '#e2e8f0'
                        }
                    },
                    axisLabel: {
                        color: '#1f2937'
                    }
                },
                yAxis: {
                    type: 'value',
                    axisLine: {
                        show: false
                    },
                    axisTick: {
                        show: false
                    },
                    splitLine: {
                        lineStyle: {
                            color: '#e2e8f0'
                        }
                    },
                    axisLabel: {
                        color: '#1f2937'
                    }
                },
                series: [{
                    name: 'Jumlah Tamu',
                    type: 'line',
                    smooth: true,
                    symbol: 'none',
                    lineStyle: {
                        width: 3
                    },
                    areaStyle: {
                        color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                            { offset: 0, color: 'rgba(87, 181, 231, 0.3)' },
                            { offset: 1, color: 'rgba(87, 181, 231, 0.05)' }
                        ])
                    },
                    data: [12, 25, 45, 32, 28, 35, 42, 38, 25, 18, 30, 20]
                }]
            };
            visitorChart.setOption(visitorOption);

            // Area Distribution Chart
            const areaChart = echarts.init(document.getElementById('area-chart'));
            const areaOption = {
                animation: false,
                color: [
                    'rgba(87, 181, 231, 1)',
                    'rgba(141, 211, 199, 1)',
                    'rgba(251, 191, 114, 1)',
                    'rgba(252, 141, 98, 1)',
                    'rgba(190, 186, 218, 1)'
                ],
                tooltip: {
                    trigger: 'item',
                    backgroundColor: 'rgba(255, 255, 255, 0.8)',
                    borderColor: '#e2e8f0',
                    borderWidth: 1,
                    textStyle: {
                        color: '#1f2937'
                    }
                },
                series: [{
                    name: 'Distribusi Area',
                    type: 'pie',
                    radius: ['40%', '70%'],
                    center: ['50%', '50%'],
                    avoidLabelOverlap: false,
                    itemStyle: {
                        borderRadius: 8,
                        borderColor: '#fff',
                        borderWidth: 2
                    },
                    label: {
                        show: false
                    },
                    emphasis: {
                        label: {
                            show: true,
                            formatter: '{b}: {c} ({d}%)',
                            fontSize: 12,
                            fontWeight: 'bold'
                        }
                    },
                    labelLine: {
                        show: false
                    },
                    data: [
                        { value: 35, name: 'Meja Keluarga Wanita' },
                        { value: 30, name: 'Meja Keluarga Pria' },
                        { value: 20, name: 'Meja VIP' },
                        { value: 15, name: 'Meja Tamu Luar Provinsi' },
                        { value: 10, name: 'Meja Komunitas' }
                    ]
                }]
            };
            areaChart.setOption(areaOption);
            // Handle window resize
            window.addEventListener('resize', function() {
                visitorChart.resize();
                areaChart.resize();
            });
        });
    </script>

    <script id="mobile-menu-toggle">
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('button[aria-label="mobile-menu"]');
            if (mobileMenuButton) {
                const sidebar = document.querySelector('.md\\:flex-shrink-0');
                mobileMenuButton.addEventListener('click', function() {
                    if (sidebar.classList.contains('hidden')) {
                        sidebar.classList.remove('hidden');
                    } else {
                        sidebar.classList.add('hidden');
                    }
                });
            }
        });
    </script>
    <script id="form-controls">
        document.addEventListener('DOMContentLoaded', function() {
            // Custom checkbox functionality
            const customCheckboxes = document.querySelectorAll('.custom-checkbox');
            customCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('click', function() {
                    this.checked = !this.checked;
                });
            });

            // Custom radio functionality
            const customRadios = document.querySelectorAll('.custom-radio');
            customRadios.forEach(radio => {
                radio.addEventListener('click', function() {
                    const name = this.getAttribute('name');
                    if (name) {
                        document.querySelectorAll(`.custom-radio[name="${name}"]`).forEach(r => {
                            r.checked = false;
                        });
                        this.checked = true;
                    }
                });
            });

            // Custom switch functionality
            const customSwitches = document.querySelectorAll('.custom-switch input');
            customSwitches.forEach(switchInput => {
                switchInput.addEventListener('change', function() {
                    // Additional functionality can be added here
                });
            });
        });
    </script>
</body>
</html>

