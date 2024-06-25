<?php
include 'dbconnect.php';

$wpisy_id = $_GET['id'];
$sql = "DELETE FROM posts WHERE id=$wpisy_id";


if ($conn->query($sql) === TRUE) {

    header('Location: index.php');
} else {
    echo "Blad: " . $sql . "<br>" . $conn->error;

}
?>
