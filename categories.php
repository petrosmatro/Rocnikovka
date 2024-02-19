<?php

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

        .cat-container a{
            padding: 50px 100px;
            text-decoration: none;
            color: white;
            background-color: grey;
            background-size: cover;
            text-align: center;
            position: relative;
        }

        .cat-container{
            display: flex;
            flex-wrap: wrap;
            position: relative;
            gap: 20px;
            justify-content: center;
            margin-top: 100px;
            
        }


        .cat-container a::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: black; /* Průhledná černá barva */
            opacity: 0; /* Výchozí průhlednost - není zobrazena */
            transition: opacity 0.3s ease; /* Plynulý přechod průhlednosti */
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
        <li><a href="categories.php">Categories</a></li>
        <li><a href="main.php">Main Page</a></li>
        <li style="float:left"><img src="logoprostranku.png" alt="" width="150" height="70"></li>
    </ul>
    
   
    <div class="cat-container">
        <a style="background-image: url('music.jpg');" href="music.php"><div></div>Music</a>
        <a style="background-image: url('cars.jpg')" href="cars.php">Cars</a>
        <a href="games.php">Games</a>
        <a href="movies.php">Movies</a>
        <a href="books.php">Books</a>
        <a href="other.php">Other</a>
    </div>
    
</body>
</html>