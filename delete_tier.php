<?php

session_start();

$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM tierlists WHERE id_tier = $id");

?>