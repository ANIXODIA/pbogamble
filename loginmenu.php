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

        header("Location: main.php?user=" . urlencode($usr));
        exit();
    } else {
        echo "<center><b><font color='red' size='6'>WRONG PASSWORD OR USERNAME!</font></b></center>";
    }
}
?>
<html>
<head>
    <title>777 Mineslots 777 - Login</title>
    <style>
        body {
            /* Blocky Minecraft Dirt Texture */
            background-color: #6A4B3A; 
            background-image: 
                linear-gradient(45deg, #5C4033 25%, transparent 25%, transparent 75%, #5C4033 75%, #5C4033),
                linear-gradient(45deg, #5C4033 25%, transparent 25%, transparent 75%, #5C4033 75%, #5C4033);
            background-size: 64px 64px;
            background-position: 0 0, 32px 32px;
            color: white;
            font-family: "Comic Sans MS", cursive, sans-serif; 
        }
        .stone-box {
            background-color: #808080; 
            border: 12px solid #333333; 
            width: 550px; 
            padding: 40px; 
            box-shadow: 10px 10px 0px black; 
        }
        .grass-btn {
            background-color: #4CBB17; 
            color: white;
            font-size: 28px; 
            border: 6px solid #228B22;
            font-weight: bold;
            cursor: pointer;
            padding: 10px 20px;
        }
        .wood-btn {
            background-color: #8B5A2B; 
            color: white;
            font-size: 24px; 
            border: 6px solid #5C4033;
            font-weight: bold;
            margin-top: 15px;
            cursor: pointer;
            padding: 10px 20px;
        }
     
        input[type="text"], input[type="password"] {
            width: 300px;
            height: 40px;
            font-size: 22px;
            background-color: #cccccc;
            border: 4px solid #333;
            font-family: "Comic Sans MS", cursive, sans-serif; 
            text-align: center;
        }
    </style>
</head>
<body>

<center>
    <br><br><br>
    <h1><font color="#4CBB17" size="7">~~~ Welcome to Mineslots777 Server ~~~</font></h1>
    <h2><font color="cyan"><b>(spend wisely pls)</b></font></h2>
    <br>

    <div class="stone-box">
        <center>
            <form action="" method="POST">
                <u><b><font size="5">Player Name:</font></b></u><br>
                <input type="text" name="username"><br><br>

                <u><b><font size="5">Secret Password:</font></b></u><br>
                <input type="password" name="password"><br><br><br>

                <input type="submit" name="loginBtn" value=" JOIN SERVER " class="grass-btn">
            </form>
            
            <br>
            <button onclick="window.location.href='register.php'" class="wood-btn"> CRAFT NEW ACCOUNT </button>
        </center>
    </div>

    <br><br><br>
    <marquee width="70%" scrollamount="20" bgcolor="black">
        <font color="yellow" size="6">SERVER IS ONLINE (Ver 1.0.0) PLS DONATE FOR DIAMOND! </font>
    </marquee>

</center>

</body>
</html>
