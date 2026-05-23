<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'database.php';

if(isset($_POST["loginBtn"])){
    $usr = $_POST["username"];
    $pw = $_POST["password"];

    // Prepared statement: fetch the stored hashed password for the username
    $sql = "SELECT password FROM user WHERE username = ?";
    $stmt = $connection->prepare($sql);

    if (!$stmt) {
        $errorMessage = "Database error: " . $connection->error;
    } else {
        $stmt->bind_param("s", $usr);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result && $result->num_rows > 0){
            $row = $result->fetch_assoc();
            $hashed = $row['password'];

            if (password_verify($pw, $hashed)) {
                $_SESSION["user"] = $usr;
                header("Location: main.php?user=" . urlencode($usr));
                exit();
            } else {
                $errorMessage = "WRONG PASSWORD OR USERNAME!";
            }
        } else {
            $errorMessage = "WRONG PASSWORD OR USERNAME!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Educational Slot Simulator - Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="auth-page">
    <?php include 'dashboard.php'; ?>

    <center>
        <br><br>
        <h1 style="color: #ffff99;">Educational Slot Simulator</h1>
        <h2 style="color: cyan;">(practice odds and risk management with play currency)</h2>
        <br>

        <?php
        if(isset($errorMessage)) {
            echo "<div class='error-message'>$errorMessage</div>";
        }
        ?>

        <div class="stone-box">
            <center>
                <form action="" method="POST">
                    <u><b style="font-size: 22px;">Username:</b></u>
                    <br><br>
                    <input type="text" name="username" required>
                    <br><br>

                    <u><b style="font-size: 22px;">Password:</b></u>
                    <br><br>
                    <input type="password" name="password" required>
                    <br><br><br>

                    <input type="submit" name="loginBtn" value=" LOG IN " class="grass-btn">
                </form>

                <br>
                <button onclick="window.location.href='register.php'" class="wood-btn">CREATE NEW PROFILE</button>
            </center>
        </div>

        <br><br>
        <marquee width="70%" scrollamount="20" bgcolor="black">
            <font color="yellow" size="5">
                FOR EDUCATIONAL PURPOSES • PLAY MONEY ONLY • LEARN ABOUT PROBABILITY 🎰
            </font>
        </marquee>
    </center>

</body>
</html>
