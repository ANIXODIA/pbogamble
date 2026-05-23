<?php




$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="dashboard">
    <div class="dashboard-title">
        🎰 Educational Slot Simulator
    </div>
    
    <div class="dashboard-nav">
        <?php
        
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
