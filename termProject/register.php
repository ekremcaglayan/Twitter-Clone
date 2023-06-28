<?php
$host = 'localhost';
$username = 'root';
$password = 'mysql';
$database = 'termProject';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("INSERT INTO users (name, username, password) VALUES (?, ?, ?)");

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sss", $name, $username, $password);

if ($stmt->execute()) {
    header("Location: index.html");
    exit();
} else {
    echo "Registration failed: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>