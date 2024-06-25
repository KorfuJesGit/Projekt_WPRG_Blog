<?php
session_start();
include 'dbconnect.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$wpisy_id = $_GET['id'];
$sql = "SELECT * FROM wpisy WHERE id='$wpisy_id'";
$result = $conn->query($sql);
$post = $result->fetch_assoc();

$czy_autor = isset($_SESSION['nazwa']) && $_SESSION['nazwa'] === $post['autor'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete']) && $czy_autor) {
        $delete_sql = "DELETE FROM wpisy WHERE id='$wpisy_id'";
        if ($conn->query($delete_sql) === TRUE) {
            header('Location: index.php');
            exit();
        } else {
            echo "Błąd: " . $conn->error;
        }
    } elseif (isset($_POST['komentarze'])) {
        $zawartosc = $_POST['zawartosc'];
        $autor = isset($_SESSION['nazwa']) ? $_SESSION['nazwa'] : 'Gość';
        $komentarze_sql = "INSERT INTO komentarze (wpisy_id, autor, zawartosc) VALUES ('$wpisy_id', '$autor', '$zawartosc')";
        if ($conn->query($komentarze_sql) === TRUE) {
            header('Location: wpisy.php?id=' . $wpisy_id);
            exit();
        } else {
            echo "Błąd: " . $conn->error;
        }
    }
}

// Pobierz komentarze z bazy danych
$komentarze_sql = "SELECT * FROM komentarze WHERE wpisy_id='$wpisy_id' ORDER BY stworzono DESC";
$komentarze_result = $conn->query($komentarze_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($post['tytul']) ?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
    <header>
        <h1><?= htmlspecialchars($post['tytul']) ?></h1>
        <nav>
            <a href="index.php">Home</a>
            <?php if (isset($_SESSION['nazwa'])): ?>
                <span>Czesc, <?= htmlspecialchars($_SESSION['nazwa']) ?>!</span>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <p><?= nl2br(htmlspecialchars($post['zawartosc'])) ?></p>
        <?php if ($post['zalacznik']): ?>
            <img src="uploads/<?= htmlspecialchars($post['zalacznik']) ?>" alt="załącznik">
        <?php endif; ?>
       

        <?php if ($czy_autor): ?>
            <form method="post" action="">
                <input type="hidden" name="delete" value="1">
                <button type="submit">Usuń wpis</button>
            </form>
        <?php endif; ?>

        <h2>Komentarze</h2>
        <?php while ($komentarze = $komentarze_result->fetch_assoc()): ?>
            <div class="komentarze">
                <p><?= htmlspecialchars($komentarze['zawartosc']) ?></p>
                <p><small>Autor: <?= htmlspecialchars($komentarze['autor']) ?>, Data: <?= htmlspecialchars($komentarze['stworzono']) ?></small></p>
            </div>
        <?php endwhile; ?>

        <h2>Dodaj komentarz</h2>
        <form method="post" action="">
            <textarea name="zawartosc" required></textarea>
            <input type="hidden" name="komentarze" value="1">
            <button type="submit">Dodaj komentarz</button>
        </form>
    </main>
</div>
</body>
</html>
