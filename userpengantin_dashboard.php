<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIKAT</title>
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
            background-color: #FFFAF0;
        }
        .font-serif {
            font-family: 'Playfair Display', serif;
        }
        .sidebar {
            background-color: white;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }
        .card {
            background-color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.08);
        }
        .batik-accent {
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M20 20.5C20 18.0147 22.0147 16 24.5 16C26.9853 16 29 18.0147 29 20.5C29 22.9853 26.9853 25 24.5 25C22.0147 25 20 22.9853 20 20.5ZM11 20.5C11 18.0147 13.0147 16 15.5 16C17.9853 16 20 18.0147 20 20.5C20 22.9853 17.9853 25 15.5 25C13.0147 25 11 22.9853 11 20.5ZM24.5 11C22.0147 11 20 13.0147 20 15.5C20 17.9853 22.0147 20 24.5 20C26.9853 20 29 17.9853 29 15.5C29 13.0147 26.9853 11 24.5 11ZM15.5 11C13.0147 11 11 13.0147 11 15.5C11 17.9853 13.0147 20 15.5 20C17.9853 20 20 17.9853 20 15.5C20 13.0147 17.9853 11 15.5 11Z' fill='%23FFD700' fill-opacity='0.1'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: bottom right;
        }
        .nav-item {
            transition: all 0.2s ease;
        }
        .nav-item:hover {
            background-color: rgba(255, 215, 0, 0.1);
        }
        .nav-item.active {
            background-color: rgba(255, 215, 0, 0.15);
            border-left: 3px solid #FFD700;
        }
        table thead th {
            background-color: rgba(255, 215, 0, 0.1);
        }
        .custom-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }
        .custom-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .switch-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        .switch-slider:before {
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
        input:checked + .switch-slider {
            background-color: #FFD700;
        }
        input:checked + .switch-slider:before {
            transform: translateX(20px);
        }
        input[type="search"]::-webkit-search-decoration,
        input[type="search"]::-webkit-search-cancel-button,
        input[type="search"]::-webkit-search-results-button,
        input[type="search"]::-webkit-search-results-decoration {
            display: none;
        }
        input[type="date"]::-webkit-calendar-picker-indicator {
            background: transparent;
            bottom: 0;
            color: transparent;
            cursor: pointer;
            height: auto;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            width: auto;
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
                            <a href="#" class="sidebar-item flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md group">
                                <div class="w-6 h-6 mr-3 flex items-center justify-center text-gray-500">
                                    <i class="ri-user-3-line ri-lg"></i>
                                </div>
                                <span>Manajemen Tamu</span>
                            </a>
                            <a href="#" class="sidebar-item flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md group">
                                <div class="w-6 h-6 mr-3 flex items-center justify-center text-gray-500">
                                    <i class="ri-file-list-3-line ri-lg"></i>
                                </div>
                                <span>Keperluan Kunjungan</span>
                            </a>
                            <a href="#" class="sidebar-item flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md group">
                                <div class="w-6 h-6 mr-3 flex items-center justify-center text-gray-500">
                                    <i class="ri-map-pin-line ri-lg"></i>
                                </div>
                                <span>Area Duduk</span>
                            </a>
                            <a href="#" class="sidebar-item flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md group">
                                <div class="w-6 h-6 mr-3 flex items-center justify-center text-gray-500">
                                    <i class="ri-team-line ri-lg"></i>
                                </div>
                                <span>Petugas</span>
                            </a>
                            <a href="#" class="sidebar-item flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md group">
                                <div class="w-6 h-6 mr-3 flex items-center justify-center text-gray-500">
                                    <i class="ri-user-settings-line ri-lg"></i>
                                </div>
                                <span>Pengguna</span>
                            </a>
                            <a href="#" class="sidebar-item flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md group">
                                <div class="w-6 h-6 mr-3 flex items-center justify-center text-gray-500">
                                    <i class="ri-bar-chart-line ri-lg"></i>
                                </div>
                                <span>Laporan</span>
                            </a>
                            <a href="#" class="sidebar-item flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md group">
                                <div class="w-6 h-6 mr-3 flex items-center justify-center text-gray-500">
                                    <i class="ri-settings-3-line ri-lg"></i>
                                </div>
                                <span>Pengaturan</span>
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white border-b border-gray-100 shadow-sm">
                <div class="flex items-center justify-between px-6 py-3">
                    <div class="flex items-center">
                        <button class="text-gray-500 md:hidden mr-4">
                            <div class="w-6 h-6 flex items-center justify-center">
                                <i class="ri-menu-line"></i>
                            </div>
                        </button>
                        <div class="flex items-center">
                            <div class="text-gray-700 font-medium">Dashboard</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="text-gray-500 relative">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <i class="ri-notification-3-line"></i>
                                </div>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
                            </button>
                        </div>
                        
                        <div class="relative">
                            <div class="flex items-center cursor-pointer">
                                <img src="https://readdy.ai/api/search-image?query=professional%20headshot%20of%20Indonesian%20wedding%20planner%2C%20male%2C%2030s%2C%20formal%20attire%2C%20neutral%20background%2C%20high%20quality%2C%20professional%20photo&width=100&height=100&seq=1&orientation=squarish" alt="Admin" class="w-8 h-8 rounded-full object-cover">
                                <span class="ml-2 text-sm font-medium text-gray-700">Budi Santoso</span>
                                <div class="w-5 h-5 flex items-center justify-center ml-1">
                                    <i class="ri-arrow-down-s-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="px-6 py-2 flex items-center text-sm">
                    <a href="#" class="text-gray-500">Dashboard</a>
                    <div class="w-4 h-4 flex items-center justify-center mx-1 text-gray-400">
                        <i class="ri-arrow-right-s-line"></i>
                    </div>
                    <span class="text-gray-700">Overview</span>
                </div>
            </header>
            
            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-2xl font-serif font-bold text-gray-800">Dashboard Overview</h1>
                        <p class="text-gray-600 mt-1">Selamat datang kembali, Budi Santoso</p>
                    </div>
                    
                    <div class="mt-4 md:mt-0 flex items-center space-x-3">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <div class="w-4 h-4 flex items-center justify-center text-gray-400">
                                    <i class="ri-calendar-line"></i>
                                </div>
                            </div>
                            <input type="date" class="bg-white border border-gray-200 text-gray-700 text-sm rounded-button pl-10 pr-4 py-2 focus:outline-none focus:ring-1 focus:ring-primary" value="2025-06-09">
                        </div>
                        
                        <button class="bg-primary text-white px-4 py-2 rounded-button flex items-center whitespace-nowrap">
                            <div class="w-4 h-4 flex items-center justify-center mr-2">
                                <i class="ri-download-line"></i>
                            </div>
                            Ekspor Data
                        </button>
                    </div>
                </div>
                
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="card rounded-md p-6 batik-accent">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Total Tamu Hari Ini</p>
                                <h3 class="text-2xl font-bold text-gray-800">187</h3>
                                <p class="text-xs text-green-600 mt-2 flex items-center">
                                    <div class="w-3 h-3 flex items-center justify-center mr-1">
                                        <i class="ri-arrow-up-line"></i>
                                    </div>
                                    <span>12.5% dari kemarin</span>
                                </p>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-primary bg-opacity-10 flex items-center justify-center text-primary">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <i class="ri-user-3-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card rounded-md p-6 batik-accent">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Tamu Terdaftar</p>
                                <h3 class="text-2xl font-bold text-gray-800">432</h3>
                                <p class="text-xs text-green-600 mt-2 flex items-center">
                                    <div class="w-3 h-3 flex items-center justify-center mr-1">
                                        <i class="ri-arrow-up-line"></i>
                                    </div>
                                    <span>8.3% minggu ini</span>
                                </p>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-blue-500 bg-opacity-10 flex items-center justify-center text-blue-500">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <i class="ri-group-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card rounded-md p-6 batik-accent">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Area Tersedia</p>
                                <h3 class="text-2xl font-bold text-gray-800">6/8</h3>
                                <p class="text-xs text-yellow-600 mt-2 flex items-center">
                                    <div class="w-3 h-3 flex items-center justify-center mr-1">
                                        <i class="ri-information-line"></i>
                                    </div>
                                    <span>2 area hampir penuh</span>
                                </p>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-green-500 bg-opacity-10 flex items-center justify-center text-green-500">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <i class="ri-map-pin-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card rounded-md p-6 batik-accent">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Petugas Aktif</p>
                                <h3 class="text-2xl font-bold text-gray-800">12</h3>
                                <p class="text-xs text-red-600 mt-2 flex items-center">
                                    <div class="w-3 h-3 flex items-center justify-center mr-1">
                                        <i class="ri-arrow-down-line"></i>
                                    </div>
                                    <span>1 tidak hadir</span>
                                </p>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-purple-500 bg-opacity-10 flex items-center justify-center text-purple-500">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <i class="ri-team-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Charts Row -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <div class="card rounded-md p-6 lg:col-span-2">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-800">Statistik Kunjungan Tamu</h3>
                            <div class="flex space-x-2">
                                <button class="text-xs px-3 py-1 rounded-full bg-primary bg-opacity-10 text-primary">Hari Ini</button>
                                <button class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-600">Minggu Ini</button>
                                <button class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-600">Bulan Ini</button>
                            </div>
                        </div>
                        <div id="visitChart" class="w-full h-64"></div>
                    </div>
                    
                    <div class="card rounded-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-800">Distribusi Area Duduk</h3>
                            <button class="text-gray-400 hover:text-gray-600">
                                <div class="w-5 h-5 flex items-center justify-center">
                                    <i class="ri-more-2-fill"></i>
                                </div>
                            </button>
                        </div>
                        <div id="areaChart" class="w-full h-64"></div>
                    </div>
                </div>
                
                <!-- Recent Guests Table -->
                <div class="card rounded-md overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <h3 class="text-lg font-medium text-gray-800">Daftar Tamu Terbaru</h3>
                            
                            <div class="mt-4 md:mt-0 flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-400">
                                            <i class="ri-search-line"></i>
                                        </div>
                                    </div>
                                    <input type="search" class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-button pl-10 pr-4 py-2 focus:outline-none focus:ring-1 focus:ring-primary w-full" placeholder="Cari tamu...">
                                </div>
                                
                                <div class="relative">
                                    <select class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-button px-4 py-2 pr-8 focus:outline-none focus:ring-1 focus:ring-primary appearance-none w-full">
                                        <option>Semua Area</option>
                                        <option>Meja Keluarga Wanita</option>
                                        <option>Meja Keluarga Pria</option>
                                        <option>Meja VIP</option>
                                        <option>Area Umum</option>
                                        <option>Meja Tamu Luar Provinsi</option>
                                        <option>Meja Komunitas</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-400">
                                            <i class="ri-arrow-down-s-line"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tamu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keperluan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Area Duduk</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Kedatangan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img src="https://readdy.ai/api/search-image?query=professional%20headshot%20of%20Indonesian%20woman%20in%20formal%20attire%2C%2040s%2C%20neutral%20background%2C%20high%20quality&width=40&height=40&seq=2&orientation=squarish" class="w-8 h-8 rounded-full object-cover mr-3">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Ratna Dewi</div>
                                                <div class="text-xs text-gray-500">Keluarga Wanita</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Keluarga</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Meja Keluarga Wanita</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">09 Jun 2025, 10:15</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hadir</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <div class="flex space-x-2">
                                            <button class="text-blue-600 hover:text-blue-800">
                                                <div class="w-5 h-5 flex items-center justify-center">
                                                    <i class="ri-edit-line"></i>
                                                </div>
                                            </button>
                                            <button class="text-red-600 hover:text-red-800">
                                                <div class="w-5 h-5 flex items-center justify-center">
                                                    <i class="ri-delete-bin-line"></i>
                                                </div>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img src="https://readdy.ai/api/search-image?query=professional%20headshot%20of%20Indonesian%20man%20in%20formal%20attire%2C%2035s%2C%20neutral%20background%2C%20high%20quality&width=40&height=40&seq=3&orientation=squarish" class="w-8 h-8 rounded-full object-cover mr-3">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Agus Purnomo</div>
                                                <div class="text-xs text-gray-500">Teman Pria</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Teman</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Area Umum</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">09 Jun 2025, 10:22</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hadir</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <div class="flex space-x-2">
                                            <button class="text-blue-600 hover:text-blue-800">
                                                <div class="w-5 h-5 flex items-center justify-center">
                                                    <i class="ri-edit-line"></i>
                                                </div>
                                            </button>
                                            <button class="text-red-600 hover:text-red-800">
                                                <div class="w-5 h-5 flex items-center justify-center">
                                                    <i class="ri-delete-bin-line"></i>
                                                </div>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img src="https://readdy.ai/api/search-image?query=professional%20headshot%20of%20Indonesian%20woman%20in%20formal%20attire%2C%2030s%2C%20neutral%20background%2C%20high%20quality&width=40&height=40&seq=4&orientation=squarish" class="w-8 h-8 rounded-full object-cover mr-3">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Siti Nurhayati</div>
                                                <div class="text-xs text-gray-500">Luar Provinsi</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Keluarga</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Meja Tamu Luar Provinsi</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">09 Jun 2025, 10:30</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hadir</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <div class="flex space-x-2">
                                            <button class="text-blue-600 hover:text-blue-800">
                                                <div class="w-5 h-5 flex items-center justify-center">
                                                    <i class="ri-edit-line"></i>
                                                </div>
                                            </button>
                                            <button class="text-red-600 hover:text-red-800">
                                                <div class="w-5 h-5 flex items-center justify-center">
                                                    <i class="ri-delete-bin-line"></i>
                                                </div>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img src="https://readdy.ai/api/search-image?query=professional%20headshot%20of%20Indonesian%20man%20in%20formal%20attire%2C%2050s%2C%20neutral%20background%2C%20high%20quality&width=40&height=40&seq=5&orientation=squarish" class="w-8 h-8 rounded-full object-cover mr-3">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Hendra Wijaya</div>
                                                <div class="text-xs text-gray-500">Keluarga Pria</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Keluarga</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Meja Keluarga Pria</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">09 Jun 2025, 10:45</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hadir</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <div class="flex space-x-2">
                                            <button class="text-blue-600 hover:text-blue-800">
                                                <div class="w-5 h-5 flex items-center justify-center">
                                                    <i class="ri-edit-line"></i>
                                                </div>
                                            </button>
                                            <button class="text-red-600 hover:text-red-800">
                                                <div class="w-5 h-5 flex items-center justify-center">
                                                    <i class="ri-delete-bin-line"></i>
                                                </div>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img src="https://readdy.ai/api/search-image?query=professional%20headshot%20of%20Indonesian%20woman%20in%20formal%20attire%2C%2045s%2C%20neutral%20background%2C%20high%20quality&width=40&height=40&seq=6&orientation=squarish" class="w-8 h-8 rounded-full object-cover mr-3">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Maya Indah</div>
                                                <div class="text-xs text-gray-500">Rekan Kerja</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rekan</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Meja VIP</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">09 Jun 2025, 11:05</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <div class="flex space-x-2">
                                            <button class="text-blue-600 hover:text-blue-800">
                                                <div class="w-5 h-5 flex items-center justify-center">
                                                    <i class="ri-edit-line"></i>
                                                </div>
                                            </button>
                                            <button class="text-red-600 hover:text-red-800">
                                                <div class="w-5 h-5 flex items-center justify-center">
                                                    <i class="ri-delete-bin-line"></i>
                                                </div>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Menampilkan 5 dari 187 tamu
                        </div>
                        
                        <div class="flex space-x-1">
                            <button class="px-3 py-1 rounded-button border border-gray-200 text-gray-500 text-sm">Sebelumnya</button>
                            <button class="px-3 py-1 rounded-button bg-primary text-white text-sm">1</button>
                            <button class="px-3 py-1 rounded-button border border-gray-200 text-gray-500 text-sm">2</button>
                            <button class="px-3 py-1 rounded-button border border-gray-200 text-gray-500 text-sm">3</button>
                            <button class="px-3 py-1 rounded-button border border-gray-200 text-gray-500 text-sm">Selanjutnya</button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script id="chartInitialization">
        document.addEventListener('DOMContentLoaded', function() {
            // Visitor Statistics Chart
            const visitChart = echarts.init(document.getElementById('visitChart'));
            const visitOption = {
                animation: false,
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: 'rgba(255, 255, 255, 0.8)',
                    borderColor: '#F0F0F0',
                    textStyle: {
                        color: '#1f2937'
                    }
                },
                grid: {
                    top: 10,
                    right: 10,
                    bottom: 20,
                    left: 40
                },
                xAxis: {
                    type: 'category',
                    data: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00'],
                    axisLine: {
                        lineStyle: {
                            color: '#E5E7EB'
                        }
                    },
                    axisLabel: {
                        color: '#6B7280'
                    }
                },
                yAxis: {
                    type: 'value',
                    axisLine: {
                        show: false
                    },
                    axisLabel: {
                        color: '#6B7280'
                    },
                    splitLine: {
                        lineStyle: {
                            color: '#F3F4F6'
                        }
                    }
                },
                series: [
                    {
                        name: 'Jumlah Tamu',
                        type: 'line',
                        smooth: true,
                        data: [12, 25, 41, 32, 18, 35, 29, 42, 38, 25, 16, 8],
                        lineStyle: {
                            color: 'rgba(87, 181, 231, 1)'
                        },
                        itemStyle: {
                            color: 'rgba(87, 181, 231, 1)'
                        },
                        areaStyle: {
                            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                                { offset: 0, color: 'rgba(87, 181, 231, 0.3)' },
                                { offset: 1, color: 'rgba(87, 181, 231, 0.05)' }
                            ])
                        },
                        showSymbol: false
                    }
                ]
            };
            visitChart.setOption(visitOption);

            // Area Distribution Chart
            const areaChart = echarts.init(document.getElementById('areaChart'));
            const areaOption = {
                animation: false,
                tooltip: {
                    trigger: 'item',
                    backgroundColor: 'rgba(255, 255, 255, 0.8)',
                    borderColor: '#F0F0F0',
                    textStyle: {
                        color: '#1f2937'
                    }
                },
                legend: {
                    orient: 'vertical',
                    right: 10,
                    top: 'center',
                    itemWidth: 10,
                    itemHeight: 10,
                    textStyle: {
                        color: '#6B7280'
                    }
                },
                series: [
                    {
                        name: 'Distribusi Area',
                        type: 'pie',
                        radius: ['45%', '70%'],
                        center: ['40%', '50%'],
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
                                show: false
                            }
                        },
                        labelLine: {
                            show: false
                        },
                        data: [
                            { value: 35, name: 'Keluarga Wanita', itemStyle: { color: 'rgba(87, 181, 231, 1)' } },
                            { value: 30, name: 'Keluarga Pria', itemStyle: { color: 'rgba(141, 211, 199, 1)' } },
                            { value: 15, name: 'VIP', itemStyle: { color: 'rgba(251, 191, 114, 1)' } },
                            { value: 20, name: 'Umum', itemStyle: { color: 'rgba(252, 141, 98, 1)' } }
                        ]
                    }
                ]
            };
            areaChart.setOption(areaOption);

            // Resize charts when window size changes
            window.addEventListener('resize', function() {
                visitChart.resize();
                areaChart.resize();
            });
        });
    </script>

    <script id="mobileMenuToggle">
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('button.md\\:hidden');
            const sidebar = document.querySelector('.sidebar');
            
            menuButton.addEventListener('click', function() {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('fixed');
                sidebar.classList.toggle('z-50');
                sidebar.classList.toggle('top-0');
                sidebar.classList.toggle('left-0');
                sidebar.classList.toggle('h-full');
                sidebar.classList.toggle('w-64');
            });
        });
    </script>

    <script id="dropdownToggle">
        document.addEventListener('DOMContentLoaded', function() {
            const profileDropdown = document.querySelector('.cursor-pointer');
            
            if (profileDropdown) {
                profileDropdown.addEventListener('click', function() {
                    // Toggle dropdown menu code would go here
                    // This is a placeholder for actual dropdown functionality
                });
            }
        });
    </script>
</body>
</html>

