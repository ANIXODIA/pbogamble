<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'database.php';

$playerName = "Guest";
$startingMoney = 100;
$userExists = false;

if (isset($_SESSION['user']) || isset($_GET['user'])) {
    $username = isset($_SESSION['user']) ? $_SESSION['user'] : strtolower($_GET['user']);
    $username = strtolower($username);

    if ($stmt = $connection->prepare("SELECT username, money FROM user WHERE username = ?")) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $playerName = $row['username'];
            $startingMoney = isset($row['money']) ? (int)$row['money'] : 1000;
            $userExists = true;
        } else {
            $playerName = "Unknown Player";
            $startingMoney = 0;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['saveMoney'])) {
    header('Content-Type: application/json');

    if (!$userExists) {
        echo json_encode(['success' => false, 'message' => 'No logged in user found.']);
        exit;
    }

    $money = filter_var($_POST['saveMoney'], FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 0]
    ]);

    if ($money === false) {
        echo json_encode(['success' => false, 'message' => 'Invalid emerald amount.']);
        exit;
    }

    if ($updateStmt = $connection->prepare("UPDATE user SET money = ? WHERE username = ?")) {
        $updateStmt->bind_param("is", $money, $username);

        if ($updateStmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Balance saved.', 'money' => $money]);
            exit;
        }
    }

    echo json_encode(['success' => false, 'message' => 'Failed to save balance.']);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Educational Slot Simulator - Play</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="game-page">
    <?php include 'dashboard.php'; ?>

    <center>
        <h1>🎰 Slot Machine Game 🎰</h1>
        <div class="disclaimer">
            This is an educational simulator for learning about probability and odds. All currency is virtual and for practice only.
        </div>
        <br>
        <h3 style="color: #ffff99;">
            Player: <strong><?php echo htmlspecialchars($playerName); ?></strong> | Practice Emeralds: <span id="emeralds"><?php echo $startingMoney; ?></span>
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
            
            <button onclick="spinSlots()" style="font-size: 25px; background-color: red; color: white;">SPIN!</button>
            
            <h2 id="message" style="color: lightgreen;">Ready to play!</h2>
            
            <button onclick="saveGame()">Save Practice Balance</button>
        </div>
    </center>
	<script>
	    var myMoney = <?php echo $startingMoney; ?>;
	    var symbols = ['💎', '⭐', '🗡️', '🪓', '🧱', '🪨'];
	    var isSpinning = false;
	
	    function spinSlots() {
	
	        if (isSpinning == true) {
	            return;
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
	
	        // start spinning animation
	        document.getElementById("slot1").className = "slot-window spinning-anim";
	        document.getElementById("slot2").className = "slot-window spinning-anim";
	        document.getElementById("slot3").className = "slot-window spinning-anim";
	
	        // rapidly change symbols
	        var rapidSpin = setInterval(function() {
	
	            document.getElementById("slot1").innerHTML =
	                symbols[Math.floor(Math.random() * 6)];
	
	            document.getElementById("slot2").innerHTML =
	                symbols[Math.floor(Math.random() * 6)];
	
	            document.getElementById("slot3").innerHTML =
	                symbols[Math.floor(Math.random() * 6)];
	
	        }, 100);
	
	        // stop spinning after 2 seconds
	        setTimeout(function() {
	
	            clearInterval(rapidSpin);
	
	            document.getElementById("slot1").className = "slot-window";
	            document.getElementById("slot2").className = "slot-window";
	            document.getElementById("slot3").className = "slot-window";
	
	            var num1 = Math.floor(Math.random() * 6);
	            var num2 = Math.floor(Math.random() * 6);
	            var num3 = Math.floor(Math.random() * 6);
	
	            var res1 = symbols[num1];
	            var res2 = symbols[num2];
	            var res3 = symbols[num3];
	
	            document.getElementById("slot1").innerHTML = res1;
	            document.getElementById("slot2").innerHTML = res2;
	            document.getElementById("slot3").innerHTML = res3;
	
	            // win conditions
	            if (res1 == res2 && res2 == res3) {
	
	                document.getElementById("slot1").className = "slot-window winner-anim";
	                document.getElementById("slot2").className = "slot-window winner-anim";
	                document.getElementById("slot3").className = "slot-window winner-anim";
	
	                if (res1 == '💎') {
	
	                    var win = bet * 50;
	                    myMoney = myMoney + win;
	
	                    document.getElementById("message").innerHTML =
	                        "JACKPOT!!! You won " + win;
	
	                    document.getElementById("message").style.color = "lime";
	
	                } else {
	
	                    var win = bet * 10;
	                    myMoney = myMoney + win;
	
	                    document.getElementById("message").innerHTML =
	                        "You got 3! You won " + win;
	
	                    document.getElementById("message").style.color = "lime";
	                }
	
	            }
	            else if (res1 == res2 || res2 == res3 || res1 == res3) {
	
	                var win = bet * 2;
	                myMoney = myMoney + win;
	
	                document.getElementById("message").innerHTML =
	                    "You got 2. You won " + win;
	
	                document.getElementById("message").style.color = "lime";
	
	            }
	            else {
	
	                document.getElementById("message").innerHTML =
	                    "You lost. Try again!";
	
	                document.getElementById("message").style.color = "red";
	            }
	
	            document.getElementById("emeralds").innerHTML = myMoney;
	
	            isSpinning = false;
	
	        }, 2000);
	    }
	
	    function saveGame() {
	        fetch('main.php', {
	            method: 'POST',
	            headers: {
	                'Content-Type': 'application/x-www-form-urlencoded'
	            },
	            body: 'saveMoney=' + encodeURIComponent(myMoney)
	        })
	        .then(function(response) {
	            return response.json();
	        })
	        .then(function(data) {
	            if (data.success) {
	                document.getElementById("message").innerHTML = "Balance saved: " + data.money + " emeralds.";
	                document.getElementById("message").style.color = "lightgreen";
	            } else {
	                document.getElementById("message").innerHTML = data.message;
	                document.getElementById("message").style.color = "red";
	            }
	        })
	        .catch(function() {
	            document.getElementById("message").innerHTML = "Unable to save balance right now.";
	            document.getElementById("message").style.color = "red";
	        });
	    }
	</script>

</body>
</html>
