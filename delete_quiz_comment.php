<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM quiz_comments WHERE id_com = $id");



?>