<?php
    $conn = mysqli_connect('localhost', 'root', '', 'mytierlist');
    session_start();


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body{
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .navbar{
            list-style-type: none;
            overflow: hidden;
            margin: 0;
            padding: 0;
            background-color: black;
        }

        .navbar li{
            float: right;
        }

        .navbar li a{
            display: block;
            color: white;
            text-align: center;
            padding: 28px 35px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <ul class="navbar">
        <li>
            <?php 
            if (isset($_SESSION['id'])){
                    if(isset($_SESSION['username'])){
                        $username = $_SESSION['username'];
                        echo "<a href='logout.php'>".$username."</a>";
                    }
                }
                else{
                    echo "<a href='login.php' style='background-color: green;'>LOG IN</a>";
                }
            ?>
        </li>
        <li><a href="myTemplates.php">My Templates</a></li>
        <li><a href="tierlists.php">Tier Lists</a></li>
        <li><a href="main.php">Main Page</a></li>
        <li style="float:left"><img src="logoprostranku.png" alt="" width="150" height="70"></li>
    </ul>
</body>
</html>