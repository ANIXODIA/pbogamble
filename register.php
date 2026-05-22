<?php
$conn = mysqli_connect("localhost", "root", "", "my_game_db"); 

if(isset($_POST["registerBtn"])){ 
    $usr = $_POST["username"];
    $pw = $_POST["password"];
    
    
    $sql2 = "INSERT INTO players (username, password, money) VALUES ('$usr', '$pw', 1000)";
    
    if(mysqli_query($conn, $sql2)){
        echo "<center><b><font color='lime' size='6'>ACCOUNT CRAFTED! You can join the server now!</font></b></center>";
    } else {
        echo "<center><b><font color='red' size='6'>SERVER LAG! Could not craft account! (Maybe name is taken?)</font></b></center>";
    }
} 
?>
<html>
<head>
    <title>Craft Account - Mineslots</title>
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
        .wood-btn {
            background-color: #8B5A2B; 
            color: white;
            font-size: 20px;
            border: 4px solid #5C4033;
            font-weight: bold;
            margin-top: 10px;
            cursor: pointer;
        }
        .back-btn {
            background-color: gray;
            color: white;
            font-size: 16px;
            border: 2px solid black;
            cursor: pointer;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<center>
    <br><br><br>
    <h1><font color="yellow">~~~ Craft Your Player Profile ~~~</font></h1>
    <h3><font color="cyan">(New players get 1000 FREE EMERALDS!)</font></h3>
    <br>

    <div class="stone-box">
        <center>
            <form action="" method="POST">
                <u><b>Choose a Name:</b></u><br>
                <input type="text" name="username" style="width: 200px; background-color: #cccccc;"><br><br>

                <u><b>Create a Password:</b></u><br>
                <input type="password" name="password" style="width: 200px; background-color: #cccccc;"><br><br>

                <input type="submit" name="registerBtn" value=" CRAFT ACCOUNT " class="wood-btn">
            </form>
            
            <button onclick="window.location.href='loginmenu.php'" class="back-btn"> <-- Go Back to Login</button>
        </center>
    </div>

</center>

</body>
</html>
