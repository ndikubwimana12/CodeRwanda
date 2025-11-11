<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = $username;
            $_SESSION['admin_id'] = $admin['id'];

            // Update last login
            $update_stmt = $conn->prepare("UPDATE admins SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
            $update_stmt->bind_param("i", $admin['id']);
            $update_stmt->execute();
            $update_stmt->close();

            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "Invalid username";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - CodeRwanda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Custom animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        .animate-pulse-custom {
            animation: pulse 2s infinite;
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(45deg, #3b82f6, #8b5cf6, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }

        /* Glass morphism effect */
        .glass {
            background: rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.18);
        }
    </style>
</head>

<body class="font-sans bg-gradient-to-br from-blue-500 via-purple-600 to-indigo-700 text-white overflow-x-hidden"
    onload="AOS.init();">
    <!-- Loading Screen -->
    <div id="loading-screen" class="fixed inset-0 bg-white z-50 flex items-center justify-center">
        <div class="text-center">
            <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-blue-600 mx-auto"></div>
            <p class="mt-4 text-gray-600">Loading Admin Login...</p>
        </div>
    </div>



    <div class="min-h-screen flex items-center justify-center relative z-10 px-4">
        <div class="glass p-10 rounded-2xl shadow-2xl w-full max-w-md animate-fade-in-up bg-gray" data-aos="fade-up">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="text-5xl font-bold gradient-text animate-pulse-custom mb-2">CodeRwanda</div>
                <p class="text-white/80 text-sm">Admin Portal</p>
            </div>

            <h2 class="text-3xl font-bold mb-8 text-center text-white">
                <i class="fas fa-user-shield mr-3"></i>Admin Login
            </h2>

            <?php if (isset($error)): ?>
                <div
                    class="bg-red-500/20 border border-red-500/30 text-red-100 px-4 py-3 rounded-lg mb-6 animate-fade-in-up">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <span><?php echo $error; ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <form action="admin_login.php" method="post" class="space-y-6">
                <div class="animate-fade-in-up" data-aos="fade-up" data-aos-delay="100">
                    <label for="username" class="block text-white font-semibold mb-2">
                        <i class="fas fa-user mr-2"></i>Username
                    </label>
                    <div class="relative">
                        <input type="text" id="username" name="username"
                            class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-white/50 transition duration-300"
                            placeholder="Enter admin username" required>
                        <i class="fas fa-user absolute right-3 top-3.5 text-white/60"></i>
                    </div>
                </div>

                <div class="animate-fade-in-up" data-aos="fade-up" data-aos-delay="200">
                    <label for="password" class="block text-white font-semibold mb-2">
                        <i class="fas fa-lock mr-2"></i>Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-white/50 transition duration-300"
                            placeholder="Enter admin password" required>
                        <i class="fas fa-lock absolute right-3 top-3.5 text-white/60"></i>
                        <button type="button" id="toggle-password"
                            class="absolute right-10 top-3.5 text-white/60 hover:text-white transition duration-300">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" name="login"
                    class="w-full bg-white text-blue-600 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300 transform hover:scale-105 animate-fade-in-up shadow-lg"
                    data-aos="fade-up" data-aos-delay="300">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login to Dashboard
                </button>
            </form>

            <!-- Footer -->
            <div class="mt-8 text-center text-white/60 text-sm animate-fade-in-up" data-aos="fade-up"
                data-aos-delay="400">
                <p>Secure admin access only</p>
                <p class="mt-1">© 2024 CodeRwanda. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script>
        // Loading screen
        window.addEventListener('load', function() {
            setTimeout(() => {
                document.getElementById('loading-screen').style.display = 'none';
            }, 1500);
        });

        // Password toggle
        document.getElementById('toggle-password').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Add enter key support
        document.getElementById('username').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('password').focus();
            }
        });

        document.getElementById('password').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.querySelector('button[type="submit"]').click();
            }
        });
    </script>
</body>

</html>