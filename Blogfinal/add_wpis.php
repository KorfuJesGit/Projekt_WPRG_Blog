<?php
session_start();
include 'dbconnect.php';


if (!isset($_SESSION['nazwa'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $tytul = $_POST['tytul'];

    $zawartosc = $_POST['zawartosc'];

    $zalacznik = $_FILES['zalacznik']['name'];

    $autor = $_SESSION['nazwa']; 

  
    if ($zalacznik) {

        $folder = "uploads/";

        $plik = $folder . basename($zalacznik);

        move_uploaded_file($_FILES['zalacznik']['tmp_name'], $plik);

    }

    $sql = "INSERT INTO wpisy (tytul, zawartosc, zalacznik, autor) VALUES ('$tytul', '$zawartosc', '$zalacznik', '$autor')";

    if ($conn->query($sql) === TRUE) {

        header('Location: index.php');

    } else {

        echo "Blad: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>

    <title>Dodawanie nowego wpisu</title>

    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
<div class="container">
    <header>

        <h1>Dodaj nowy wpis</h1>
        <nav>

            <?php if (isset($_SESSION['nazwa'])): ?>

                <span>Czesc, <?= $_SESSION['nazwa'] ?>!</span>

                <a href="index.php">Strona główna</a>

                <a href="logout.php">Logout</a>

            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <form action="add_wpis.php" method="post" enctype="multipart/form-data">

            <input type="text" name="tytul" placeholder="tytul" required>
            

            <textarea name="zawartosc" placeholder="zawartosc" required></textarea>
            <input type="file" name="zalacznik">
            <button type="submit">Wstaw wpis</button>

            
        </form>
    </main>
</div>
</body>
</html>
