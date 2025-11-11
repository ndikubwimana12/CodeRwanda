<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Default XAMPP MySQL user
$password = ""; // Default password is empty
$dbname = "coderwanda_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
