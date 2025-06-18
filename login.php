<?php
// login.php
session_start();
require 'koneksi.php';


$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Validasi input
    if (empty($username) || empty($password)) {
        $error = 'Username dan password harus diisi!';
    } else {
        // Query untuk cek user dari tabel users
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND is_active = 1 LIMIT 1");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                // Regenerasi session ID untuk mencegah session fixation
                session_regenerate_id(true);
                
                // Set session variables
                $_SESSION['user_logged_in'] = true;
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
               $_SESSION['last_login'] = time();
                
                // Redirect berdasarkan role
                $redirect_url = 'index.php'; // Default redirect
                switch($user['role']) {
                    case 'admin':
                        $redirect_url = 'admin/eoadmin_dashboard.php';
                        break;
                    case 'petugas':
                        $redirect_url = 'petugastamu_dashboard.php';
                        break;
                    case 'pengantin':
                        $redirect_url = 'userpengantin_dashboard.php';
                        break;
                    case 'tamu':
                        $redirect_url = 'tamu_dashboard.php';
                        break;
                }
                
                header("Location: $redirect_url");
                exit();
            } else {
                // Pesan error umum untuk keamanan (tidak spesifik)
                $error = 'Username atau password salah!';
                // Log error untuk admin
                error_log("Login failed for username: $username");
            }
        } catch (PDOException $e) {
            $error = 'Terjadi kesalahan sistem. Silakan coba lagi nanti.';
            error_log("Database error: " . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - SIKAT</title>
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
<body class="bg-gradient-to-br from-peach via-white to-gold bg-opacity-30 min-h-screen flex items-center justify-center">

    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23FFD700" fill-opacity="0.1"><circle cx="30" cy="30" r="4"/></g></g></svg>');"></div>
    </div>

    <!-- Login Container -->
    <div class="relative w-full max-w-md px-6">
        
        <!-- Logo & Brand -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-lg mb-4">
                <h1 class="text-3xl font-script text-gold">S</h1>
            </div>
            <h2 class="text-3xl font-script text-gold mb-2">SIKAT</h2>
            <p class="text-gray-600 text-sm">Sistem Informasi Buku Tamu</p>
            <div class="w-16 h-1 bg-gold mx-auto mt-2 rounded-full"></div>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 backdrop-blur-sm border border-white border-opacity-20">
            
            <!-- Header -->
            <div class="text-center mb-6">
                <h3 class="text-2xl font-serif text-gray-800 mb-2">Login Admin</h3>
                <p class="text-gray-500 text-sm">Masuk untuk mengakses dashboard</p>
            </div>

            <!-- Error Message -->
            <?php if ($error): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-center">
                <i class="ri-error-warning-line mr-2"></i>
                <span class="text-sm"><?= htmlspecialchars($error) ?></span>
            </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="POST" class="space-y-6">
                
                <!-- Username -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="ri-user-line mr-1"></i>
                        Username
                    </label>
                    <input 
                        name="username" 
                        type="text" 
                        required 
                        autocomplete="username"
                        class="w-full border border-gray-200 p-4 rounded-xl
                               focus:ring-2 focus:ring-gold focus:border-transparent
                               transition duration-200 placeholder-gray-400"
                        placeholder="Masukkan username"
                        value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="ri-lock-line mr-1"></i>
                        Password
                    </label>
                    <div class="relative">
                        <input 
                            name="password" 
                            type="password" 
                            id="password"
                            required 
                            autocomplete="current-password"
                            class="w-full border border-gray-200 p-4 rounded-xl pr-12
                                   focus:ring-2 focus:ring-gold focus:border-transparent
                                   transition duration-200 placeholder-gray-400"
                            placeholder="Masukkan password">
                        <button 
                            type="button" 
                            id="togglePassword"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="ri-eye-line" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-gold focus:ring-gold">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm text-gold hover:text-gold-dark transition">
                        Lupa password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full bg-gradient-to-r from-gold to-gold-dark text-white py-4 rounded-xl font-medium
                           hover:from-gold-dark hover:to-gold transform hover:scale-[1.02] 
                           transition duration-200 shadow-lg hover:shadow-xl
                           focus:ring-2 focus:ring-gold focus:ring-offset-2">
                    <i class="ri-login-box-line mr-2"></i>
                    Masuk ke Dashboard
                </button>

            </form>

            <!-- Footer -->
            <div class="text-center mt-6 pt-6 border-t border-gray-100">
                <p class="text-xs text-gray-500">
                    <i class="ri-shield-check-line mr-1"></i>
                    Login aman dengan enkripsi SSL
                </p>
            </div>

        </div>

        <!-- Bottom Info -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-500">
                © 2025 SIKAT - Sistem Informasi Buku Tamu
            </p>
            <div class="flex justify-center items-center mt-2 space-x-4 text-xs text-gray-400">
                <span><i class="ri-time-line mr-1"></i>Version 1.0</span>
                <span>•</span>
                <span><i class="ri-code-line mr-1"></i>Made with ❤️</span>
            </div>
        </div>

    </div>

    <!-- JavaScript -->
    <script>
        // Toggle Password Visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.className = 'ri-eye-off-line';
            } else {
                password.type = 'password';
                eyeIcon.className = 'ri-eye-line';
            }
        });

        // Form Animation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input');
            
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('transform', 'scale-[1.02]');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('transform', 'scale-[1.02]');
                });
            });
        });

        // Prevent double submission
        document.querySelector('form').addEventListener('submit', function() {
            const button = this.querySelector('button[type="submit"]');
            button.disabled = true;
            button.innerHTML = '<i class="ri-loader-line animate-spin mr-2"></i>Memproses...';
            
            setTimeout(() => {
                button.disabled = false;
                button.innerHTML = '<i class="ri-login-box-line mr-2"></i>Masuk ke Dashboard';
            }, 3000);
        });
    </script>

</body>
</html>
