<?php
// Get database credentials from environment variables if available, otherwise use local defaults
$servername = getenv('DB_HOST') ?: "localhost";
$username   = getenv('DB_USERNAME') ?: "root";
$password   = getenv('DB_PASSWORD') ?: "";
$dbname     = getenv('DB_NAME') ?: "coderwanda_db";
$port       = getenv('DB_PORT') ?: 3306; // optional, default MySQL port

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: confirm connection
// echo "Connected successfully!";