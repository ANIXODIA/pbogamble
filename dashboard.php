<?php
// Dashboard/Header component for all pages
// Include this file at the top of your page after session_start()

// Determine page type for styling
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="dashboard">
    <div class="dashboard-title">
        🎰 Educational Slot Simulator
    </div>
    
    <div class="dashboard-nav">
        <?php
        // Show different navigation based on login state
        if (isset($_SESSION["user"])):
        ?>
            <span class="dashboard-user">
                👤 <?php echo htmlspecialchars($_SESSION["user"]); ?>
            </span>
            <a href="main.php">Play</a>
            <a href="logout.php" class="logout">Logout</a>
        <?php
        else:
        ?>
            <a href="loginmenu.php">Login</a>
            <a href="register.php">Register</a>
        <?php
        endif;
        ?>
    </div>
</div>
