<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
            <?php
            $host = 'localhost';
            $username = 'root';
            $password = 'mysql';
            $database = 'termProject';

            $conn = new mysqli($host, $username, $password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $userID = $_SESSION['userID'];

            $userInfoQuery = "SELECT * FROM users WHERE UserID = '$userID'";
            $userInfoResult = $conn->query($userInfoQuery);

            if ($userInfoResult && $userInfoResult->num_rows > 0) {
                // User information
                $row = $userInfoResult->fetch_assoc();
                echo "<p><strong>Username:</strong> {$_SESSION['username']}</p>";

                // Number of tweets
                $tweetsQuery = "SELECT COUNT(*) AS numTweets FROM tweets WHERE UserID = '$userID'";
                $tweetsResult = $conn->query($tweetsQuery);
                $tweetsRow = $tweetsResult->fetch_assoc();
                $numTweets = $tweetsRow['numTweets'];
                echo "<p><strong>Tweets:</strong> {$numTweets}</p>";

                // Number of followers
                $followersQuery = "SELECT COUNT(*) AS numFollowers FROM followers WHERE FollowingID = '$userID'";
                $followersResult = $conn->query($followersQuery);
                $followersRow = $followersResult->fetch_assoc();
                $numFollowers = $followersRow['numFollowers'];
                echo "<p><strong>Followers:</strong> {$numFollowers}</p>";

                // Number of following
                $followingQuery = "SELECT COUNT(*) AS numFollowing FROM followers WHERE FollowerID = '$userID'";
                $followingResult = $conn->query($followingQuery);
                $followingRow = $followingResult->fetch_assoc();
                $numFollowing = $followingRow['numFollowing'];
                echo "<p><strong>Following:</strong> {$numFollowing}</p>";

                echo "<p><strong>Creation Date:</strong> {$row['creation_date']}</p>";
            } else {
                echo "User not found.";
            }

            $userInfoResult->close();
            $tweetsResult->close();
            $followersResult->close();
            $followingResult->close();
            ?>

            <form method="post" action="tweet.php">
                <div class="form-group">
                    <textarea id="tweet" name="tweet" placeholder="Write a Tweet" required></textarea>
                    <input type="submit" value="Tweet" />
                </div>
            </form>

        </div>
        
        <div class="card">
            <h1>Your Tweets:</h1>
            <?php
            $tweetsQuery = "SELECT * FROM tweets WHERE UserID = '$userID' ORDER BY date DESC";
            $tweetsResult = $conn->query($tweetsQuery);

            if ($tweetsResult && $tweetsResult->num_rows > 0) {
                while ($row = $tweetsResult->fetch_assoc()) {
                    echo "<p><strong>Content:</strong> {$row['content']}</p>";
                    echo "<p><strong>Created At:</strong> {$row['date']}</p>";
                    echo "<hr>";
                }
            } else {
                echo "No tweets found.";
            }

            $tweetsResult->close();
            ?>
        </div>

        
        <div class="card">
            <div class="form-group">
                <form method="post" action="homepage.php" style="display: inline;">
                    <button type="submit">Homepage</button>
                </form>
                <form method="post" action="logout.php" style="display: inline;">
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>

    </div>
</body>
</html>
