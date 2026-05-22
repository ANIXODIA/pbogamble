<?php 
session_start();
$conn = mysqli_connect("localhost", "root", "", "my_game_db");

$playerName = "Guest";
$startingMoney = 100;

if(isset($_GET['user'])) {
    $username = strtolower($_GET['user']);
    
    $result = mysqli_query($conn, "SELECT * FROM players WHERE username = '$username'");
    
    if($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $playerName = $row['username'];
        if(isset($row['money'])) {
            $startingMoney = $row['money'];
        } else {
            $startingMoney = 1000;
        }
    } else {
        $playerName = "Unknown Player";
        $startingMoney = 0;
    }
}
?>
<html>
<head>
    <title>My Slot Machine</title>
    <style>
        body {
            background-color: #8B5A2B; 
            font-family: "Comic Sans MS", Arial, sans-serif;
        }
        #gamebox {
            background-color: gray;
            width: 500px;
            height: 400px;
            border: 5px solid black;
            margin: 0 auto;
            text-align: center;
            padding-top: 20px;
        }
        .slot-window {
            background-color: black;
            color: white;
            font-size: 60px;
            padding: 20px;
            border: 3px solid silver;
            display: inline-block; /* Needed for the animation to work right */
        }
        table {
            background-color: white;
            margin: 0 auto;
        }
        
        /* --- NEW ANIMATION STYLES --- */
        .spinning-anim {
            animation: shake 0.1s infinite;
            color: yellow; /* turns yellow while spinning */
        }
        
        @keyframes shake {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(15px); }
        }
        
        .winner-anim {
            animation: flash 0.3s infinite;
        }
        
        @keyframes flash {
            0% { background-color: black; }
            50% { background-color: lime; color: black; }
            100% { background-color: black; }
        }
    </style>
</head>
<body>

    <center>
        <h1 style="color: white;">Diamond Slots</h1>
        
        <h3 style="color: yellow;">
            Player: <?php echo $playerName; ?> | Emeralds: <span id="emeralds"><?php echo $startingMoney; ?></span>
        </h3>
        
        <table border="1">
            <tr>
                <td><b>Paytable:</b></td>
                <td>💎💎💎 = 50x</td>
                <td>Any other 3 match = 10x</td>
                <td>Any 2 match = 2x</td>
            </tr>
        </table>
        
        <br>

        <div id="gamebox">
            <span class="slot-window" id="slot1">?</span>
            <span class="slot-window" id="slot2">?</span>
            <span class="slot-window" id="slot3">?</span>
            
            <br><br><br>
            
            <b>Bet Amount:</b> 
            <input type="number" id="betInput" value="50" style="width: 50px;">
            <br><br>
            
            <button onclick="spinSlots()" id="spinBtn" style="font-size: 25px; background-color: red; color: white; cursor: pointer;">SPIN!</button>
            
            <h2 id="message" style="color: lightgreen;">Ready to play!</h2>
            
            <button onclick="saveGame()">Save Score</button>
        </div>
    </center>

    <script>
        var myMoney = <?php echo $startingMoney; ?>;
        var symbols = ['💎', '⭐', '🗡️', '🪓', '🧱', '🪨'];
        var isSpinning = false; // stop people from clicking spin twice

        function spinSlots() {
            if (isSpinning == true) {
                return; // don't do anything if already spinning
            }
            
            var bet = document.getElementById("betInput").value;
            
            if (myMoney < bet) {
                alert("You don't have enough emeralds!");
                return;
            }

            isSpinning = true;
            myMoney = myMoney - bet;
            document.getElementById("emeralds").innerHTML = myMoney;
            document.getElementById("message").innerHTML = "Spinning...";
            document.getElementById("message").style.color = "yellow";
            
            // clear old win animations
            document.getElementById("slot1").className = "slot-window spinning-anim";
            document.getElementById("slot2").className = "slot-window spinning-anim";
            document.getElementById("slot3").className = "slot-window spinning-anim";

            // Make the symbols change super fast while spinning
            var rapidSpin = setInterval(function() {
                document.getElementById("slot1").innerHTML = symbols[Math.floor(Math.random() * 6)];
                document.getElementById("slot2").innerHTML = symbols[Math.floor(Math.random() * 6)];
                document.getElementById("slot3").innerHTML = symbols[Math.floor(Math.random() * 6)];
            }, 100);

            // Stop the spinning after 2 seconds
            setTimeout(function() {
                clearInterval(rapidSpin); // stop the fast switching
                
                // remove the spinning animation class
                document.getElementById("slot1").className = "slot-window";
                document.getElementById("slot2").className = "slot-window";
                document.getElementById("slot3").className = "slot-window";

                var num1 = Math.floor(Math.random() * 6);
                var num2 = Math.floor(Math.random() * 6);
                var num3 = Math.floor(Math.random() * 6);

                var res1 = symbols[num1];
                var res2 = symbols[num2];
                var res3 = symbols[num3];

                // set the final symbols
                document.getElementById("slot1").innerHTML = res1;
                document.getElementById("slot2").innerHTML = res2;
                document.getElementById("slot3").innerHTML = res3;

                // check if won
                if (res1 == res2 && res2 == res3) {
                    // Trigger flashing win animation!
                    document.getElementById("slot1").className = "slot-window winner-anim";
                    document.getElementById("slot2").className = "slot-window winner-anim";
                    document.getElementById("slot3").className = "slot-window winner-anim";
                    
                    if (res1 == '💎') {
                        var win = bet * 50;
                        myMoney = myMoney + win;
                        document.getElementById("message").innerHTML = "JACKPOT!!! You won " + win;
                        document.getElementById("message").style.color = "lime";
                    } else {
                        var win = bet * 10;
                        myMoney = myMoney + win;
                        document.getElementById("message").innerHTML = "You got 3! You won " + win;
                        document.getElementById("message").style.color = "lime";
                    }
                } 
                else if (res1 == res2 || res2 == res3 || res1 == res3) {
                    var win = bet * 2;
                    myMoney = myMoney + win;
                    document.getElementById("message").innerHTML = "You got 2. You won " + win;
                    document.getElementById("message").style.color = "lime";
                } 
                else {
                    document.getElementById("message").innerHTML = "You lost. Try again!";
                    document.getElementById("message").style.color = "red";
                }

                document.getElementById("emeralds").innerHTML = myMoney;
                isSpinning = false; // let them spin again

            }, 2000); // 2 seconds of spinning
        }

        function saveGame() {
            alert("Score saved to database! (You'll need a bit more PHP to actually update the DB here)");
        }
    </script>

</body>
</html>
