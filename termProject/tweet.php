<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

if (isset($_POST['tweet'])) {
    $tweetContent = $_POST['tweet'];
    $userID = $_SESSION['userID'];

    $host = 'localhost';
    $username = 'root';
    $password = 'mysql';
    $database = 'termProject';

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO tweets (UserID, content) VALUES (?, ?)");

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("is", $userID, $tweetContent);

    if ($stmt->execute()) {
        header("Location: profile.php");
        exit();
    } else {
        echo "Error posting tweet: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Tweet content not provided.";
}
?>
