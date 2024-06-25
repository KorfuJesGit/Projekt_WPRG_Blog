<?php
$servername = "localhost";

$username = "root";

$password = "";

$dbname = "blogfinal";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {

    die("blad poalczenia z baza danych " . $conn->connect_error);
    
}
?>
