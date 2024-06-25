<?php
include 'dbconnect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nazwa = $_POST['nazwa'];

    $haslo = $_POST['haslo'];

    $check_komenda = "SELECT * FROM users WHERE nazwa='$nazwa'";
    
    $check_wynik = $conn->query($check_komenda);


    if ($check_wynik->num_rows > 0) {
        echo "nazwa already taken";
    } else {
      
        $insert_query = "INSERT INTO users (nazwa, haslo) VALUES ('$nazwa', '$haslo')";

        if ($conn->query($insert_query) === TRUE) {
            $_SESSION['nazwa'] = $nazwa; 
            header('Location: index.php');
        } else {
            echo "Error: " . $insert_query . "<br>" . $conn->error;
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Register</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
        </nav>
    </header>
    <main>
        <form action="rejestracja.php" method="post">
            <input type="text" name="nazwa" placeholder="nazwa" required>
            <input type="haslo" name="haslo" placeholder="haslo" required>
            <button type="submit">Register</button>
        </form>
    </main>
</div>
</body>
</html>

