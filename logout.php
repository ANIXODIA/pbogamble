<?php
session_start();
session_destroy();
header("Location: loginmenu.php");
exit();
?>
