<?php

include 'dbconnect.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nazwa = $_POST['nazwa'];

    $haslo = $_POST['haslo'];

    $sql = "SELECT * FROM users WHERE nazwa='$nazwa' AND haslo='$haslo'";

    $result = $conn->query($sql);



    if ($result->num_rows > 0) {
        $_SESSION['nazwa'] = $nazwa;
        header('Location: index.php');
    } else {
        echo "niepoprawna nazwa lub haslo";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>

    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">


    <h1>Login</h1>
    <form action="login.php" method="post">

        <input type="text" name="nazwa" placeholder="nazwa" required>

        <input type="haslo" name="haslo" placeholder="haslo" required>

        <button type="submit">Login</button>
    </form>
</div>

</body>

</html>
