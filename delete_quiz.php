<?php

session_start();

$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM quizzes WHERE id_quiz = $id");


?>