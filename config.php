<?php
$servername = "localhost";
$username = "root";
$password = "password";

$link = new mysqli($servername, $username, $password, 'mydb1');

if ($link -> error) {
    echo 'There is some error while connecting to database: ' . $conn->error;
}
?>
