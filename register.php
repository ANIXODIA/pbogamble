<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'database.php';

$successMessage = "";
$errorMessage = "";

if(isset($_POST["registerBtn"])){ 
    $usr = $_POST["username"];
    $pw = $_POST["password"];
    
    // Hash the password before storing
    $hashedPw = password_hash($pw, PASSWORD_DEFAULT);

    // Use prepared statement to prevent SQL injection
    $sql = "INSERT INTO user (username, password, money) VALUES (?, ?, 1000)";
    $stmt = $connection->prepare($sql); // Prepare the statement
    
    if (!$stmt) {
        $errorMessage = "Database error: " . $connection->error;
    } else {
        $stmt->bind_param("ss", $usr, $hashedPw); // Bind parameters
        
        if($stmt->execute()){
            $successMessage = "Profile created! You can now log in.";
        } else {
            $errorMessage = "Could not create profile: " . $stmt->error;
        }
    }
} 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Educational Slot Simulator</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="auth-page">
    <?php include 'dashboard.php'; ?>

    <center>
        <br><br>
        <h1 style="color: #ffff99;">Create Your Player Profile</h1>
        <h2 style="color: cyan;">(New players start with 1000 practice emeralds)</h2>
        <br>

        <?php
        if(!empty($successMessage)) {
            echo "<div class='success-message'>✓ $successMessage</div>";
        }
        if(!empty($errorMessage)) {
            echo "<div class='error-message'>✗ $errorMessage</div>";
        }
        ?>

        <div class="stone-box">
            <center>
                <form action="" method="POST">
                    <u><b style="font-size: 22px;">Choose a Username:</b></u>
                    <br><br>
                    <input type="text" name="username" required>
                    <br><br>

                    <u><b style="font-size: 22px;">Create a Password:</b></u>
                    <br><br>
                    <input type="password" name="password" required>
                    <br><br><br>

                    <input type="submit" name="registerBtn" value=" CREATE PROFILE " class="wood-btn">
                </form>
                
                <button onclick="window.location.href='loginmenu.php'" class="wood-btn">BACK TO LOGIN</button>
            </center>
        </div>

        <br><br>
        <marquee width="70%" scrollamount="20" bgcolor="black">
            <font color="yellow" size="5">
                🎰 EDUCATIONAL SIMULATOR • PLAY MONEY ONLY • LEARN ABOUT PROBABILITY 🎰
            </font>
        </marquee>
    </center>
</body>
</html>
