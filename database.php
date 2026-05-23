<?php
$connection = new mysqli(
    'localhost:3306',
    'root',
    '',
    'my_game_db'
);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

?>