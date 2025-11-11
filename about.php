<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_holiday_training'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $program_type = htmlspecialchars($_POST['program_type']);
    $duration = htmlspecialchars($_POST['duration']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $message = htmlspecialchars($_POST['message']);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO holiday_training_applications (name, email, phone, program_type, duration, start_date, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
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
    <title>About Us - CodeRwanda</title>
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

        /* Timeline styles */
        .timeline {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
        }

        .timeline::after {
            content: '';
            position: absolute;
            width: 6px;
            background: linear-gradient(to bottom, #3b82f6, #8b5cf6, #ec4899);
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -3px;
        }

        .timeline-item {
            padding: 10px 40px;
            position: relative;
            background-color: inherit;
            width: 50%;
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            width: 25px;
            height: 25px;
            right: -17px;
            background: white;
            border: 4px solid #3b82f6;
            top: 15px;
            border-radius: 50%;
            z-index: 1;
        }

        .left {
            left: 0;
        }

        .right {
            left: 50%;
        }

        .right::after {
            left: -16px;
        }

        .timeline-content {
            padding: 20px 30px;
            background: white;
            position: relative;
            border-radius: 6px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
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
            padding: 0.75rem 1.25rem;
            border-radius: 9999px;
            font-weight: 600;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            color: #ffffff;
            text-decoration: none;
        }

        .floating-cta .cta-service {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            box-shadow: 0 16px 30px rgba(37, 99, 235, 0.35);
        }

        .floating-cta .cta-holiday {
            background: linear-gradient(135deg, #059669, #10b981);
            box-shadow: 0 16px 30px rgba(16, 185, 129, 0.35);
        }

        .floating-cta a:hover {
            transform: translateY(-4px) scale(1.02);
        }

        @media (max-width: 768px) {
            .floating-cta {
                top: auto;
                bottom: 1.5rem;
                right: 1rem;
                flex-direction: column;
            }

            .floating-cta a {
                padding: 0.65rem 1rem;
                font-size: 0.9rem;
            }
        }
    </style>
    <link rel="stylesheet" href="/assets/css/site.css">
    <script src="/assets/js/ui.js" defer></script>
</head>

<body class="font-sans bg-gray-50 text-gray-900 overflow-x-hidden cr-themed" onload="AOS.init();">
    <!-- Loading Screen -->
    <div id="loading-screen" class="fixed inset-0 bg-white z-50 flex items-center justify-center">
        <div class="text-center">
            <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-blue-600 mx-auto"></div>
            <p class="mt-4 text-gray-600">Loading About Us...</p>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-white shadow-lg sticky top-0 z-40 transition-all duration-300">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="text-3xl font-bold gradient-text animate-pulse-custom">CodeRwanda</div>
            <nav class="hidden lg:flex space-x-8">
                <a href="index.php" class="text-gray-700 hover:text-blue-600 transition duration-300 relative group">
                    Home
                    <span
                        class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all group-hover:w-full"></span>
                </a>
                <div class="relative group">
                    <a href="index.php#services"
                        class="text-gray-700 hover:text-blue-600 transition duration-300 flex items-center">
                        Services <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </a>
                    <div
                        class="absolute -left-4 mt-2 w-64 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 max-h-80 overflow-y-auto">
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Technology Development</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Training Programs</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Consulting Services</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Website Development</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">System Design and Development</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Business Card & Flyer Design</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Data Analysis</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Scheduled Training on Technology</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Unscheduled Trainings on Technology</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Industrial Attachment</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Hosting Services</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Advanced Computer Skills Training</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Mentorship on Technology</a>
                    </div>
                </div>
                <a href="index.php#portfolio" class="text-gray-700 hover:text-blue-600 transition duration-300 relative group">
                    Portfolio
                    <span
                        class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all group-hover:w-full"></span>
                </a>
                <a href="index.php#testimonials"
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
            </nav>
            <button class="lg:hidden text-gray-700" onclick="toggleMenu()">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden bg-white px-4 py-2 shadow-lg">
            <a href="index.php" class="block py-2 text-gray-700 hover:text-blue-600 transition duration-300">Home</a>
            <a href="index.php#services"
                class="block py-2 text-gray-700 hover:text-blue-600 transition duration-300">Services</a>
            <a href="index.php#portfolio"
                class="block py-2 text-gray-700 hover:text-blue-600 transition duration-300">Portfolio</a>
            <a href="index.php#testimonials"
                class="block py-2 text-gray-700 hover:text-blue-600 transition duration-300">Testimonials</a>
            <a href="about.php" class="block py-2 text-gray-700 hover:text-blue-600 transition duration-300">About
                Us</a>
            <a href="contact.php" class="block py-2 text-gray-700 hover:text-blue-600 transition duration-300">Contact
                Us</a>
        </div>
    </header>

    <div class="floating-cta">
        <a href="index.php#service-application" class="cta-service"><i class="fas fa-briefcase mr-2"></i>Apply for Services</a>
        <a href="index.php#holiday-training" class="cta-holiday"><i class="fas fa-graduation-cap mr-2"></i>Apply for Holiday Training</a>
    </div>

    <!-- About Hero -->
    <section class="bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 text-white py-32 relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="container mx-auto px-4 text-center relative z-10 animate-fade-in-up" data-aos="fade-up">
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight">
                About <span class="gradient-text">CodeRwanda</span>
            </h1>
            <p class="text-xl md:text-2xl mb-10 max-w-3xl mx-auto">
                Discover our story, values, and the team driving innovation in Rwanda. We're more than just a tech
                company - we're a movement.
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="#our-story"
                    class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold hover:bg-gray-100 transition duration-300 shadow-lg transform hover:-translate-y-1">
                    <i class="fas fa-book-open mr-2"></i>Our Story
                </a>
                <a href="#team"
                    class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition duration-300 shadow-lg transform hover:-translate-y-1">
                    <i class="fas fa-users mr-2"></i>Meet the Team
                </a>
            </div>
        </div>
        <!-- Floating elements -->
        <!-- <div class="absolute top-20 left-10 animate-bounce">
            <i class="fas fa-lightbulb text-4xl opacity-50"></i>
        </div>
        <div class="absolute top-40 right-20 animate-pulse">
            <i class="fas fa-rocket text-3xl opacity-50"></i>
        </div>
        <div class="absolute bottom-20 left-20 animate-bounce" style="animation-delay: 1s;">
            <i class="fas fa-cogs text-3xl opacity-50"></i>
        </div> -->
    </section>

    <!-- Our Story -->
    <section id="our-story" class="py-20 bg-white animate-fade-in-up" data-aos="fade-up">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-16 text-gray-800">Our Story</h2>
            <div class="max-w-6xl mx-auto">
                <div class="timeline">
                    <div class="timeline-item left" data-aos="fade-right">
                        <div class="timeline-content">
                            <h3 class="text-2xl font-bold text-blue-600 mb-4">2022: The Beginning</h3>
                            <p class="text-gray-600 mb-4">Founded in Musanze, Rwanda, with a vision to harness
                                technology for national development. Started as a small group of passionate developers
                                and educators.</p>
                            <div class="flex items-center text-blue-600">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <span class="font-semibold">Year 2022</span>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-item right" data-aos="fade-left">
                        <div class="timeline-content">
                            <h3 class="text-2xl font-bold text-green-600 mb-4">2024: First Success</h3>
                            <p class="text-gray-600 mb-4">Completed our first major project - a digital education
                                platform that reached 100+ students across Rwanda. This marked our commitment to
                                educational technology.</p>
                            <div class="flex items-center text-green-600">
                                <i class="fas fa-graduation-cap mr-2"></i>
                                <span class="font-semibold">100+ Students Reached</span>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-item left" data-aos="fade-right">
                        <div class="timeline-content">
                            <h3 class="text-2xl font-bold text-purple-600 mb-4">2024: Expansion</h3>
                            <p class="text-gray-600 mb-4">Expanded our services to include mobile app development and
                                cybersecurity training. Partnered with local businesses to digitize their operations.
                            </p>
                            <div class="flex items-center text-purple-600">
                                <i class="fas fa-mobile-alt mr-2"></i>
                                <span class="font-semibold">Mobile & Security Focus</span>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-item right" data-aos="fade-left">
                        <div class="timeline-content">
                            <h3 class="text-2xl font-bold text-red-600 mb-4">2025: Digital Transformation</h3>
                            <p class="text-gray-600 mb-4">Adapted to the digital age by launching online training
                                programs and remote consulting services. Helped businesses transition during the global
                                pandemic.</p>
                            <div class="flex items-center text-red-600">
                                <i class="fas fa-globe mr-2"></i>
                                <span class="font-semibold">Global Reach</span>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-item left" data-aos="fade-right">
                        <div class="timeline-content">
                            <h3 class="text-2xl font-bold text-indigo-600 mb-4">2025: Leadership in Innovation</h3>
                            <p class="text-gray-600 mb-4">Recognized as Rwanda's leading technology solutions provider.
                                Trained 100+ individuals and completed 10+ projects across various sectors.</p>
                            <div class="flex items-center text-indigo-600">
                                <i class="fas fa-trophy mr-2"></i>
                                <span class="font-semibold">Industry Leader</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-20 bg-gray-50" data-aos="fade-up">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div
                    class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <div class="text-center mb-6">
                        <i class="fas fa-bullseye text-6xl text-blue-600 mb-4"></i>
                        <h3 class="text-3xl font-bold text-gray-800 mb-4">Our Mission</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        To bridge the gap between technology and opportunity in Rwanda by delivering cutting-edge
                        solutions,
                        comprehensive training, and empowering individuals and businesses to thrive in the digital age.
                    </p>
                    <ul class="mt-6 space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>Innovative technology solutions
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>Quality education and training
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>Community development
                        </li>
                    </ul>
                </div>
                <div
                    class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <div class="text-center mb-6">
                        <i class="fas fa-eye text-6xl text-purple-600 mb-4"></i>
                        <h3 class="text-3xl font-bold text-gray-800 mb-4">Our Vision</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        To be Rwanda's premier technology innovation hub, creating a digitally empowered society where
                        every individual and business has access to world-class technology solutions and opportunities.
                    </p>
                    <ul class="mt-6 space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-star text-yellow-500 mr-3"></i>Technology accessibility for all
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-star text-yellow-500 mr-3"></i>Economic growth through innovation
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-star text-yellow-500 mr-3"></i>Sustainable development
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="py-20 bg-white" data-aos="fade-up">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-16 text-gray-800">Our Values</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="text-center bg-gray-50 p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-500 transform hover:-translate-y-3 hover:scale-105 group"
                    data-aos="fade-up" data-aos-delay="100">
                    <div class="text-6xl mb-6 text-yellow-500 group-hover:animate-bounce">💡</div>
                    <h3 class="text-2xl font-semibold mb-4 text-blue-600">Innovation</h3>
                    <p class="text-gray-600 mb-6">We embrace cutting-edge technologies to solve real-world problems and
                        drive progress in Rwanda through creative solutions.</p>
                    <div class="bg-yellow-200 rounded-full h-2 mt-4">
                        <div class="bg-yellow-500 h-2 rounded-full animate-pulse" style="width: 95%;"></div>
                    </div>
                </div>
                <div class="text-center bg-gray-50 p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-500 transform hover:-translate-y-3 hover:scale-105 group"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="text-6xl mb-6 text-green-500 group-hover:animate-bounce">⭐</div>
                    <h3 class="text-2xl font-semibold mb-4 text-blue-600">Excellence</h3>
                    <p class="text-gray-600 mb-6">We deliver high-quality solutions that exceed expectations and set new
                        standards in the technology industry.</p>
                    <div class="bg-green-200 rounded-full h-2 mt-4">
                        <div class="bg-green-500 h-2 rounded-full animate-pulse" style="width: 98%;"></div>
                    </div>
                </div>
                <div class="text-center bg-gray-50 p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-500 transform hover:-translate-y-3 hover:scale-105 group"
                    data-aos="fade-up" data-aos-delay="300">
                    <div class="text-6xl mb-6 text-purple-500 group-hover:animate-bounce">🤝</div>
                    <h3 class="text-2xl font-semibold mb-4 text-blue-600">Community</h3>
                    <p class="text-gray-600 mb-6">We believe in building strong partnerships and giving back to our
                        community through education and support programs.</p>
                    <div class="bg-purple-200 rounded-full h-2 mt-4">
                        <div class="bg-purple-500 h-2 rounded-full animate-pulse" style="width: 92%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Achievements -->
    <section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600 text-white" data-aos="fade-up">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-16">Our Achievements</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="bg-white bg-opacity-10 backdrop-blur-lg p-6 rounded-xl" data-aos="fade-up">
                    <div class="text-4xl mb-4">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="text-3xl font-bold mb-2">100+</div>
                    <p class="text-blue-100">Individuals Trained</p>
                </div>
                <div class="bg-white bg-opacity-10 backdrop-blur-lg p-6 rounded-xl" data-aos="fade-up"
                    data-aos-delay="100">
                    <div class="text-4xl mb-4">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <div class="text-3xl font-bold mb-2">10+</div>
                    <p class="text-blue-100">Projects Completed</p>
                </div>
                <div class="bg-white bg-opacity-10 backdrop-blur-lg p-6 rounded-xl" data-aos="fade-up"
                    data-aos-delay="200">
                    <div class="text-4xl mb-4">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div class="text-3xl font-bold mb-2">5+</div>
                    <p class="text-blue-100">Business Partners</p>
                </div>
                <div class="bg-white bg-opacity-10 backdrop-blur-lg p-6 rounded-xl" data-aos="fade-up"
                    data-aos-delay="300">
                    <div class="text-4xl mb-4">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="text-3xl font-bold mb-2">3+</div>
                    <p class="text-blue-100">Years of Excellence</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team -->
    <section id="team" class="py-20 bg-white" data-aos="fade-up">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-16 text-gray-800">Meet Our Team</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-2 group"
                    data-aos="fade-up" data-aos-delay="100">
                    <div
                        class="w-32 h-32 mx-auto mb-4 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center group-hover:animate-pulse">
                        <i class="fas fa-user-tie text-4xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">NDIKUBWIMANA Eric</h3>
                    <p class="text-gray-600 mb-4">CEO & Founder</p>
                    <p class="text-sm text-gray-500 mb-4">Visionary leader with 6+ years in tech innovation and
                        business development.</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-blue-600 hover:text-blue-800 transition duration-300">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-gray-800 transition duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
                <div class="text-center bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-2 group"
                    data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="w-32 h-32 mx-auto mb-4 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center group-hover:animate-pulse">
                        <i class="fas fa-cogs text-4xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">NIYOGUSHIMWA Nathanel</h3>
                    <p class="text-gray-600 mb-4">CTO</p>
                    <p class="text-sm text-gray-500 mb-4">Expert in scalable software architecture, AI, and cloud
                        technologies.</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-blue-600 hover:text-blue-800 transition duration-300">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-gray-800 transition duration-300">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </div>
                <div class="text-center bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-2 group"
                    data-aos="fade-up" data-aos-delay="300">
                    <div
                        class="w-32 h-32 mx-auto mb-4 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center group-hover:animate-pulse">
                        <i class="fas fa-chalkboard-teacher text-4xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">NISHIMWE Antoinete</h3>
                    <p class="text-gray-600 mb-4">Head of Training</p>
                    <p class="text-sm text-gray-500 mb-4">Passionate educator with expertise in coding bootcamps and
                        curriculum development.</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-blue-600 hover:text-blue-800 transition duration-300">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-gray-800 transition duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
                <div class="text-center bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-2 group"
                    data-aos="fade-up" data-aos-delay="400">
                    <div
                        class="w-32 h-32 mx-auto mb-4 bg-gradient-to-br from-red-400 to-red-600 rounded-full flex items-center justify-center group-hover:animate-pulse">
                        <i class="fas fa-shield-alt text-4xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">IRASUBIZA Alphonsine</h3>
                    <p class="text-gray-600 mb-4">Cybersecurity Lead</p>
                    <p class="text-sm text-gray-500 mb-4">Certified expert in digital security, risk management, and
                        ethical hacking.</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-blue-600 hover:text-blue-800 transition duration-300">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-gray-800 transition duration-300">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600 text-white" data-aos="fade-up">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-6">Ready to Join Our Mission?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Whether you're looking to transform your business, learn new skills, or partner with us,
                we're here to help you succeed in the digital age.
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="contact.php"
                    class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold hover:bg-gray-100 transition duration-300 shadow-lg transform hover:scale-105">
                    <i class="fas fa-envelope mr-2"></i>Get in Touch
                </a>
                <a href="#services"
                    class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition duration-300 shadow-lg transform hover:scale-105">
                    <i class="fas fa-rocket mr-2"></i>Explore Services
                </a>
            </div>
        </div>
    </section>

    <!-- Holiday Training Application Section -->
    <section class="bg-gradient-to-r from-green-50 to-blue-50 py-20">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800 animate-fade-in-up" data-aos="fade-up">
                Apply for Holiday/Vacation Training Program
            </h2>
            <div class="max-w-2xl mx-auto bg-white p-10 rounded-xl shadow-lg animate-slide-in-left" data-aos="fade-up" data-aos-delay="100">
                <form action="about.php" method="post" id="holidayTrainingForm">
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
    <section class="bg-gradient-to-r from-purple-50 to-pink-50 py-20">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800 animate-fade-in-up" data-aos="fade-up">
                Apply for Our Services
            </h2>
            <div class="max-w-2xl mx-auto bg-white p-10 rounded-xl shadow-lg animate-slide-in-right" data-aos="fade-up" data-aos-delay="100">
                <form action="about.php" method="post" id="serviceApplicationForm">
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
                        <li><i class="fas fa-map-marker-alt mr-2"></i>Kigali, Rwanda</li>
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

        // Mobile menu toggle
        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
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
    </script>
</body>

</html>