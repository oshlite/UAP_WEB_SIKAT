<?php
require_once '../koneksi.php';

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

// Total tamu hari ini
$stmt = $pdo->prepare("SELECT COUNT(*) FROM tamu WHERE luar_provinsi LIKE :keyword");
$stmt->execute([':keyword' => '%1%']);
$totalLuarKota = $stmt->fetchColumn();

// Total tamu terdaftar (seluruh data)
$stmt = $pdo->query("SELECT COUNT(*) FROM tamu");
$totalTerdaftar = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM tamu_prio");
$totalPrioritas = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM petugas");
$totalPetugas = $stmt->fetchColumn();


// Total petugas aktif (dummy 12, atau buat logika tertentu)
$totalPetugasAktif = 12;

$stmt = $pdo->prepare("
    SELECT HOUR(waktu) AS jam, COUNT(*) AS jumlah 
    FROM tamu 
    WHERE DATE(waktu)
    GROUP BY jam
    ORDER BY jam ASC
");
$stmt->execute();

$jam = [];
$jumlah = [];

foreach ($stmt as $row) {
    $jam[] = sprintf('%02d:00', $row['jam']); // format jadi 01:00, 02:00, ...
    $jumlah[] = $row['jumlah'];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIKAT - Dashboard Admin</title>
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
                        'none': '0px',
                        'sm': '4px',
                        DEFAULT: '8px',
                        'md': '12px',
                        'lg': '16px',
                        'xl': '20px',
                        '2xl': '24px',
                        '3xl': '32px',
                        'full': '9999px',
                        'button': '8px'
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.5.0/echarts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

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

        input:checked+.slider {
            background-color: #FFD700;
        }

        input:checked+.slider:before {
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
                    <nav class="flex-1 px-2 pb-4 mt-10">
                        <div class="space-y-1">
                            <a href="index.php" class="sidebar-item active flex items-center px-3 py-2 text-sm font-medium rounded-md group">
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
                            <a href="filter.php" class="sidebar-item flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md group">
                                <div class="w-6 h-6 mr-3 flex items-center justify-center text-gray-500">
                                    <i class="ri-map-pin-line ri-lg"></i>
                                </div>
                                <span>Filter & Pencarian</span>
                            </a>
                            <a href="../logout.php" class="sidebar-item flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md group">
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
                                <p id="datetime"></p>
                            </div>
                        </div>
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
                            <a
                                href="tambah.php"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-yellow-500 hover:bg-yellow-600 whitespace-nowrap">
                                <i class="ri-add-line mr-2"></i>
                                Tambah Tamu
                            </a>
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
                                <h2 class="text-sm font-medium text-gray-500">Total Tamu Luar Kota</h2>
                                <p class="text-2xl font-bold text-gray-900"><?= $totalLuarKota ?></p>
                            </div>
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
                                <p class="text-2xl font-bold text-gray-900"><?= $totalTerdaftar ?></p>
                            </div>
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
                                <h2 class="text-sm font-medium text-gray-500">Tamu Prioritas</h2>
                                <p class="text-2xl font-bold text-gray-900"><?= $totalPrioritas ?></p>
                            </div>
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
                                <p class="text-2xl font-bold text-gray-900"><?= $totalPetugas ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->

                <div class="bg-white p-6 rounded shadow my-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Kunjungan Hari Ini (Per Jam)</h2>
                    <div id="chart-kunjungan-jam" class="w-full h-64"></div>
                </div>
            </main>
        </div>
    </div>

    <script src="index.js"></script>
    <script>
        var chartKunjunganJam = echarts.init(document.getElementById('chart-kunjungan-jam'));

        chartKunjunganJam.setOption({
            tooltip: {
                trigger: 'axis'
            },
            xAxis: {
                type: 'category',
                data: <?= json_encode($jam) ?>,
                axisLabel: {
                    rotate: 45
                }
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                name: 'Jumlah Kunjungan',
                type: 'bar',
                data: <?= json_encode($jumlah) ?>,
                itemStyle: {
                    color: '#6366f1'
                },
                barWidth: '60%'
            }]
        });
    </script>

</body>

</html>