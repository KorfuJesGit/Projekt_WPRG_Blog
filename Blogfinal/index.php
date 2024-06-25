<html> 
<link rel="stylesheet" type="text/css" href="style.css">
</html>
<?php
session_start();
include 'dbconnect.php';

$sql = "SELECT * FROM wpisy ORDER BY wstawiono DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="style.css">
<head>
    <title>Blog</title>

</head>
<body>
<div class="container">
    <header>
        <h1>Blog </h1>
        <h2> <?php if (isset($_SESSION['nazwa'])): ?>

            <a class="add-wpis" href="add_wpis.php">Dodaj wpis</a>
        <?php endif; ?></h2>
        <h3> <?php if (isset($_SESSION['nazwa'])): ?>

            <span>Cześć, <?= $_SESSION['nazwa'] ?>!</span>

            <?php endif; ?></h3>
        <nav>
            <?php if (isset($_SESSION['nazwa'])): ?>
                
                <a href="logout.php">Wyloguj sie</a>
            <?php else: ?>

                <a href="login.php">Zaloguj sie</a>

                <a href="rejestracja.php">Rejestracja</a>

            <?php endif; ?>
        </nav>
    </header>
    <main>
        <?php while ($row = $result->fetch_assoc()): ?>

            <div class="wpis">
                <h2><a href="wpisy.php?id=<?= $row['id'] ?>"><?= $row['tytul'] ?></a></h2>
                <p><?= substr($row['zawartosc'], 0, 200) ?>...</p>

                <?php if ($row['zalacznik']): ?>
                    <img src="uploads/<?= $row['zalacznik'] ?>" alt="zalacznik">

                <?php endif; ?>
                <p><small><?= $row['wstawiono'] ?></small></p>
                <?php if (isset($_SESSION['nazwa']) && $_SESSION['nazwa'] == $row['autor']): ?>

                    
                    <a class="edit-wpis" href="edytuj_post.php?id=<?= $row['id'] ?>">Edytuj</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
       
    </main>
</div>
</body>
</html>
