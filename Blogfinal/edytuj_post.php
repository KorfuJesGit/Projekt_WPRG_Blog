<?php
include 'dbconnect.php';


$wpisy_id = $_GET['id'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tytul = $_POST['tytul'];

    $zawartosc = $_POST['zawartosc'];

    $zalacznik = $_POST['istniejacy_zalacznik'];


    if ($_FILES['zalacznik']['name']) {
        $zalacznik = time() . '_' . $_FILES['zalacznik']['name'];
        move_uploaded_file($_FILES['zalacznik']['tmp_name'], "uploads/" . $zalacznik);
    }


    $sql = "UPDATE wpisy SET tytul='$tytul', zawartosc='$zawartosc', zalacznik='$zalacznik' WHERE id=$wpisy_id";
    if ($conn->query($sql) === TRUE) {


        header('Location: wpisy.php?id=' . $wpisy_id);
    } else {
        echo "Blad: " . $sql . "<br>" . $conn->error;
    }
} else {
    $sql = "SELECT * FROM wpisy WHERE id=$wpisy_id";


    $result = $conn->query($sql);

    $post = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edytowanie wpisu</title>

    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <h1>Edytuj wpis</h1>
    <form action="edytuj_post.php?id=<?= $wpisy_id ?>" method="post" enctype="multipart/form-data">

        <input type="text" name="tytul" value="<?= $post['tytul'] ?>" required>


        <textarea name="zawartosc" required><?= $post['zawartosc'] ?></textarea>

        <input type="ukryty" name="istniejacy_zalacznik" value="<?= $post['zalacznik'] ?>">
        <?php if ($post['zalacznik']): ?>

            <img src="uploads/<?= $post['zalacznik'] ?>" alt="zalacznik">
        <?php endif; ?>
        <input type="plik" name="zalacznik">


        <button type="submit">Zatwierdz</button>
    </form>
</body>
</html>
