<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

$host = 'localhost';
$username = 'root';
$password = 'mysql';
$database = 'termProject';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$searchResult = null;

if (isset($_GET["search"])) {
    $searchUser = $_GET["search"];

    $searchQuery = "SELECT * FROM users WHERE username LIKE '%$searchUser%'";
    $searchResult = $conn->query($searchQuery);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["follow"])) {
    $followingUsername = $_POST["username"];

    header("Location: follow.php?username=" . urlencode($followingUsername));
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        .tweet-section {
            display: <?php echo isset($_GET['search']) ? 'none' : 'block'; ?>;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
            <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <input type="text" id="searchUser" name="search" placeholder="Search Users" required />
                    <input type="submit" value="Search" />
                </div>
            </form>
        </div>

        <?php
        if ($searchResult && $searchResult->num_rows > 0) {
            echo "<div class='card'>";
            echo "<h1>Search Results:</h1>";

            while ($row = $searchResult->fetch_assoc()) {
                echo "<p>Username: {$row['username']}</p>";
                echo "<p>Name: {$row['name']}</p>";
                echo "<form method='post' action='homepage.php'>";
                echo "<input type='hidden' name='username' value='{$row['username']}' />";
                echo "<input type='submit' name='follow' value='Follow' />";
                echo "</form>";
            }
            echo "</div>";
        }
        elseif($searchResult && $searchResult->num_rows == 0){
            $_SESSION['follow_process'] = "No matching users found.";
            header("Location: homepage.php");
            exit();
        }

        if (isset($_SESSION['follow_process'])) {
            echo $_SESSION['follow_process'];
            unset($_SESSION['follow_process']);
        }
        ?>

        <div class="card tweet-section">
            <h1>Tweets from the Users You Follow:</h1>
            <?php
            $loggedInUsername = $_SESSION['username'];

            $tweetsQuery = "SELECT u.name, t.content, t.date FROM followers AS f
                            INNER JOIN users AS u ON f.FollowingID = u.UserID
                            INNER JOIN tweets AS t ON u.UserID = t.UserID
                            WHERE f.FollowerID = (SELECT UserID FROM users WHERE username = '$loggedInUsername')
                            ORDER BY t.date DESC";
            $tweetsResult = $conn->query($tweetsQuery);

            if ($tweetsResult && $tweetsResult->num_rows > 0) {
                while ($row = $tweetsResult->fetch_assoc()) {
                    echo "<p>{$row['name']}</p>";
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
        
        <br><br><br>
        <div class="card">
            <div class="form-group">
                <form method="post" action="profile.php" style="display: inline;">
                    <button type="submit">Profile</button>
                </form>
                <form method="post" action="logout.php" style="display: inline;">
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>

    </div>
</body>
</html>