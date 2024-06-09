<?php


$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');
session_start();

if ($conn->connect_error) {
    die("Připojení selhalo: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment =  $_POST['comment'];
    $currentDate = date('Y-m-d');
    mysqli_query($conn, "INSERT INTO tier_comments (content, com_author, id_tier, add_date) VALUES ('$comment', $_SESSION[id], $_GET[id], '$currentDate')");

}


?>
