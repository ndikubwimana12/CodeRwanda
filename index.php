<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_join'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $service = htmlspecialchars($_POST['service']);
    $message = htmlspecialchars($_POST['message']);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO join_requests (name, email, service, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $service, $message);
    if ($stmt->execute()) {
        echo "<script>alert('Thank you $name, your request for $service has been received.');</script>";
    } else {
        echo "<script>alert('Error submitting request. Please try again.');</script>";
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_holiday_training'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $program_type = htmlspecialchars($_POST['program_type']);
    $duration = htmlspecialchars($_POST['duration']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $message = htmlspecialchars($_POST['message']);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO holiday_training_applications (full_name, email, phone, course, duration, start_date, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $phone, $program_type, $duration, $start_date, $message);
    if ($stmt->execute()) {
        echo "<script>alert('Thank you $name, your holiday training application has been received.');</script>";
    } else {
        echo "<script>alert('Error submitting application. Please try again.');</script>";
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_service_application'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $company = htmlspecialchars($_POST['company']);
    $service_type = htmlspecialchars($_POST['service_type']);
    $budget = htmlspecialchars($_POST['budget']);
    $timeline = htmlspecialchars($_POST['timeline']);
    $message = htmlspecialchars($_POST['message']);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO service_applications (name, email, phone, company, service_type, budget, timeline, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $name, $email, $phone, $company, $service_type, $budget, $timeline, $message);
    if ($stmt->execute()) {
        echo "<script>alert('Thank you $name, your service application has been received.');</script>";
    } else {
        echo "<script>alert('Error submitting application. Please try again.');</script>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeRwanda - Leading Technology Solutions in Rwanda</title>
    <meta name="description"
        content="Empowering Rwanda with innovative technology development, training, and consulting services. Boost your business with cutting-edge solutions.">
    <meta name="keywords"
        content="technology Rwanda, software development Kigali, IT training Rwanda, digital consulting">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
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

    .floating-cta {
        position: fixed;
        top: 6rem;
        right: 1.5rem;
        z-index: 60;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .floating-cta a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        border-radius: 9999px;
        font-weight: 600;
        color: #ffffff;
        /* text stays visible */
        text-decoration: none;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        z-index: 1;
    }

    /* Animated gradient background */
    .floating-cta a::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: inherit;
        background: linear-gradient(270deg, #ec4899, #8b5cf6, #3b82f6, #ec4899);
        background-size: 600% 600%;
        /* make gradient wide enough to animate */
        animation: gradientMove 6s ease infinite;
        z-index: -1;
        filter: brightness(1.1);
    }

    /* Gradient animation keyframes */
    @keyframes gradientMove {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    /* Hover effects */
    .floating-cta a:hover,
    .floating-cta a:focus {
        transform: translateY(-4px) scale(1.05);
        box-shadow: 0 10px 25px rgba(236, 72, 153, 0.6),
            0 0 20px rgba(139, 92, 246, 0.4);
    }

    /* Optional pulse animation */
    .floating-cta a.animate-pulse-custom {
        animation: pulse 2s infinite, gradientMove 6s ease infinite;
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

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .floating-cta {
            top: auto;
            bottom: 6.5rem;
            right: 1rem;
            flex-direction: column;
        }

        .floating-cta a {
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
        }
    }

    /* Particle background */
    #particles-js {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: -1;
    }

    /* Gradient text */
    .gradient-text {
        background: linear-gradient(45deg, #3b82f6, #8b5cf6, #ec4899);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Glass morphism */
    .glass {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
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
    </style>
</head>

<body class="font-sans bg-gray-50 text-gray-900 overflow-x-hidden" onload="AOS.init(); initParticles();">
    <!-- Loading Screen -->
    <div id="loading-screen" class="fixed inset-0 bg-white z-50 flex items-center justify-center">
        <div class="text-center">
            <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-blue-600 mx-auto"></div>
            <p class="mt-4 text-gray-600">Loading CodeRwanda...</p>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-white shadow-lg sticky top-0 z-40 transition-all duration-300">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="text-3xl font-bold gradient-text animate-pulse-custom">CodeRwanda</div>
            <nav class="hidden lg:flex space-x-8">
                <a href="#home" class="text-gray-700 hover:text-blue-600 transition duration-300 relative group">
                    Home
                    <span
                        class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all group-hover:w-full"></span>
                </a>
                <div class="relative group">
                    <a href="#services"
                        class="text-gray-700 hover:text-blue-600 transition duration-300 flex items-center">
                        Services <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </a>
                    <div
                        class="absolute -left-4 mt-2 w-64 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 max-h-80 overflow-y-auto">
                        <a href="#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Technology
                            Development</a>
                        <a href="#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Training Programs</a>
                        <a href="#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Consulting
                            Services</a>
                        <a href="#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Website
                            Development</a>
                        <a href="#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">System Design and
                            Development</a>
                        <a href="#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Business Card & Flyer
                            Design</a>
                        <a href="#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Data Analysis</a>
                        <a href="#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Scheduled Training on
                            Technology</a>
                        <a href="#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Unscheduled Trainings
                            on Technology</a>
                        <a href="#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Industrial
                            Attachment</a>
                        <a href="#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Hosting Services</a>
                        <a href="#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Advanced Computer
                            Skills Training</a>
                        <a href="#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Mentorship on
                            Technology</a>
                    </div>
                </div>
                <a href="#portfolio" class="text-gray-700 hover:text-blue-600 transition duration-300 relative group">
                    Portfolio
                    <span
                        class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all group-hover:w-full"></span>
                </a>
                <a href="#testimonials"
                    class="text-gray-700 hover:text-blue-600 transition duration-300 relative group">
                    Testimonials
                    <span
                        class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all group-hover:w-full"></span>
                </a>
                <a href="about.php" class="text-gray-700 hover:text-blue-600 transition duration-300 relative group">
                    About Us
                    <span
                        class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all group-hover:w-full"></span>
                </a>
                <a href="contact.php" class="text-gray-700 hover:text-blue-600 transition duration-300 relative group">
                    Contact Us
                    <span
                        class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all group-hover:w-full"></span>
                </a>
                <a href="admin_login.php"
                    class="text-gray-700 hover:text-blue-600 transition duration-300 relative group">
                    Login
                    <span
                        class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all group-hover:w-full"></span>
                </a>
            </nav>
            <div class="flex items-center space-x-4">
                <button id="theme-toggle" class="p-2 rounded-full hover:bg-gray-100 transition duration-300">
                    <i class="fas fa-moon text-gray-600"></i>
                </button>
                <button class="lg:hidden text-gray-700" onclick="toggleMenu()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden bg-white px-4 py-2 shadow-lg">
            <a href="#home" class="block py-2 text-gray-700 hover:text-blue-600 transition duration-300">Home</a>
            <a href="#services"
                class="block py-2 text-gray-700 hover:text-blue-600 transition duration-300">Services</a>
            <a href="#portfolio"
                class="block py-2 text-gray-700 hover:text-blue-600 transition duration-300">Portfolio</a>
            <a href="#testimonials"
                class="block py-2 text-gray-700 hover:text-blue-600 transition duration-300">Testimonials</a>
            <a href="about.php" class="block py-2 text-gray-700 hover:text-blue-600 transition duration-300">About
                Us</a>
            <a href="contact.php" class="block py-2 text-gray-700 hover:text-blue-600 transition duration-300">Contact
                Us</a>
        </div>
    </header>

    <div class="floating-cta">
        <a href="#service-application" class="cta-service"><i class="fas fa-briefcase mr-2"></i>Apply for Services</a>
        <a href="#holiday-training" class="cta-holiday"><i class="fas fa-graduation-cap mr-2"></i>Apply for Holiday
            Training</a>
    </div>

    <!-- Hero Section -->
    <section id="home"
        class="relative bg-gradient-to-br from-blue-600 via-blue-500 to-blue-600 text-white py-32 overflow-hidden">
        <div id="particles-js"></div>
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="container mx-auto px-4 text-center relative z-10" data-aos="fade-up">
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight animate-fade-in-up">
                Empowering Rwanda Through <span class="gradient-text">Technology</span>
            </h1>
            <p class="text-xl md:text-2xl mb-10 max-w-3xl mx-auto animate-fade-in-up" data-aos-delay="200">
                Leading provider of innovative technology solutions, comprehensive training, and expert consulting
                services.
                Transform your business with cutting-edge digital innovations.
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6 animate-fade-in-up"
                data-aos-delay="400">
                <a href="#services"
                    class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold hover:bg-gray-100 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <i class="fas fa-rocket mr-2"></i>Explore Our Services
                </a>
                <a href="#contact"
                    class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <i class="fas fa-paper-plane mr-2"></i>Get Started
                </a>
            </div>
        </div>
        <!-- <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-gray-50 to-transparent"></div> -->
        <!-- Floating elements -->
        <!-- <div class="absolute top-20 left-10 animate-bounce">
            <i class="fas fa-code text-4xl opacity-50"></i>
        </div>
        <div class="absolute top-40 right-20 animate-pulse">
            <i class="fas fa-robot text-3xl opacity-50"></i>
        </div>
        <div class="absolute bottom-20 left-20 animate-bounce" style="animation-delay: 1s;">
            <i class="fas fa-laptop text-3xl opacity-50"></i>
        </div> -->
    </section>

    <!-- Mission Section -->
    <section class="py-20 bg-white stats-section" data-aos="fade-up">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-10 text-gray-800 animate-slide-in-left">Our Mission</h2>
            <p class="text-xl max-w-4xl mx-auto text-gray-600 leading-relaxed animate-slide-in-right mb-12">
                At CodeRwanda, our mission is to bridge the gap between technology and opportunity in Rwanda.
                We strive to deliver cutting-edge solutions and empower individuals and businesses with the skills
                needed to thrive in the digital age.
                With over 2 years of experience, we've helped 100+ clients achieve digital transformation.
            </p>
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6 bg-gray-50 rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-2"
                    data-aos="fade-up" data-aos-delay="100">
                    <div class="text-4xl mb-4">
                        <i class="fas fa-project-diagram text-blue-600"></i>
                    </div>
                    <h3 class="counter text-2xl font-semibold mb-4 text-blue-600" data-target="10">0</h3>
                    <p class="text-gray-600">Projects Completed</p>
                    <div class="mt-4 bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full animate-pulse" style="width: 85%;"></div>
                    </div>
                </div>
                <div class="p-6 bg-gray-50 rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-2"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="text-4xl mb-4">
                        <i class="fas fa-users text-green-600"></i>
                    </div>
                    <h3 class="counter text-2xl font-semibold mb-4 text-blue-600" data-target="100">0</h3>
                    <p class="text-gray-600">Happy Clients</p>
                    <div class="mt-4 bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full animate-pulse" style="width: 92%;"></div>
                    </div>
                </div>
                <div class="p-6 bg-gray-50 rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-2"
                    data-aos="fade-up" data-aos-delay="300">
                    <div class="text-4xl mb-4">
                        <i class="fas fa-calendar-alt text-purple-600"></i>
                    </div>
                    <h3 class="counter text-2xl font-semibold mb-4 text-blue-600" data-target="2">0</h3>
                    <p class="text-gray-600">Years of Expertise</p>
                    <div class="mt-4 bg-gray-200 rounded-full h-2">
                        <div class="bg-purple-600 h-2 rounded-full animate-pulse" style="width: 95%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="bg-gray-50 py-20">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-16 text-gray-800 animate-fade-in-up" data-aos="fade-up">Our
                Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="relative bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-4 hover:scale-105 group overflow-hidden"
                    data-aos="fade-up" data-aos-delay="100">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-blue-400/10 to-blue-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative text-center">
                        <div
                            class="text-6xl mb-4 text-blue-600 group-hover:animate-bounce group-hover:scale-110 transition-transform duration-300">
                            💻</div>
                        <h3
                            class="text-xl font-bold mb-3 bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent group-hover:from-blue-800 group-hover:to-blue-600 transition-all duration-300">
                            Technology Development</h3>
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">Custom software development, web
                            applications, mobile apps, and
                            digital solutions tailored to your needs.</p>
                        <button
                            class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-2 rounded-full hover:from-blue-700 hover:to-blue-800 transition-all duration-300 transform hover:scale-110 hover:shadow-lg text-sm font-medium">
                            <i class="fas fa-arrow-right mr-2"></i>Learn More
                        </button>
                    </div>
                    <div
                        class="absolute -bottom-2 -right-2 w-20 h-20 bg-blue-200 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-500">
                    </div>
                </div>
                <div class="relative bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-4 hover:scale-105 group overflow-hidden"
                    data-aos="fade-up" data-aos-delay="150">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-green-400/10 to-green-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative text-center">
                        <div
                            class="text-6xl mb-4 text-green-600 group-hover:animate-bounce group-hover:scale-110 transition-transform duration-300">
                            🎓</div>
                        <h3
                            class="text-xl font-bold mb-3 bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent group-hover:from-green-800 group-hover:to-green-600 transition-all duration-300">
                            Training Programs</h3>
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">Comprehensive training in programming,
                            data science,
                            cybersecurity, and emerging technologies.</p>
                        <button
                            class="bg-gradient-to-r from-green-600 to-green-700 text-white px-4 py-2 rounded-full hover:from-green-700 hover:to-green-800 transition-all duration-300 transform hover:scale-110 hover:shadow-lg text-sm font-medium">
                            <i class="fas fa-arrow-right mr-2"></i>Learn More
                        </button>
                    </div>
                    <div
                        class="absolute -bottom-2 -right-2 w-20 h-20 bg-green-200 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-500">
                    </div>
                </div>
                <div class="relative bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-4 hover:scale-105 group overflow-hidden"
                    data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-purple-400/10 to-purple-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative text-center">
                        <div
                            class="text-6xl mb-4 text-purple-600 group-hover:animate-bounce group-hover:scale-110 transition-transform duration-300">
                            📊</div>
                        <h3
                            class="text-xl font-bold mb-3 bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent group-hover:from-purple-800 group-hover:to-purple-600 transition-all duration-300">
                            Consulting Services</h3>
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">Expert advice on digital transformation,
                            IT strategy, and
                            implementation of innovative solutions.</p>
                        <button
                            class="bg-gradient-to-r from-purple-600 to-purple-700 text-white px-4 py-2 rounded-full hover:from-purple-700 hover:to-purple-800 transition-all duration-300 transform hover:scale-110 hover:shadow-lg text-sm font-medium">
                            <i class="fas fa-arrow-right mr-2"></i>Learn More
                        </button>
                    </div>
                    <div
                        class="absolute -bottom-2 -right-2 w-20 h-20 bg-purple-200 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-500">
                    </div>
                </div>
                <div class="relative bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-4 hover:scale-105 group overflow-hidden"
                    data-aos="fade-up" data-aos-delay="250">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-red-400/10 to-red-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative text-center">
                        <div
                            class="text-6xl mb-4 text-red-600 group-hover:animate-bounce group-hover:scale-110 transition-transform duration-300">
                            🌐</div>
                        <h3
                            class="text-xl font-bold mb-3 bg-gradient-to-r from-red-600 to-red-800 bg-clip-text text-transparent group-hover:from-red-800 group-hover:to-red-600 transition-all duration-300">
                            Website Development</h3>
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">Professional website design and
                            development services, including responsive web design and e-commerce solutions.</p>
                        <button
                            class="bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2 rounded-full hover:from-red-700 hover:to-red-800 transition-all duration-300 transform hover:scale-110 hover:shadow-lg text-sm font-medium">
                            <i class="fas fa-arrow-right mr-2"></i>Learn More
                        </button>
                    </div>
                    <div
                        class="absolute -bottom-2 -right-2 w-20 h-20 bg-red-200 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-500">
                    </div>
                </div>
                <div class="relative bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-4 hover:scale-105 group overflow-hidden"
                    data-aos="fade-up" data-aos-delay="300">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-indigo-400/10 to-indigo-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative text-center">
                        <div
                            class="text-6xl mb-4 text-indigo-600 group-hover:animate-bounce group-hover:scale-110 transition-transform duration-300">
                            🏗️</div>
                        <h3
                            class="text-xl font-bold mb-3 bg-gradient-to-r from-indigo-600 to-indigo-800 bg-clip-text text-transparent group-hover:from-indigo-800 group-hover:to-indigo-600 transition-all duration-300">
                            System Design and Development</h3>
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">End-to-end system design, architecture
                            planning, and development for complex enterprise solutions.</p>
                        <button
                            class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-4 py-2 rounded-full hover:from-indigo-700 hover:to-indigo-800 transition-all duration-300 transform hover:scale-110 hover:shadow-lg text-sm font-medium">
                            <i class="fas fa-arrow-right mr-2"></i>Learn More
                        </button>
                    </div>
                    <div
                        class="absolute -bottom-2 -right-2 w-20 h-20 bg-indigo-200 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-500">
                    </div>
                </div>
                <div class="relative bg-gradient-to-br from-pink-50 to-pink-100 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-4 hover:scale-105 group overflow-hidden"
                    data-aos="fade-up" data-aos-delay="350">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-pink-400/10 to-pink-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative text-center">
                        <div
                            class="text-6xl mb-4 text-pink-600 group-hover:animate-bounce group-hover:scale-110 transition-transform duration-300">
                            🎨</div>
                        <h3
                            class="text-xl font-bold mb-3 bg-gradient-to-r from-pink-600 to-pink-800 bg-clip-text text-transparent group-hover:from-pink-800 group-hover:to-pink-600 transition-all duration-300">
                            Business Card & Flyer Design</h3>
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">Creative graphic design services for
                            business cards, flyers, brochures, and marketing materials.</p>
                        <button
                            class="bg-gradient-to-r from-pink-600 to-pink-700 text-white px-4 py-2 rounded-full hover:from-pink-700 hover:to-pink-800 transition-all duration-300 transform hover:scale-110 hover:shadow-lg text-sm font-medium">
                            <i class="fas fa-arrow-right mr-2"></i>Learn More
                        </button>
                    </div>
                    <div
                        class="absolute -bottom-2 -right-2 w-20 h-20 bg-pink-200 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-500">
                    </div>
                </div>
                <div class="relative bg-gradient-to-br from-teal-50 to-teal-100 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-4 hover:scale-105 group overflow-hidden"
                    data-aos="fade-up" data-aos-delay="400">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-teal-400/10 to-teal-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative text-center">
                        <div
                            class="text-6xl mb-4 text-teal-600 group-hover:animate-bounce group-hover:scale-110 transition-transform duration-300">
                            📈</div>
                        <h3
                            class="text-xl font-bold mb-3 bg-gradient-to-r from-teal-600 to-teal-800 bg-clip-text text-transparent group-hover:from-teal-800 group-hover:to-teal-600 transition-all duration-300">
                            Data Analysis</h3>
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">Advanced data analysis, visualization, and
                            insights generation to drive business decisions.</p>
                        <button
                            class="bg-gradient-to-r from-teal-600 to-teal-700 text-white px-4 py-2 rounded-full hover:from-teal-700 hover:to-teal-800 transition-all duration-300 transform hover:scale-110 hover:shadow-lg text-sm font-medium">
                            <i class="fas fa-arrow-right mr-2"></i>Learn More
                        </button>
                    </div>
                    <div
                        class="absolute -bottom-2 -right-2 w-20 h-20 bg-teal-200 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-500">
                    </div>
                </div>
                <div class="relative bg-gradient-to-br from-orange-50 to-orange-100 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-4 hover:scale-105 group overflow-hidden"
                    data-aos="fade-up" data-aos-delay="450">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-orange-400/10 to-orange-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative text-center">
                        <div
                            class="text-6xl mb-4 text-orange-600 group-hover:animate-bounce group-hover:scale-110 transition-transform duration-300">
                            📅</div>
                        <h3
                            class="text-xl font-bold mb-3 bg-gradient-to-r from-orange-600 to-orange-800 bg-clip-text text-transparent group-hover:from-orange-800 group-hover:to-orange-600 transition-all duration-300">
                            Scheduled Training on Technology</h3>
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">Structured training programs with fixed
                            schedules covering latest technology trends and skills.</p>
                        <button
                            class="bg-gradient-to-r from-orange-600 to-orange-700 text-white px-4 py-2 rounded-full hover:from-orange-700 hover:to-orange-800 transition-all duration-300 transform hover:scale-110 hover:shadow-lg text-sm font-medium">
                            <i class="fas fa-arrow-right mr-2"></i>Learn More
                        </button>
                    </div>
                    <div
                        class="absolute -bottom-2 -right-2 w-20 h-20 bg-orange-200 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-500">
                    </div>
                </div>
                <div class="relative bg-gradient-to-br from-cyan-50 to-cyan-100 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-4 hover:scale-105 group overflow-hidden"
                    data-aos="fade-up" data-aos-delay="500">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-cyan-400/10 to-cyan-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative text-center">
                        <div
                            class="text-6xl mb-4 text-cyan-600 group-hover:animate-bounce group-hover:scale-110 transition-transform duration-300">
                            🚀</div>
                        <h3
                            class="text-xl font-bold mb-3 bg-gradient-to-r from-cyan-600 to-cyan-800 bg-clip-text text-transparent group-hover:from-cyan-800 group-hover:to-cyan-600 transition-all duration-300">
                            Unscheduled Trainings on Technology</h3>
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">Flexible, on-demand training sessions
                            tailored to individual or group needs in technology.</p>
                        <button
                            class="bg-gradient-to-r from-cyan-600 to-cyan-700 text-white px-4 py-2 rounded-full hover:from-cyan-700 hover:to-cyan-800 transition-all duration-300 transform hover:scale-110 hover:shadow-lg text-sm font-medium">
                            <i class="fas fa-arrow-right mr-2"></i>Learn More
                        </button>
                    </div>
                    <div
                        class="absolute -bottom-2 -right-2 w-20 h-20 bg-cyan-200 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-500">
                    </div>
                </div>
                <div class="relative bg-gradient-to-br from-lime-50 to-lime-100 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-4 hover:scale-105 group overflow-hidden"
                    data-aos="fade-up" data-aos-delay="550">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-lime-400/10 to-lime-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative text-center">
                        <div
                            class="text-6xl mb-4 text-lime-600 group-hover:animate-bounce group-hover:scale-110 transition-transform duration-300">
                            🏭</div>
                        <h3
                            class="text-xl font-bold mb-3 bg-gradient-to-r from-lime-600 to-lime-800 bg-clip-text text-transparent group-hover:from-lime-800 group-hover:to-lime-600 transition-all duration-300">
                            Industrial Attachment</h3>
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">Practical training and internship programs
                            for TVET students and university graduates in technology fields.</p>
                        <button
                            class="bg-gradient-to-r from-lime-600 to-lime-700 text-white px-4 py-2 rounded-full hover:from-lime-700 hover:to-lime-800 transition-all duration-300 transform hover:scale-110 hover:shadow-lg text-sm font-medium">
                            <i class="fas fa-arrow-right mr-2"></i>Learn More
                        </button>
                    </div>
                    <div
                        class="absolute -bottom-2 -right-2 w-20 h-20 bg-lime-200 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-500">
                    </div>
                </div>
                <div class="relative bg-gradient-to-br from-amber-50 to-amber-100 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-4 hover:scale-105 group overflow-hidden"
                    data-aos="fade-up" data-aos-delay="600">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-amber-400/10 to-amber-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative text-center">
                        <div
                            class="text-6xl mb-4 text-amber-600 group-hover:animate-bounce group-hover:scale-110 transition-transform duration-300">
                            🖥️</div>
                        <h3
                            class="text-xl font-bold mb-3 bg-gradient-to-r from-amber-600 to-amber-800 bg-clip-text text-transparent group-hover:from-amber-800 group-hover:to-amber-600 transition-all duration-300">
                            Hosting Services</h3>
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">Reliable web hosting, cloud hosting, and
                            server management solutions for your applications.</p>
                        <button
                            class="bg-gradient-to-r from-amber-600 to-amber-700 text-white px-4 py-2 rounded-full hover:from-amber-700 hover:to-amber-800 transition-all duration-300 transform hover:scale-110 hover:shadow-lg text-sm font-medium">
                            <i class="fas fa-arrow-right mr-2"></i>Learn More
                        </button>
                    </div>
                    <div
                        class="absolute -bottom-2 -right-2 w-20 h-20 bg-amber-200 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-500">
                    </div>
                </div>
                <div class="relative bg-gradient-to-br from-emerald-50 to-emerald-100 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-4 hover:scale-105 group overflow-hidden"
                    data-aos="fade-up" data-aos-delay="650">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-emerald-400/10 to-emerald-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative text-center">
                        <div
                            class="text-6xl mb-4 text-emerald-600 group-hover:animate-bounce group-hover:scale-110 transition-transform duration-300">
                            ⌨️</div>
                        <h3
                            class="text-xl font-bold mb-3 bg-gradient-to-r from-emerald-600 to-emerald-800 bg-clip-text text-transparent group-hover:from-emerald-800 group-hover:to-emerald-600 transition-all duration-300">
                            Advanced Computer Skills Training</h3>
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">Advanced training in computer skills,
                            including software proficiency, system administration, and IT support.</p>
                        <button
                            class="bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-4 py-2 rounded-full hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 transform hover:scale-110 hover:shadow-lg text-sm font-medium">
                            <i class="fas fa-arrow-right mr-2"></i>Learn More
                        </button>
                    </div>
                    <div
                        class="absolute -bottom-2 -right-2 w-20 h-20 bg-emerald-200 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-500">
                    </div>
                </div>
                <div class="relative bg-gradient-to-br from-violet-50 to-violet-100 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-4 hover:scale-105 group overflow-hidden"
                    data-aos="fade-up" data-aos-delay="700">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-violet-400/10 to-violet-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative text-center">
                        <div
                            class="text-6xl mb-4 text-violet-600 group-hover:animate-bounce group-hover:scale-110 transition-transform duration-300">
                            👨‍🏫</div>
                        <h3
                            class="text-xl font-bold mb-3 bg-gradient-to-r from-violet-600 to-violet-800 bg-clip-text text-transparent group-hover:from-violet-800 group-hover:to-violet-600 transition-all duration-300">
                            Mentorship on Technology</h3>
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">Personalized mentorship programs to guide
                            individuals in their technology career development and projects.</p>
                        <button
                            class="bg-gradient-to-r from-violet-600 to-violet-700 text-white px-4 py-2 rounded-full hover:from-violet-700 hover:to-violet-800 transition-all duration-300 transform hover:scale-110 hover:shadow-lg text-sm font-medium">
                            <i class="fas fa-arrow-right mr-2"></i>Learn More
                        </button>
                    </div>
                    <div
                        class="absolute -bottom-2 -right-2 w-20 h-20 bg-violet-200 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-500">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-16 text-gray-800 animate-fade-in-up" data-aos="fade-up">Our
                Portfolio</h2>
            <div class="swiper portfolioSwiper" data-aos="fade-up">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div
                            class="bg-gradient-to-br from-blue-100 to-blue-200 p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300 text-center transform hover:-translate-y-2 group">
                            <i class="fas fa-shopping-cart text-6xl text-blue-600 mb-4 group-hover:animate-bounce"></i>
                            <h3 class="text-2xl font-semibold mb-4">E-Commerce Platform</h3>
                            <p class="text-gray-700 mb-4">Built a scalable online store for a local retailer, increasing
                                sales by 40%. Features include inventory management, payment integration, and responsive
                                design.</p>
                            <button
                                class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition duration-300 transform hover:scale-110"
                                onclick="openModal('ecommerce')">
                                <i class="fas fa-eye mr-2"></i>View Details
                            </button>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div
                            class="bg-gradient-to-br from-green-100 to-green-200 p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300 text-center transform hover:-translate-y-2 group">
                            <i class="fas fa-mobile-alt text-6xl text-green-600 mb-4 group-hover:animate-bounce"></i>
                            <h3 class="text-2xl font-semibold mb-4">Mobile Banking App</h3>
                            <p class="text-gray-700 mb-4">Developed a secure mobile banking solution for a financial
                                institution, enabling seamless transactions and account management.</p>
                            <button
                                class="bg-green-600 text-white px-6 py-2 rounded-full hover:bg-green-700 transition duration-300 transform hover:scale-110"
                                onclick="openModal('banking')">
                                <i class="fas fa-eye mr-2"></i>View Details
                            </button>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div
                            class="bg-gradient-to-br from-purple-100 to-purple-200 p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300 text-center transform hover:-translate-y-2 group">
                            <i class="fas fa-chart-line text-6xl text-purple-600 mb-4 group-hover:animate-bounce"></i>
                            <h3 class="text-2xl font-semibold mb-4">Data Analytics Dashboard</h3>
                            <p class="text-gray-700 mb-4">Created a real-time analytics tool for government data
                                management, providing insights and visualizations for better decision-making.</p>
                            <button
                                class="bg-purple-600 text-white px-6 py-2 rounded-full hover:bg-purple-700 transition duration-300 transform hover:scale-110"
                                onclick="openModal('analytics')">
                                <i class="fas fa-eye mr-2"></i>View Details
                            </button>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div
                            class="bg-gradient-to-br from-red-100 to-red-200 p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300 text-center transform hover:-translate-y-2 group">
                            <i class="fas fa-graduation-cap text-6xl text-red-600 mb-4 group-hover:animate-bounce"></i>
                            <h3 class="text-2xl font-semibold mb-4">Learning Management System</h3>
                            <p class="text-gray-700 mb-4">Developed an LMS for educational institutions, featuring
                                course management, student tracking, and interactive content delivery.</p>
                            <button
                                class="bg-red-600 text-white px-6 py-2 rounded-full hover:bg-red-700 transition duration-300 transform hover:scale-110"
                                onclick="openModal('lms')">
                                <i class="fas fa-eye mr-2"></i>View Details
                            </button>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div
                            class="bg-gradient-to-br from-yellow-100 to-yellow-200 p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300 text-center transform hover:-translate-y-2 group">
                            <i class="fas fa-hospital text-6xl text-yellow-600 mb-4 group-hover:animate-bounce"></i>
                            <h3 class="text-2xl font-semibold mb-4">Healthcare Management System</h3>
                            <p class="text-gray-700 mb-4">Built a comprehensive system for hospitals, including patient
                                records, appointment scheduling, and telemedicine features.</p>
                            <button
                                class="bg-yellow-600 text-white px-6 py-2 rounded-full hover:bg-yellow-700 transition duration-300 transform hover:scale-110"
                                onclick="openModal('healthcare')">
                                <i class="fas fa-eye mr-2"></i>View Details
                            </button>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination mt-8"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>

    <!-- Modal for Portfolio Details -->
    <div id="portfolioModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-lg max-w-2xl w-full max-h-96 overflow-y-auto relative">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">
                <i class="fas fa-times"></i>
            </button>
            <h3 class="text-2xl font-bold mb-4" id="modalTitle"></h3>
            <p id="modalContent" class="text-gray-700 leading-relaxed"></p>
        </div>
    </div>

    <!-- Testimonials Section -->
    <section id="testimonials" class="bg-gray-50 py-20">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-16 text-gray-800 animate-fade-in-up" data-aos="fade-up">What
                Our Clients Say</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2"
                    data-aos="fade-up">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 mr-2">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <span class="text-gray-600 text-sm">(5.0)</span>
                    </div>
                    <p class="text-gray-600 mb-6 italic">"CodeRwanda transformed our business operations with their
                        innovative software solutions. Highly recommend!"</p>
                    <div class="flex items-center">
                        <img src="https://via.placeholder.com/50" alt="Client" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-semibold">IRADUKUNDA Deo</h4>
                            <p class="text-gray-500">CEO, VisionX Rwanda</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2"
                    data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 mr-2">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <span class="text-gray-600 text-sm">(5.0)</span>
                    </div>
                    <p class="text-gray-600 mb-6 italic">"Their training programs equipped our team with essential
                        skills. Outstanding quality and support."</p>
                    <div class="flex items-center">
                        <img src="https://via.placeholder.com/50" alt="Client" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-semibold">NTIRUSHWA Jean Claude</h4>
                            <p class="text-gray-500">PR, Innovate Ltd</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 mr-2">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <span class="text-gray-600 text-sm">(5.0)</span>
                    </div>
                    <p class="text-gray-600 mb-6 italic">"The consulting services provided valuable insights that helped
                        us scale our operations efficiently."</p>
                    <div class="flex items-center">
                        <img src="https://via.placeholder.com/50" alt="Client" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-semibold">NIYOGUSHIMWA Nathanael</h4>
                            <p class="text-gray-500">CEO, NADEVA Ltd</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-16 text-gray-800 animate-fade-in-up" data-aos="fade-up">Latest
                News & Insights</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-2 group"
                    data-aos="fade-up">
                    <div
                        class="h-48 bg-gradient-to-br from-blue-200 to-blue-300 rounded mb-4 flex items-center justify-center group-hover:animate-pulse">
                        <i class="fas fa-robot text-6xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 group-hover:text-blue-600 transition duration-300">The Future
                        of AI in Rwanda</h3>
                    <p class="text-gray-600 mb-4">Exploring how artificial intelligence is shaping industries in Rwanda
                        and what it means for the future.</p>
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold transition duration-300">
                        Read More <i
                            class="fas fa-arrow-right ml-1 group-hover:translate-x-1 transition duration-300"></i>
                    </a>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-2 group"
                    data-aos="fade-up" data-aos-delay="100">
                    <div
                        class="h-48 bg-gradient-to-br from-green-200 to-green-300 rounded mb-4 flex items-center justify-center group-hover:animate-pulse">
                        <i class="fas fa-code text-6xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 group-hover:text-green-600 transition duration-300">Coding
                        Bootcamps: Changing Lives</h3>
                    <p class="text-gray-600 mb-4">How our intensive coding programs are empowering Rwandan youth with
                        in-demand tech skills.</p>
                    <a href="#" class="text-green-600 hover:text-green-800 font-semibold transition duration-300">
                        Read More <i
                            class="fas fa-arrow-right ml-1 group-hover:translate-x-1 transition duration-300"></i>
                    </a>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-2 group"
                    data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="h-48 bg-gradient-to-br from-purple-200 to-purple-300 rounded mb-4 flex items-center justify-center group-hover:animate-pulse">
                        <i class="fas fa-shield-alt text-6xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 group-hover:text-purple-600 transition duration-300">
                        Cybersecurity Best Practices</h3>
                    <p class="text-gray-600 mb-4">Essential tips for businesses in Rwanda to protect against cyber
                        threats in the digital age.</p>
                    <a href="#" class="text-purple-600 hover:text-purple-800 font-semibold transition duration-300">
                        Read More <i
                            class="fas fa-arrow-right ml-1 group-hover:translate-x-1 transition duration-300"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="bg-blue-600 text-white py-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h2 class="text-3xl font-bold mb-6 animate-fade-in-up" data-aos="fade-up">Stay Updated</h2>
            <p class="text-xl mb-8 animate-fade-in-up" data-aos="fade-up" data-aos-delay="100">
                Subscribe to our newsletter for the latest tech trends and company updates.
            </p>
            <form action="#" method="post" class="max-w-md mx-auto animate-fade-in-up" data-aos="fade-up"
                data-aos-delay="200">
                <div class="flex flex-col sm:flex-row">
                    <input type="email" placeholder="Enter your email"
                        class="flex-1 px-4 py-3 rounded-lg sm:rounded-r-none focus:outline-none focus:ring-2 focus:ring-white mb-2 sm:mb-0"
                        required>
                    <button type="submit"
                        class="bg-white text-blue-600 px-6 py-3 rounded-lg sm:rounded-l-none font-semibold hover:bg-gray-100 transition duration-300 transform hover:scale-105">
                        <i class="fas fa-paper-plane mr-2"></i>Subscribe
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Join Us Form Section -->
    <section id="contact" class="bg-white py-20">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800 animate-fade-in-up" data-aos="fade-up">
                Join Us for Our Services
            </h2>
            <div class="max-w-2xl mx-auto bg-gray-50 p-10 rounded-xl shadow-lg" data-aos="fade-up">
                <form action="index.php" method="post" id="joinForm">
                    <div class="mb-6">
                        <label for="name" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-user mr-2 text-blue-600"></i>Name
                        </label>
                        <input type="text" id="name" name="name"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300"
                            required>
                    </div>
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-envelope mr-2 text-blue-600"></i>Email
                        </label>
                        <input type="email" id="email" name="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300"
                            required>
                    </div>
                    <div class="mb-6">
                        <label for="service" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-cogs mr-2 text-blue-600"></i>Service Interested In
                        </label>
                        <select id="service" name="service"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300"
                            required>
                            <option value="">Select a service</option>
                            <option value="Technology Development">Technology Development</option>
                            <option value="Training Programs">Training Programs</option>
                            <option value="Consulting Services">Consulting Services</option>
                            <option value="Website Development">Website Development</option>
                            <option value="System Design and Development">System Design and Development</option>
                            <option value="Business Card & Flyer Design">Business Card & Flyer Design</option>
                            <option value="Data Analysis">Data Analysis</option>
                            <option value="Scheduled Training on Technology">Scheduled Training on Technology</option>
                            <option value="Unscheduled Trainings on Technology">Unscheduled Trainings on Technology
                            </option>
                            <option value="Industrial Attachment">Industrial Attachment</option>
                            <option value="Hosting Services">Hosting Services</option>
                            <option value="Advanced Computer Skills Training">Advanced Computer Skills Training</option>
                            <option value="Mentorship on Technology">Mentorship on Technology</option>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label for="message" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-comment mr-2 text-blue-600"></i>Message
                        </label>
                        <textarea id="message" name="message" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300"></textarea>
                    </div>
                    <button type="submit" name="submit_join"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 shadow-lg transform hover:scale-105">
                        <i class="fas fa-paper-plane mr-2"></i>Submit Request
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Holiday Training Application Section -->
    <section id="holiday-training" class="bg-gradient-to-r from-green-50 to-blue-50 py-20">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800 animate-fade-in-up" data-aos="fade-up">
                Apply for Holiday/Vacation Training Program
            </h2>
            <div class="max-w-2xl mx-auto bg-white p-10 rounded-xl shadow-lg animate-slide-in-left" data-aos="fade-up"
                data-aos-delay="100">
                <form action="index.php" method="post" id="holidayTrainingForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="ht_name" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-user mr-2 text-green-600"></i>Name
                            </label>
                            <input type="text" id="ht_name" name="name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-300"
                                required>
                        </div>
                        <div>
                            <label for="ht_email" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-envelope mr-2 text-green-600"></i>Email
                            </label>
                            <input type="email" id="ht_email" name="email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-300"
                                required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="ht_phone" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-phone mr-2 text-green-600"></i>Phone
                            </label>
                            <input type="tel" id="ht_phone" name="phone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-300">
                        </div>
                        <div>
                            <label for="program_type" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-graduation-cap mr-2 text-green-600"></i>Program Type
                            </label>
                            <select id="program_type" name="program_type"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-300"
                                required>
                                <option value="">Select program type</option>
                                <option value="Web Development">Web Development</option>
                                <option value="Mobile App Development">Mobile App Development</option>
                                <option value="Data Science">Data Science</option>
                                <option value="Cybersecurity">Cybersecurity</option>
                                <option value="Cloud Computing">Cloud Computing</option>
                                <option value="AI/ML">AI/ML</option>
                                <option value="Digital Marketing">Digital Marketing</option>
                                <option value="UI/UX Design">UI/UX Design</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="duration" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-clock mr-2 text-green-600"></i>Duration
                            </label>
                            <select id="duration" name="duration"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-300">
                                <option value="">Select duration</option>
                                <option value="1 Week">1 Week</option>
                                <option value="2 Weeks">2 Weeks</option>
                                <option value="3 Weeks">3 Weeks</option>
                                <option value="1 Month">1 Month</option>
                                <option value="2 Months">2 Months</option>
                            </select>
                        </div>
                        <div>
                            <label for="start_date" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-calendar mr-2 text-green-600"></i>Preferred Start Date
                            </label>
                            <input type="date" id="start_date" name="start_date"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-300">
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="ht_message" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-comment mr-2 text-green-600"></i>Additional Information
                        </label>
                        <textarea id="ht_message" name="message" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-300"
                            placeholder="Tell us about your background and goals..."></textarea>
                    </div>
                    <button type="submit" name="submit_holiday_training"
                        class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition duration-300 shadow-lg transform hover:scale-105 animate-pulse-custom">
                        <i class="fas fa-paper-plane mr-2"></i>Apply for Training Program
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Service Application Section -->
    <section id="service-application" class="bg-gradient-to-r from-purple-50 to-pink-50 py-20">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800 animate-fade-in-up" data-aos="fade-up">
                Apply for Our Services
            </h2>
            <div class="max-w-2xl mx-auto bg-white p-10 rounded-xl shadow-lg animate-slide-in-right" data-aos="fade-up"
                data-aos-delay="100">
                <form action="index.php" method="post" id="serviceApplicationForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="sa_name" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-user mr-2 text-purple-600"></i>Name
                            </label>
                            <input type="text" id="sa_name" name="name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300"
                                required>
                        </div>
                        <div>
                            <label for="sa_email" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-envelope mr-2 text-purple-600"></i>Email
                            </label>
                            <input type="email" id="sa_email" name="email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300"
                                required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="sa_phone" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-phone mr-2 text-purple-600"></i>Phone
                            </label>
                            <input type="tel" id="sa_phone" name="phone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300">
                        </div>
                        <div>
                            <label for="company" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-building mr-2 text-purple-600"></i>Company/Organization
                            </label>
                            <input type="text" id="company" name="company"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300">
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="service_type" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-cogs mr-2 text-purple-600"></i>Service Type
                        </label>
                        <select id="service_type" name="service_type"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300"
                            required>
                            <option value="">Select service type</option>
                            <option value="Technology Development">Technology Development</option>
                            <option value="Website Development">Website Development</option>
                            <option value="Mobile App Development">Mobile App Development</option>
                            <option value="System Design and Development">System Design and Development</option>
                            <option value="Data Analysis">Data Analysis</option>
                            <option value="Consulting Services">Consulting Services</option>
                            <option value="Business Card & Flyer Design">Business Card & Flyer Design</option>
                            <option value="Hosting Services">Hosting Services</option>
                            <option value="Training Programs">Training Programs</option>
                            <option value="Mentorship">Mentorship</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="budget" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-dollar-sign mr-2 text-purple-600"></i>Budget Range
                            </label>
                            <select id="budget" name="budget"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300">
                                <option value="">Select budget range</option>
                                <option value="Under $1,000">Under $1,000</option>
                                <option value="$1,000 - $5,000">$1,000 - $5,000</option>
                                <option value="$5,000 - $10,000">$5,000 - $10,000</option>
                                <option value="$10,000 - $25,000">$10,000 - $25,000</option>
                                <option value="$25,000 - $50,000">$25,000 - $50,000</option>
                                <option value="Over $50,000">Over $50,000</option>
                            </select>
                        </div>
                        <div>
                            <label for="timeline" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-calendar-alt mr-2 text-purple-600"></i>Project Timeline
                            </label>
                            <select id="timeline" name="timeline"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300">
                                <option value="">Select timeline</option>
                                <option value="ASAP">ASAP</option>
                                <option value="1-2 weeks">1-2 weeks</option>
                                <option value="1 month">1 month</option>
                                <option value="2-3 months">2-3 months</option>
                                <option value="3-6 months">3-6 months</option>
                                <option value="6+ months">6+ months</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="sa_message" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-comment mr-2 text-purple-600"></i>Project Details
                        </label>
                        <textarea id="sa_message" name="message" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300"
                            placeholder="Describe your project requirements..."></textarea>
                    </div>
                    <button type="submit" name="submit_service_application"
                        class="w-full bg-purple-600 text-white py-3 rounded-lg font-semibold hover:bg-purple-700 transition duration-300 shadow-lg transform hover:scale-105 animate-pulse-custom">
                        <i class="fas fa-paper-plane mr-2"></i>Submit Service Application
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900 to-purple-900 opacity-20"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4 gradient-text">CodeRwanda</h3>
                    <p class="text-gray-400 mb-4">Empowering Rwanda through technology and innovation.</p>
                    <div class="flex space-x-4">
                        <a href="https://facebook.com/coderwanda"
                            class="text-gray-400 hover:text-blue-400 transition duration-300 text-2xl">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="https://twitter.com/coderwanda"
                            class="text-gray-400 hover:text-blue-400 transition duration-300 text-2xl">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://linkedin.com/company/coderwanda"
                            class="text-gray-400 hover:text-blue-400 transition duration-300 text-2xl">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="https://github.com/coderwanda"
                            class="text-gray-400 hover:text-gray-300 transition duration-300 text-2xl">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Services</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#services" class="hover:text-white transition duration-300">Technology
                                Development</a></li>
                        <li><a href="#services" class="hover:text-white transition duration-300">Training Programs</a>
                        </li>
                        <li><a href="#services" class="hover:text-white transition duration-300">Consulting Services</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="about.php" class="hover:text-white transition duration-300">About Us</a></li>
                        <li><a href="#portfolio" class="hover:text-white transition duration-300">Portfolio</a></li>
                        <li><a href="contact.php" class="hover:text-white transition duration-300">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Contact Info</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-map-marker-alt mr-2"></i>Musanze, Rwanda</li>
                        <li><i class="fas fa-phone mr-2"></i>+250 781 257 942</li>
                        <li><i class="fas fa-envelope mr-2"></i>ndikubwimanaeric2019@gmail.com</li>
                        <li><i class="fas fa-clock mr-2"></i>Mon-Fri: 8AM-6PM</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p>&copy; 2024 CodeRwanda. All rights reserved. | Made with <i class="fas fa-heart text-red-500"></i> in
                    Rwanda</p>
            </div>
        </div>
    </footer>

    <!-- Chat Widget -->
    <div id="chat-widget" class="fixed bottom-6 right-6 z-50">
        <div id="chat-button"
            class="bg-blue-600 text-white w-16 h-16 rounded-full flex items-center justify-center cursor-pointer shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-110">
            <i class="fas fa-comments text-2xl"></i>
        </div>
        <div id="chat-window"
            class="hidden bg-white rounded-lg shadow-xl w-80 h-96 absolute bottom-20 right-0 overflow-hidden">
            <div class="bg-blue-600 text-white p-4">
                <h3 class="font-semibold">Chat with Us</h3>
                <p class="text-sm opacity-90">We're here to help!</p>
            </div>
            <div id="chat-messages" class="p-4 h-64 overflow-y-auto bg-gray-50">
                <div class="text-center text-gray-500 text-sm">How can we assist you today?</div>
            </div>
            <div class="p-4 border-t">
                <div class="flex">
                    <input type="text" id="chat-input" placeholder="Type your message..."
                        class="flex-1 px-3 py-2 border rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button id="send-message"
                        class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button id="back-to-top"
        class="fixed bottom-6 left-6 bg-blue-600 text-white w-12 h-12 rounded-full hidden shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-110 z-40">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
    // Hide loading screen after 1 second
    window.addEventListener('load', function() {
        const loader = document.getElementById('loading-screen');
        setTimeout(() => {
            loader.classList.add('fade-out'); // smooth fade
            setTimeout(() => loader.style.display = 'none', 500); // remove after fade
        }, 1000); // 1 second
    });


    // Particles.js
    function initParticles() {
        particlesJS('particles-js', {
            particles: {
                number: {
                    value: 80,
                    density: {
                        enable: true,
                        value_area: 800
                    }
                },
                color: {
                    value: '#ffffff'
                },
                shape: {
                    type: 'circle'
                },
                opacity: {
                    value: 0.5,
                    random: false
                },
                size: {
                    value: 3,
                    random: true
                },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: '#ffffff',
                    opacity: 0.4,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 6,
                    direction: 'none',
                    random: false,
                    straight: false,
                    out_mode: 'out',
                    bounce: false
                }
            },
            interactivity: {
                detect_on: 'canvas',
                events: {
                    onhover: {
                        enable: true,
                        mode: 'repulse'
                    },
                    onclick: {
                        enable: true,
                        mode: 'push'
                    }
                },
                modes: {
                    repulse: {
                        distance: 200,
                        duration: 0.4
                    },
                    push: {
                        particles_nb: 4
                    }
                }
            },
            retina_detect: true
        });
    }

    // Theme toggle
    document.getElementById('theme-toggle').addEventListener('click', function() {
        document.body.classList.toggle('dark');
        const icon = this.querySelector('i');
        if (document.body.classList.contains('dark')) {
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
        } else {
            icon.classList.remove('fa-sun');
            icon.classList.add('fa-moon');
        }
    });

    // Mobile menu toggle
    function toggleMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }

    // Swiper initialization
    const swiper = new Swiper('.portfolioSwiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        breakpoints: {
            640: {
                slidesPerView: 2
            },
            1024: {
                slidesPerView: 3
            }
        },
    });

    // Modal functions
    function openModal(type) {
        const modal = document.getElementById('portfolioModal');
        const title = document.getElementById('modalTitle');
        const content = document.getElementById('modalContent');
        modal.classList.remove('hidden');
        if (type === 'ecommerce') {
            title.textContent = 'E-Commerce Platform';
            content.textContent =
                'Detailed description: We built a robust e-commerce platform using modern web technologies. It includes user authentication, product catalog, shopping cart, payment gateway integration with Stripe, and admin dashboard for inventory management. The platform is fully responsive and optimized for performance.';
        } else if (type === 'banking') {
            title.textContent = 'Mobile Banking App';
            content.textContent =
                'Our mobile banking app features secure transactions, account management, bill payments, and real-time notifications. Built with React Native for cross-platform compatibility and integrated with banking APIs for seamless functionality.';
        } else if (type === 'analytics') {
            title.textContent = 'Data Analytics Dashboard';
            content.textContent =
                'A comprehensive analytics dashboard using D3.js and Python backend. It provides real-time data visualization, custom reports, and predictive analytics for government data management.';
        } else if (type === 'lms') {
            title.textContent = 'Learning Management System';
            content.textContent =
                'An LMS with course creation, student progress tracking, video streaming, quizzes, and certification. Built with Laravel and Vue.js for a smooth learning experience.';
        } else if (type === 'healthcare') {
            title.textContent = 'Healthcare Management System';
            content.textContent =
                'A full-featured HMS including patient records, appointment scheduling, telemedicine integration, and billing. Compliant with healthcare standards and secure data handling.';
        }
    }

    function closeModal() {
        document.getElementById('portfolioModal').classList.add('hidden');
    }

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

    // Counter animation
    function animateCounters() {
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const increment = target / 200;
            let current = 0;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    counter.textContent = target;
                    clearInterval(timer);
                } else {
                    counter.textContent = Math.floor(current);
                }
            }, 10);
        });
    }

    // Trigger counter animation on scroll
    let animated = false;
    window.addEventListener('scroll', () => {
        const statsSection = document.querySelector('.stats-section');
        if (statsSection && !animated && statsSection.getBoundingClientRect().top < window.innerHeight - 100) {
            animateCounters();
            animated = true;
        }
    });

    // Form validation and enhancement
    document.getElementById('joinForm').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value;
        const name = document.getElementById('name').value;
        const service = document.getElementById('service').value;
        const message = document.getElementById('message').value;

        if (!email.includes('@')) {
            alert('Please enter a valid email.');
            e.preventDefault();
            return;
        }

        if (name.length < 2) {
            alert('Please enter a valid name.');
            e.preventDefault();
            return;
        }

        if (!service) {
            alert('Please select a service.');
            e.preventDefault();
            return;
        }

        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Submitting...';
        submitBtn.disabled = true;
    });

    // Chat widget
    document.getElementById('chat-button').addEventListener('click', function() {
        const chatWindow = document.getElementById('chat-window');
        chatWindow.classList.toggle('hidden');
    });

    document.getElementById('send-message').addEventListener('click', function() {
        const input = document.getElementById('chat-input');
        const message = input.value.trim();
        if (message) {
            const messagesDiv = document.getElementById('chat-messages');
            messagesDiv.innerHTML +=
                `<div class="text-right mb-2"><div class="bg-blue-600 text-white rounded-lg px-3 py-2 inline-block">${message}</div></div>`;
            input.value = '';
            messagesDiv.scrollTop = messagesDiv.scrollHeight;

            // Simulate response
            setTimeout(() => {
                messagesDiv.innerHTML +=
                    `<div class="text-left mb-2"><div class="bg-gray-300 text-gray-800 rounded-lg px-3 py-2 inline-block">Thank you for your message! We'll get back to you soon.</div></div>`;
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            }, 1000);
        }
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

    // Newsletter form
    document.querySelector('form[action="#"]').addEventListener('submit', function(e) {
        e.preventDefault();
        const email = this.querySelector('input[type="email"]').value;
        if (email) {
            alert('Thank you for subscribing! We\'ll keep you updated with the latest news.');
            this.reset();
        }
    });
    </script>
</body>

</html>