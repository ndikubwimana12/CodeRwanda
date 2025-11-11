<?php
// Database connection
include 'db.php';

// Create admins table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL
)";

// Execute table creation
if ($conn->query($sql) === TRUE) {
    echo "Admins table created successfully.<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Check if default admin exists
$result = $conn->query("SELECT * FROM admins WHERE username = 'admin'");
if ($result->num_rows == 0) {
    // Create default admin
    $default_username = 'admin';
    $default_password = password_hash('admin123', PASSWORD_DEFAULT);
    $default_email = 'admin@coderwanda.com';

    $stmt = $conn->prepare("INSERT INTO admins (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $default_username, $default_password, $default_email);

    if ($stmt->execute()) {
        echo "Default admin user created successfully!<br>";
        echo "Username: admin<br>";
        echo "Password: admin123<br>";
        echo "<strong class='text-red-600'>Please change the default password after first login!</strong><br>";
    } else {
        echo "Error creating admin user: " . $stmt->error . "<br>";
    }
    $stmt->close();
} else {
    echo "Admin user already exists.<br>";
}

// Also ensure join_requests and contact_messages tables exist
$join_requests_sql = "CREATE TABLE IF NOT EXISTS join_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    service VARCHAR(100) NOT NULL,
    message TEXT,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$contact_messages_sql = "CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Create holiday training applications table
$holiday_training_sql = "CREATE TABLE IF NOT EXISTS holiday_training_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    program_type VARCHAR(100) NOT NULL,
    duration VARCHAR(50),
    start_date DATE,
    message TEXT,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Create service applications table
$service_applications_sql = "CREATE TABLE IF NOT EXISTS service_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    company VARCHAR(100),
    service_type VARCHAR(100) NOT NULL,
    budget VARCHAR(50),
    timeline VARCHAR(50),
    message TEXT,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($join_requests_sql) === TRUE) {
    echo "Join requests table ready.<br>";
}

if ($conn->query($contact_messages_sql) === TRUE) {
    echo "Contact messages table ready.<br>";
}

if ($conn->query($holiday_training_sql) === TRUE) {
    echo "Holiday training applications table ready.<br>";
}

if ($conn->query($service_applications_sql) === TRUE) {
    echo "Service applications table ready.<br>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup - CodeRwanda</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans bg-gray-50 p-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-center mb-6 text-blue-600">Database Setup Complete</h1>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <p><strong>Setup completed successfully!</strong></p>
        </div>
        <div class="space-y-4">
            <p><strong>Admin Login Details:</strong></p>
            <ul class="list-disc list-inside space-y-2">
                <li>Username: <code class="bg-gray-100 px-2 py-1 rounded">admin</code></li>
                <li>Password: <code class="bg-gray-100 px-2 py-1 rounded">admin123</code></li>
                <li>Access URL: <a href="admin_login.php" class="text-blue-600 hover:underline">admin_login.php</a></li>
            </ul>
        </div>
        <div class="mt-6 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded">
            <strong>Security Notice:</strong> Please change the default password after your first login for security purposes.
        </div>
        <div class="mt-6 text-center">
            <a href="admin_login.php" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                Go to Admin Login
            </a>
        </div>
    </div>
</body>

</html>