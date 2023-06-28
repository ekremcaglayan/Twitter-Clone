<?php
session_start();

if (!isset($_SESSION['username'])) { 
    header("Location: index.html");
    exit();
}

if (isset($_GET['username'])) {
    $searchedUsername = $_GET['username'];
    $followerUsername = $_SESSION['username'];

    $host = 'localhost';   
    $username = 'root';
    $password = 'mysql';
    $database = 'termProject';

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the user is already followed
    $checkQuery = "SELECT * FROM followers AS f
                   INNER JOIN users AS u1 ON f.FollowerID = u1.UserID
                   INNER JOIN users AS u2 ON f.FollowingID = u2.UserID
                   WHERE u1.username = '$followerUsername' AND u2.username = '$searchedUsername'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult && $checkResult->num_rows > 0) {
        // User is already followed
        $_SESSION['follow_process'] = "You are already following $searchedUsername.";
        header("Location: homepage.php");
    } 
    else {
        // User is not followed, follow the user
        $followerID = "SELECT UserID FROM users WHERE username = '$followerUsername'";
        $followingID = "SELECT UserID FROM users WHERE username = '$searchedUsername'";

        $followQuery = "INSERT INTO followers (FollowerID, FollowingID) 
                        SELECT ($followerID), ($followingID)";

        if ($conn->query($followQuery) === true) {
            // Update the follower count in the user table
            $updateFollowerCountQuery = "UPDATE users SET followers = followers + 1 WHERE username = '$searchedUsername'";
            $conn->query($updateFollowerCountQuery);

            $_SESSION['follow_process'] = "You started following $searchedUsername.";
            header("Location: homepage.php");
        } else {
            echo "Error following $searchedUsername: " . $conn->error;
        }
    }
    $conn->close();

} else {
    echo "Searched username not provided.";
    header("Location: homepage.php");
    exit();
}
?>