<?php
include 'db.php';

// ⚠️ choose your new credentials
$new_username = 'admin';
$new_password = '123';

// remove all old admins
$conn->query("DELETE FROM admins");

// insert the new one
$hash = password_hash($new_password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $new_username, $hash);

if ($stmt->execute()) {
    echo "New admin account created!<br>";
    echo "Username: $new_username<br>";
    echo "Password: $new_password<br>";
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
$conn->close();
