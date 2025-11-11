<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_contact'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);
    if ($stmt->execute()) {
        echo "<script>alert('Thank you $name, your message has been sent.');</script>";
    } else {
        echo "<script>alert('Error sending message. Please try again.');</script>";
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
    <title>Contact Us - CodeRwanda</title>
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

        /* Map container */
        .map-container {
            position: relative;
            width: 100%;
            height: 400px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
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
            <p class="mt-4 text-gray-600">Loading Contact...</p>
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
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Technology
                            Development</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Training
                            Programs</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Consulting
                            Services</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Website
                            Development</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">System
                            Design and Development</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Business
                            Card & Flyer Design</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Data
                            Analysis</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Scheduled
                            Training on Technology</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Unscheduled
                            Trainings on Technology</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Industrial
                            Attachment</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Hosting
                            Services</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Advanced
                            Computer Skills Training</a>
                        <a href="index.php#services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Mentorship
                            on Technology</a>
                    </div>
                </div>
                <a href="index.php#portfolio"
                    class="text-gray-700 hover:text-blue-600 transition duration-300 relative group">
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

    <!-- Contact Hero -->
    <section class="bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 text-white py-32 relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="container mx-auto px-4 text-center relative z-10 animate-fade-in-up" data-aos="fade-up">
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight">
                Get in <span class="gradient-text">Touch</span>
            </h1>
            <p class="text-xl md:text-2xl mb-10 max-w-3xl mx-auto">
                Ready to transform your business? Have questions about our services? We'd love to hear from you.
                Let's start a conversation about your technology needs.
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="#contact-form"
                    class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold hover:bg-gray-100 transition duration-300 shadow-lg transform hover:-translate-y-1">
                    <i class="fas fa-envelope mr-2"></i>Send Message
                </a>
                <a href="#contact-info"
                    class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition duration-300 shadow-lg transform hover:-translate-y-1">
                    <i class="fas fa-phone mr-2"></i>Call Us
                </a>
            </div>
        </div>
        <!-- Floating elements -->
        <!-- <div class="absolute top-20 left-10 animate-bounce">
            <i class="fas fa-paper-plane text-4xl opacity-50"></i>
        </div>
        <div class="absolute top-40 right-20 animate-pulse">
            <i class="fas fa-comments text-3xl opacity-50"></i>
        </div>
        <div class="absolute bottom-20 left-20 animate-bounce" style="animation-delay: 1s;">
            <i class="fas fa-envelope text-3xl opacity-50"></i>
        </div> -->
    </section>

    <!-- Contact Form and Info -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div id="contact-form" class="bg-white p-10 rounded-xl shadow-lg animate-slide-in-left"
                    data-aos="fade-right">
                    <h2 class="text-3xl font-bold mb-8 text-gray-800 flex items-center">
                        <i class="fas fa-paper-plane mr-3 text-blue-600"></i>Send Us a Message
                    </h2>
                    <form action="contact.php" method="post" id="contactForm">
                        <div class="mb-6">
                            <label for="name" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-user mr-2 text-blue-600"></i>Full Name
                            </label>
                            <input type="text" id="name" name="name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300"
                                required placeholder="Enter your full name">
                        </div>
                        <div class="mb-6">
                            <label for="email" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-envelope mr-2 text-blue-600"></i>Email Address
                            </label>
                            <input type="email" id="email" name="email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300"
                                required placeholder="your@email.com">
                        </div>
                        <div class="mb-6">
                            <label for="subject" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-tag mr-2 text-blue-600"></i>Subject
                            </label>
                            <input type="text" id="subject" name="subject"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300"
                                required placeholder="What's this about?">
                        </div>
                        <div class="mb-6">
                            <label for="message" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-comment mr-2 text-blue-600"></i>Message
                            </label>
                            <textarea id="message" name="message" rows="6"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300"
                                required placeholder="Tell us about your project or inquiry..."></textarea>
                        </div>
                        <button type="submit" name="submit_contact" id="submitBtn"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 shadow-lg transform hover:scale-105">
                            <i class="fas fa-paper-plane mr-2"></i>Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Info and Map -->
                <div class="space-y-8 animate-slide-in-right" data-aos="fade-left">
                    <!-- Contact Information -->
                    <div id="contact-info" class="bg-white p-8 rounded-xl shadow-lg">
                        <h2 class="text-3xl font-bold mb-8 text-gray-800 flex items-center">
                            <i class="fas fa-address-book mr-3 text-blue-600"></i>Contact Information
                        </h2>
                        <div class="space-y-6">
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div
                                    class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-map-marker-alt text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Visit Our Office</h3>
                                    <p class="text-gray-600 mt-1"> Musanze - Rwanda</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div
                                    class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-phone text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Call Us</h3>
                                    <p class="text-gray-600 mt-1">+250 781 257 942<br>+250 723 187 033</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div
                                    class="flex-shrink-0 w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-envelope text-purple-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Email Us</h3>
                                    <p class="text-gray-600 mt-1">ndikubwimanaeric2019@gmail.com
                                </div>
                            </div>
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div
                                    class="flex-shrink-0 w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Business Hours</h3>
                                    <p class="text-gray-600 mt-1">Monday - Friday: 8:00 AM - 6:00 PM<br>Saturday: 10:00
                                        AM - 4:00 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Contact Options -->
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-8 rounded-xl">
                        <h3 class="text-2xl font-bold mb-6">Quick Contact</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="tel:+250781257942"
                                class="bg-white bg-opacity-20 p-4 rounded-lg hover:bg-opacity-30 transition duration-300 text-center">
                                <i class="fas fa-phone text-2xl mb-2"></i>
                                <div class="font-semibold">Call Now</div>
                            </a>
                            <a href="mailto:ndikubwimanaeric2019@gmail.com"
                                class="bg-white bg-opacity-20 p-4 rounded-lg hover:bg-opacity-30 transition duration-300 text-center">
                                <i class="fas fa-envelope text-2xl mb-2"></i>
                                <div class="font-semibold">Email Us</div>
                            </a>
                            <a href="https://wa.me/250781257942"
                                class="bg-white bg-opacity-20 p-4 rounded-lg hover:bg-opacity-30 transition duration-300 text-center">
                                <i class="fab fa-whatsapp text-2xl mb-2"></i>
                                <div class="font-semibold">WhatsApp</div>
                            </a>
                            <a href="https://linkedin.com/company/coderwanda"
                                class="bg-white bg-opacity-20 p-4 rounded-lg hover:bg-opacity-30 transition duration-300 text-center">
                                <i class="fab fa-linkedin text-2xl mb-2"></i>
                                <div class="font-semibold">LinkedIn</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map Section -->
            <div class="mt-12 bg-white p-8 rounded-xl shadow-lg" data-aos="fade-up">
                <h2 class="text-3xl font-bold mb-8 text-gray-800 text-center flex items-center justify-center">
                    <i class="fas fa-map-marked-alt mr-3 text-blue-600"></i>Find Us on the Map
                </h2>
                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.4953333333335!2d30.1127!3d-1.9441!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dca4b6b6b6b6b7%3A0x6b6b6b6b6b6b6b6b!2sKigali%2C%20Rwanda!5e0!3m2!1sen!2sus!4v1634567890123!5m2!1sen!2sus"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-gray-50" data-aos="fade-up">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-16 text-gray-800">Frequently Asked Questions</h2>
            <div class="max-w-4xl mx-auto space-y-6">
                <div class="bg-white p-6 rounded-lg shadow-md" data-aos="fade-up">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-question-circle mr-3 text-blue-600"></i>
                        How quickly can you start a project?
                    </h3>
                    <p class="text-gray-600">We typically start new projects within 1-2 weeks of contract signing,
                        depending on project complexity and current workload.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-question-circle mr-3 text-blue-600"></i>
                        Do you provide ongoing support after project completion?
                    </h3>
                    <p class="text-gray-600">Yes, we offer comprehensive maintenance and support packages to ensure your
                        solution continues to perform optimally.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-question-circle mr-3 text-blue-600"></i>
                        What technologies do you specialize in?
                    </h3>
                    <p class="text-gray-600">We specialize in modern web technologies, mobile app development, cloud
                        solutions, AI/ML, and cybersecurity across various platforms.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-question-circle mr-3 text-blue-600"></i>
                        Do you work with international clients?
                    </h3>
                    <p class="text-gray-600">Absolutely! We have successfully delivered projects for clients across
                        Africa, Europe, and North America.</p>
                </div>
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

        // Form validation and enhancement
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;

            if (name.length < 2) {
                alert('Please enter a valid name.');
                e.preventDefault();
                return;
            }

            if (!email.includes('@')) {
                alert('Please enter a valid email.');
                e.preventDefault();
                return;
            }

            if (subject.length < 5) {
                alert('Please enter a subject with at least 5 characters.');
                e.preventDefault();
                return;
            }

            if (message.length < 10) {
                alert('Please enter a message with at least 10 characters.');
                e.preventDefault();
                return;
            }

            // Show loading state
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';
            submitBtn.disabled = true;
        });
    </script>
</body>

</html>