<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
include 'db.php';

// Handle delete actions
if (isset($_GET['delete_join'])) {
    $id = $_GET['delete_join'];
    $conn->query("DELETE FROM join_requests WHERE id = $id");
    header("Location: admin_dashboard.php");
    exit();
}
if (isset($_GET['delete_contact'])) {
    $id = $_GET['delete_contact'];
    $conn->query("DELETE FROM contact_messages WHERE id = $id");
    header("Location: admin_dashboard.php");
    exit();
}

// Fetch data
$join_requests = $conn->query("SELECT * FROM join_requests ORDER BY submitted_at DESC");
$contact_messages = $conn->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC");

// Stats
$join_count = $conn->query("SELECT COUNT(*) as count FROM join_requests")->fetch_assoc()['count'];
$contact_count = $conn->query("SELECT COUNT(*) as count FROM contact_messages")->fetch_assoc()['count'];

// Additional stats for charts
$today_join = $conn->query("SELECT COUNT(*) as count FROM join_requests WHERE DATE(submitted_at) = CURDATE()")->fetch_assoc()['count'];
$today_contact = $conn->query("SELECT COUNT(*) as count FROM contact_messages WHERE DATE(submitted_at) = CURDATE()")->fetch_assoc()['count'];

// Weekly data for charts
$weekly_data = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $join_week = $conn->query("SELECT COUNT(*) as count FROM join_requests WHERE DATE(submitted_at) = '$date'")->fetch_assoc()['count'];
    $contact_week = $conn->query("SELECT COUNT(*) as count FROM contact_messages WHERE DATE(submitted_at) = '$date'")->fetch_assoc()['count'];
    $weekly_data[] = [
        'date' => date('M d', strtotime($date)),
        'joins' => $join_week,
        'contacts' => $contact_week
    ];
}

// Service distribution
$service_distribution = [];
$services_result = $conn->query("SELECT service, COUNT(*) as count FROM join_requests GROUP BY service ORDER BY count DESC");
while ($row = $services_result->fetch_assoc()) {
    $service_distribution[] = $row;
}

// Recent activity (last 10 items combined)
$recent_activity = [];
$recent_joins = $conn->query("SELECT 'join' as type, name, submitted_at FROM join_requests ORDER BY submitted_at DESC LIMIT 5");
$recent_contacts = $conn->query("SELECT 'contact' as type, name, submitted_at FROM contact_messages ORDER BY submitted_at DESC LIMIT 5");

while ($row = $recent_joins->fetch_assoc()) {
    $recent_activity[] = $row;
}
while ($row = $recent_contacts->fetch_assoc()) {
    $recent_activity[] = $row;
}

// Sort by date descending
usort($recent_activity, function ($a, $b) {
    return strtotime($b['submitted_at']) - strtotime($a['submitted_at']);
});
$recent_activity = array_slice($recent_activity, 0, 10);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CodeRwanda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
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

        .animate-slide-in-left {
            animation: slideInLeft 0.8s ease-out;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.8s ease-out;
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

        /* Loading animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Dark mode styles */
        .dark {
            background-color: #1f2937;
            color: #f9fafb;
        }

        .dark .bg-white {
            background-color: #374151;
            color: #f9fafb;
        }

        .dark .text-gray-900 {
            color: #f9fafb;
        }

        .dark .text-gray-700 {
            color: #d1d5db;
        }

        .dark .text-gray-600 {
            color: #9ca3af;
        }

        .dark .text-gray-500 {
            color: #6b7280;
        }

        .dark .bg-gray-50 {
            background-color: #111827;
        }

        .dark .bg-gray-100 {
            background-color: #374151;
        }

        .dark .border-gray-300 {
            border-color: #4b5563;
        }

        .dark .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
        }

        /* Chart containers */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
    </style>
</head>

