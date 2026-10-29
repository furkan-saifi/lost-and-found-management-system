<?php
// Local XAMPP defaults. Set environment variables if your setup differs.
$host = getenv('DB_HOST') ?: 'localhost';
$db   = getenv('DB_NAME') ?: 'lost_and_found';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    error_log('Database connection failed: ' . $conn->connect_error);
    http_response_code(500);
    exit('Database connection failed. Check your local database configuration.');
}
$conn->set_charset('utf8mb4');
?>
