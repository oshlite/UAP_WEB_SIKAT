    <?php
    // tamu_dashboard.php
    session_start();
    date_default_timezone_set('Asia/Jakarta');

    require 'koneksi.php';

    // Cek login dan role
    if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_role'] !== 'tamu') {
        header('Location: login.php');
        exit;
    }

    // Get user info
    $username = $_SESSION['username'];
    $fullName = $_SESSION['full_name'] ?? 'Tamu';

    // Handle logout
    if (isset($_GET['logout'])) {
        session_destroy();
        header('Location: login.php');
        exit;
    }

    // Get current page
    $page = $_GET['page'] ?? 'buku-tamu';

    // Get data for dashboard
    try {
    // Total tamu hari ini
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM tamu WHERE DATE(waktu) = CURDATE()");
    $stmt->execute();
    $totalHariIni = $stmt->fetch()['total'];

    // Total tamu keseluruhan
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM tamu");
    $stmt->execute();
    $totalKeseluruhan = $stmt->fetch()['total'];

        
        // Tamu terbaru
        $stmt = $pdo->prepare("SELECT * FROM tamu ORDER BY waktu DESC LIMIT 5");
        $stmt->execute();
        $tamuTerbaru = $stmt->fetchAll();
        
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard Tamu - SIKAT</title>
        <!-- Tailwind & Colors -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            gold: '#FFD700',
                            'gold-dark': '#E5B600',
                            peach: '#FFDAB9'
                        },
                        fontFamily: {
                            sans: ['Poppins', 'sans-serif'],
                            serif: ['Playfair Display', 'serif'],
                            script: ['Pacifico', 'cursive']
                        }
                    }
                }
            }
        </script>
        <!-- Icon & Font -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&family=Pacifico&display=swap" rel="stylesheet">
    </head>
    <body class="bg-gray-50 min-h-screen">

        <div class="flex h-screen">
            
            <!-- SIDEBAR -->
            <aside class="w-64 bg-white shadow-lg">
                
                <!-- Logo -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gold rounded-full flex items-center justify-center">
                            <span class="text-xl font-script text-white">S</span>
                        </div>
                        <div>
                            <h1 class="text-xl font-script text-gold">SIKAT</h1>
                            <p class="text-xs text-gray-500">Dashboard Tamu</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="p-4">
                    <ul class="space-y-2">
                        <li>
                            <a href="?page=buku-tamu" 
                            class="flex items-center space-x-3 p-3 rounded-lg transition-colors duration-200 <?= ($page === 'buku-tamu') ? 'bg-gold bg-opacity-20 text-gold' : 'text-gray-600 hover:bg-gray-100' ?>">
                                <i class="ri-book-open-line text-lg"></i>
                                <span class="font-medium">Buku Tamu</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=daftar-tamu" 
                            class="flex items-center space-x-3 p-3 rounded-lg transition-colors duration-200 <?= ($page === 'daftar-tamu') ? 'bg-gold bg-opacity-20 text-gold' : 'text-gray-600 hover:bg-gray-100' ?>">
                                <i class="ri-group-line text-lg"></i>
                                <span class="font-medium">Daftar Tamu</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- User Info -->
                <div class="absolute bottom-0 w-64 p-4 border-t border-gray-200 bg-white">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-8 h-8 bg-gold bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="ri-user-line text-gold"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800"><?= htmlspecialchars($fullName) ?></p>
                            <p class="text-xs text-gray-500">@<?= htmlspecialchars($username) ?></p>
                        </div>
                    </div>
                    <a href="?logout=1" 
                    class="flex items-center space-x-2 text-red-600 hover:text-red-700 text-sm">
                        <i class="ri-logout-box-line"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </aside>

            <!-- MAIN CONTENT -->
            <main class="flex-1 overflow-y-auto">
                
                <!-- Header -->
                <header class="bg-white shadow-sm border-b border-gray-200 p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-serif text-gray-800">
                                <?php
                                switch($page) {
                                    case 'buku-tamu':
                                        echo 'Buku Tamu';
                                        break;
                                    case 'daftar-tamu':
                                        echo 'Daftar Tamu';
                                        break;
                                    default:
                                        echo 'Dashboard';
                                }
                                ?>
                            </h2>
                            <p class="text-gray-600 text-sm mt-1">
                                <?= date('l, d F Y') ?>
                            </p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="bg-gold bg-opacity-10 px-4 py-2 rounded-full">
                                <span class="text-gold text-sm font-medium">
                                    <i class="ri-time-line mr-1"></i>
                                    <?= date('H:i' ) ?> WIB
                                </span>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Content -->
                <div class="p-6">
                    
                    <?php if ($page === 'buku-tamu'): ?>
                        <!-- BUKU TAMU PAGE -->
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-serif text-gray-800">Form Buku Tamu</h3>
                                <a href="bukutamu.php" target="_blank" 
                                class="bg-gold text-white px-4 py-2 rounded-lg hover:bg-gold-dark transition">
                                    <i class="ri-external-link-line mr-2"></i>
                                    Buka Form
                                </a>
                            </div>
                            
                            <!-- Stats Cards -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div class="bg-gradient-to-r from-gold to-gold-dark p-6 rounded-xl text-white">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm opacity-90">Tamu Hari Ini</p>
                                            <p class="text-3xl font-bold"><?= $totalHariIni ?></p>
                                        </div>
                                        <i class="ri-calendar-today-line text-3xl opacity-80"></i>
                                    </div>
                                </div>
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-xl text-white">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm opacity-90">Total Tamu</p>
                                            <p class="text-3xl font-bold"><?= $totalKeseluruhan ?></p>
                                        </div>
                                        <i class="ri-group-line text-3xl opacity-80"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Preview -->
                            <div class="bg-gray-50 rounded-xl p-6">
                                <h4 class="font-medium text-gray-800 mb-4">Preview Form Buku Tamu</h4>
                                <div class="space-y-3">
                                    <div class="flex items-center space-x-3 text-gray-600">
                                        <i class="ri-user-line"></i>
                                        <span>Input: Nama Lengkap</span>
                                    </div>
                                    <div class="flex items-center space-x-3 text-gray-600">
                                        <i class="ri-question-line"></i>
                                        <span>Select: Keperluan (Keluarga/Teman/Rekan)</span>
                                    </div>
                                    <div class="flex items-center space-x-3 text-gray-600">
                                        <i class="ri-map-pin-line"></i>
                                        <span>Select: Tamu Luar Provinsi (Ya/Tidak)</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php elseif ($page === 'daftar-tamu'): ?>
                        <!-- DAFTAR TAMU PAGE -->
                        <div class="bg-white rounded-2xl shadow-lg">
                            
                            <!-- Header -->
                            <div class="p-6 border-b border-gray-200">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-xl font-serif text-gray-800">Daftar Tamu</h3>
                                    <div class="flex space-x-2">
                                        <button onclick="refreshTable()" 
                                                class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                                            <i class="ri-refresh-line mr-2"></i>
                                            Refresh
                                        </button>
                                        <button onclick="exportData()" 
                                                class="bg-gold text-white px-4 py-2 rounded-lg hover:bg-gold-dark transition">
                                            <i class="ri-download-line mr-2"></i>
                                            Export
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50">
    <tr>
        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keperluan</th>
        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Luar Provinsi</th>
        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
    </tr>
</thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php
                                        try {
                                            $stmt = $pdo->prepare("SELECT * FROM tamu ORDER BY waktu DESC");
                                            $stmt->execute();
                                            $allTamu = $stmt->fetchAll();
                                            
                                            if (count($allTamu) > 0) {
                                                foreach ($allTamu as $index => $tamu) {
                                                    echo "<tr class='hover:bg-gray-50'>";
                                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . ($index + 1) . "</td>";
                                                    echo "<td class='px-6 py-4 whitespace-nowrap'>
                                                            <div class='flex items-center'>
                                                                <div class='w-8 h-8 bg-gold bg-opacity-20 rounded-full flex items-center justify-center mr-3'>
                                                                    <i class='ri-user-line text-gold text-sm'></i>
                                                                </div>
                                                                <span class='text-sm font-medium text-gray-900'>" . htmlspecialchars($tamu['nama']) . "</span>
                                                            </div>
                                                        </td>";
                                                    echo "<td class='px-6 py-4 whitespace-nowrap'>
                                                            <span class='px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full'>" . htmlspecialchars($tamu['keperluan']) . "</span>
                                                        </td>";
                                                  echo "<td class='px-6 py-4 whitespace-nowrap'>
                                                            <span class='px-2 py-1 text-xs font-medium " . ($tamu['luar_provinsi'] === 'Ya' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') . " rounded-full'>" . htmlspecialchars($tamu['luar_provinsi']) . "</span>
                                                        </td>";
                                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>" . date('d/m/Y H:i', strtotime($tamu['waktu'])) . "</td>";
                                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm font-medium'>
                                                        
                                                        </td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='7' class='px-6 py-12 text-center text-gray-500'>
                                                        <i class='ri-inbox-line text-4xl mb-2 block'></i>
                                                        Belum ada data tamu
                                                    </td></tr>";
                                            }
                                        } catch (Exception $e) {
                                            echo "<tr><td colspan='7' class='px-6 py-4 text-center text-red-500'>Error: " . $e->getMessage() . "</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </main>
        </div>

        <!-- JavaScript -->
        <script>
            // Refresh table
            function refreshTable() {
                location.reload();
            }

            // Export data
            function exportData() {
                window.open('export_tamu.php', '_blank');
            }

            // View detail
            function viewDetail(id) {
                alert('Fitur detail tamu ID: ' + id + ' (akan dikembangkan)');
            }

            // Edit tamu
            function editTamu(id) {
                alert('Fitur edit tamu ID: ' + id + ' (akan dikembangkan)');
            }

            // Auto refresh setiap 30 detik
            setInterval(() => {
                if (document.querySelector('table')) {
                    const now = new Date();
                    const timeElement = document.querySelector('[data-time]');
                    if (timeElement) {
                        timeElement.textContent = now.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'}) + ' WIB';
                    }
                }
            }, 30000);

            // Highlight active menu
            document.addEventListener('DOMContentLoaded', function() {
                const currentPage = new URLSearchParams(window.location.search).get('page') || 'buku-tamu';
                const menuItems = document.querySelectorAll('nav a');
                
                menuItems.forEach(item => {
                    const href = item.getAttribute('href');
                    if (href && href.includes(currentPage)) {
                        item.classList.add('bg-gold', 'bg-opacity-20', 'text-gold');
                        item.classList.remove('text-gray-600', 'hover:bg-gray-100');
                    }
                });
            });
        </script>

    </body>
    </html>