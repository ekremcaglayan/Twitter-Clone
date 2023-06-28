<?php
session_start();

$host = 'localhost';
$username = 'root';
$password = 'mysql';
$database = 'termProject';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ss", $username, $password);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $userID = $row['UserID'];

    $_SESSION['username'] = $username;
    $_SESSION['userID'] = $userID;

    header("Location: homepage.php");
    exit();
} else {
    echo "Authentication failed. Please check your username and password.";
    echo "<br>";
    echo '<a href="index.html">Go back</a>';
}

$stmt->close();
$conn->close();
?>