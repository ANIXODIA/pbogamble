<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "my_game_db");

if(isset($_POST["loginBtn"])){
    $usr = $_POST["username"];
    $pw = $_POST["password"];
    $sql = "SELECT * FROM players WHERE username = '$usr' AND password = '$pw'";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0){
        $_SESSION["user"] = $usr;
        header("Location: loai.php?user=" . urlencode($usr));
        exit();
    } else {
        echo "<center><b><font color='red' size='6'>WRONG PASSWORD!</font></b></center>";
    }
}

if(isset($_POST["registerBtn"])){ 
    $usr = $_POST["username"];
    $pw = $_POST["password"];
    // Assuming you have a 'money' column in the players table, we start them with 1000
    $sql2 = "INSERT INTO players (username, password, money) VALUES ('$usr', '$pw', 1000)";
    
    if(mysqli_query($conn, $sql2)){
        echo "<center><b><font color='lime' size='6'>ACCOUNT CRAFTED! You can join the server now!</font></b></center>";
    } else {
        echo "<center><b><font color='red' size='6'>SERVER LAG! Could not craft account! (Maybe name is taken?)</font></b></center>";
    }
} // Fixed the missing closing bracket here!
?>
<html>
<head>
    <title>777 Mineslots 777</title>
    <style>
        body {
            background-color: #5C4033; 
            color: white;
            font-family: "Comic Sans MS", cursive, sans-serif; 
        }
        .stone-box {
            background-color: #808080; 
            border: 8px solid #333333;
            width: 380px;
            padding: 20px;
        }
        .grass-btn {
            background-color: #4CBB17; 
            color: white;
            font-size: 22px;
            border: 4px solid #228B22;
            font-weight: bold;
            cursor: pointer;
        }
        .wood-btn {
            background-color: #8B5A2B; 
            color: white;
            font-size: 20px;
            border: 4px solid #5C4033;
            font-weight: bold;
            margin-top: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<center>
    <br><br><br>
    <h1><font color="#4CBB17">~~~ Welcome to Mineslots777 Server ~~~</font></h1>
    <h3><font color="cyan">(spend wisely pls)</font></h3>
    <br>

    <div class="stone-box">
        <center>
            <form action="" method="POST">
                <u><b>Player Name:</b></u><br>
        
                <input type="text" name="username" style="width: 200px; background-color: #cccccc;"><br><br>

                <u><b>Secret Password:</b></u><br>
                <input type="password" name="password" style="width: 200px; background-color: #cccccc;"><br><br>

                <input type="submit" name="loginBtn" value=" JOIN SERVER " class="grass-btn">
                <br>
              
                <input type="submit" name="registerBtn" value=" CRAFT NEW ACCOUNT " class="wood-btn">
            </form>
        </center>
    </div>

    <br><br>
    <marquee width="60%" scrollamount="20" bgcolor="black">
        <font color="yellow" size="5">SERVER IS ONLINE (Ver 1.0.0) PLS DONATE FOR DIAMOND! </font>
    </marquee>

</center>

</body>
</html>
