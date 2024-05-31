<?php
$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');
session_start();

$total_que = 0;
$resl = mysqli_query($conn, "SELECT * FROM questions WHERE id_quiz = $_SESSION[current_quiz_id]");
$total_que = mysqli_num_rows($resl);
echo $total_que;




?>