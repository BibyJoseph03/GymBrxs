<?php
$servername = "localhost";
$username = "root";
$password = ""; // or "your_password" if set
$database = "gymbrxs_db"; // Make sure this matches your DB

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