<body class="font-sans bg-gray-50 text-gray-900 dark flex" onload="AOS.init(); initTheme();">
    <!-- Loading Screen -->
    <div id="loading-screen" class="fixed inset-0 bg-white z-50 flex items-center justify-center">
        <div class="text-center">
            <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-blue-600 mx-auto"></div>
            <p class="mt-4 text-gray-600">Loading Dashboard...</p>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="w-64 bg-white dark:bg-gray-800 shadow-lg min-h-screen fixed left-0 top-0 z-30">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="text-2xl font-bold gradient-text">CodeRwanda</div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Admin Dashboard</p>
        </div>
        <nav class="mt-8">
            <a href="#dashboard" class="sidebar-link active flex items-center px-6 py-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 transition duration-300">
                <i class="fas fa-tachometer-alt mr-3 text-blue-600"></i>Dashboard
            </a>
            <a href="#join-requests" class="sidebar-link flex items-center px-6 py-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 transition duration-300">
                <i class="fas fa-user-plus mr-3 text-green-600"></i>Join Requests
            </a>
            <a href="#contact-messages" class="sidebar-link flex items-center px-6 py-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 transition duration-300">
                <i class="fas fa-envelope mr-3 text-purple-600"></i>Contact Messages
            </a>
            <a href="#analytics" class="sidebar-link flex items-center px-6 py-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 transition duration-300">
                <i class="fas fa-chart-bar mr-3 text-orange-600"></i>Analytics
            </a>
            <a href="index.php" class="sidebar-link flex items-center px-6 py-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 transition duration-300">
                <i class="fas fa-globe mr-3 text-teal-600"></i>View Site
            </a>
        </nav>
        <div class="absolute bottom-0 left-0 right-0 p-6 border-t border-gray-200 dark:border-gray-700">
            <button id="theme-toggle" class="w-full flex items-center justify-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300 mb-4">
                <i class="fas fa-sun text-gray-600 dark:text-gray-300"></i>
                <span class="ml-2 text-sm">Toggle Theme</span>
            </button>
            <a href="admin_logout.php" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-300 shadow-lg flex items-center justify-center">
                <i class="fas fa-sign-out-alt mr-2"></i>Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 ml-64">
        <!-- Header -->
        <header class="bg-white dark:bg-gray-800 shadow-lg sticky top-0 z-20 transition-all duration-300">
            <div class="px-6 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Admin Dashboard</h1>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Welcome back, Administrator
                </div>
            </div>
        </header>

        <div class="p-8">
            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-8 rounded-xl shadow-lg mb-8 animate-fade-in-up"
                data-aos="fade-up">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div>
                        <h1 class="text-4xl font-bold mb-2">Welcome to Admin Dashboard</h1>
                        <p class="text-xl opacity-90">Manage join requests and contact messages efficiently</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <i class="fas fa-tachometer-alt text-6xl opacity-80"></i>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2 animate-slide-in-left"
                    data-aos="fade-up">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-blue-600"><?php echo $join_count; ?></h3>
                            <p class="text-gray-600">Join Requests</p>
                        </div>
                        <div class="text-4xl text-blue-600">
                            <i class="fas fa-user-plus"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="bg-blue-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full animate-pulse"
                                style="width: <?php echo min(100, $join_count * 10); ?>%;"></div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2 animate-fade-in-up"
                    data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-green-600"><?php echo $contact_count; ?></h3>
                            <p class="text-gray-600">Contact Messages</p>
                        </div>
                        <div class="text-4xl text-green-600">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="bg-green-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full animate-pulse"
                                style="width: <?php echo min(100, $contact_count * 10); ?>%;"></div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2 animate-slide-in-right"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-purple-600"><?php echo $join_count + $contact_count; ?></h3>
                            <p class="text-gray-600">Total Interactions</p>
                        </div>
                        <div class="text-4xl text-purple-600">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="bg-purple-200 rounded-full h-2">
                            <div class="bg-purple-600 h-2 rounded-full animate-pulse"
                                style="width: <?php echo min(100, ($join_count + $contact_count) * 5); ?>%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Join Requests -->
            <div id="join-requests" class="mb-12 bg-white rounded-xl shadow-lg overflow-hidden animate-fade-in-up"
                data-aos="fade-up">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6">
                    <h2 class="text-2xl font-bold flex items-center">
                        <i class="fas fa-user-plus mr-3"></i>Join Service Requests
                    </h2>
                    <p class="text-blue-100 mt-1">Manage incoming service requests from users</p>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Service</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Message</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php while ($row = $join_requests->fetch_assoc()): ?>
                                    <tr class="hover:bg-gray-50 transition duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <?php echo $row['id']; ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <div
                                                        class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                                                        <span
                                                            class="text-white text-sm font-medium"><?php echo strtoupper(substr($row['name'], 0, 1)); ?></span>
                                                    </div>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900"><?php echo $row['name']; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <a href="mailto:<?php echo $row['email']; ?>"
                                                class="text-blue-600 hover:text-blue-800 transition duration-200">
                                                <i class="fas fa-envelope mr-1"></i><?php echo $row['email']; ?>
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                <?php echo $row['service']; ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate"
                                            title="<?php echo $row['message']; ?>">
                                            <?php echo strlen($row['message']) > 50 ? substr($row['message'], 0, 50) . '...' : $row['message']; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <i
                                                class="fas fa-calendar mr-1"></i><?php echo date('M d, Y', strtotime($row['submitted_at'])); ?>
                                            <br>
                                            <span
                                                class="text-xs"><?php echo date('H:i', strtotime($row['submitted_at'])); ?></span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="?delete_join=<?php echo $row['id']; ?>"
                                                onclick="return confirm('Are you sure you want to delete this request?')"
                                                class="text-red-600 hover:text-red-900 transition duration-200 mr-3 transform hover:scale-110 inline-block">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if ($join_count == 0): ?>
                        <div class="text-center py-12">
                            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg">No join requests yet</p>
                            <p class="text-gray-400">New requests will appear here</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Contact Messages -->
            <div id="contact-messages" class="bg-white rounded-xl shadow-lg overflow-hidden animate-fade-in-up"
                data-aos="fade-up" data-aos-delay="200">
                <div class="bg-gradient-to-r from-green-600 to-teal-600 text-white p-6">
                    <h2 class="text-2xl font-bold flex items-center">
                        <i class="fas fa-envelope mr-3"></i>Contact Messages
                    </h2>
                    <p class="text-green-100 mt-1">View and manage contact form submissions</p>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Subject</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Message</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php while ($row = $contact_messages->fetch_assoc()): ?>
                                    <tr class="hover:bg-gray-50 transition duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <?php echo $row['id']; ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <div
                                                        class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center">
                                                        <span
                                                            class="text-white text-sm font-medium"><?php echo strtoupper(substr($row['name'], 0, 1)); ?></span>
                                                    </div>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900"><?php echo $row['name']; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <a href="mailto:<?php echo $row['email']; ?>"
                                                class="text-green-600 hover:text-green-800 transition duration-200">
                                                <i class="fas fa-envelope mr-1"></i><?php echo $row['email']; ?>
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <?php echo $row['subject']; ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate"
                                            title="<?php echo $row['message']; ?>">
                                            <?php echo strlen($row['message']) > 50 ? substr($row['message'], 0, 50) . '...' : $row['message']; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <i
                                                class="fas fa-calendar mr-1"></i><?php echo date('M d, Y', strtotime($row['submitted_at'])); ?>
                                            <br>
                                            <span
                                                class="text-xs"><?php echo date('H:i', strtotime($row['submitted_at'])); ?></span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="?delete_contact=<?php echo $row['id']; ?>"
                                                onclick="return confirm('Are you sure you want to delete this message?')"
                                                class="text-red-600 hover:text-red-900 transition duration-200 mr-3 transform hover:scale-110 inline-block">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if ($contact_count == 0): ?>
                        <div class="text-center py-12">
                            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg">No contact messages yet</p>
                            <p class="text-gray-400">New messages will appear here</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Back to Top Button -->
        <button id="back-to-top"
            class="fixed bottom-6 right-6 bg-blue-600 text-white w-12 h-12 rounded-full hidden shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-110 z-40">
            <i class="fas fa-arrow-up"></i>
        </button>

        <script>
            // Loading screen
            window.addEventListener('load', function() {
                setTimeout(() => {
                    document.getElementById('loading-screen').style.display = 'none';
                }, 1500);
            });

            // Smooth scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Back to top button
            window.addEventListener('scroll', () => {
                const backToTop = document.getElementById('back-to-top');
                if (window.pageYOffset > 300) {
                    backToTop.classList.remove('hidden');
                } else {
                    backToTop.classList.add('hidden');
                }
            });

            document.getElementById('back-to-top').addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Add loading state to delete links
            document.querySelectorAll('a[href*="delete"]').forEach(link => {
                link.addEventListener('click', function(e) {
                    if (!confirm('Are you sure you want to delete this item?')) {
                        e.preventDefault();
                        return;
                    }
                    const originalText = this.innerHTML;
                    this.innerHTML = '<div class="loading"></div> Deleting...';
                    this.style.pointerEvents = 'none';
                    // The page will reload after deletion, so this is just for visual feedback
                });
            });

            // Sidebar navigation active state
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    sidebarLinks.forEach(l => l.classList.remove('active', 'bg-blue-100', 'dark:bg-gray-700'));
                    this.classList.add('active', 'bg-blue-100', 'dark:bg-gray-700');
                });
            });

            // Smooth scroll for sidebar links
            document.querySelectorAll('.sidebar-link[href^="#"]').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        </script>
    </div> <!-- End Main Content -->
</body>

</html>