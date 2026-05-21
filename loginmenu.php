<?php
session start():
require ONCE ('database.php')
if(isset($_POST["loginBtn"])){
    $usr = $_POST["username"];
    $pw = $_POST["password"];
$sql = "SELECT * FROM players WHERE username = '$usr' AND password = '$pw'";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0){
        $_SESSION["user"] = $usr;
        echo "<script>alert('Login Epic Win! Welcome to the server!');</script>";
    } else {
        // creeper explosion error message
        echo "<center><b><font color='red' size='6'>WRONG PASSWORD! YOU DIED!</font></b></center>";
        }
}
?>
<html>












</html>
