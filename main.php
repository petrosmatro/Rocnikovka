<?php
session_start();

if(isset($_POST['createTL'])){
    if(!isset($_SESSION['username'])){
        $error = 'You must be logged in to create a tier list';
    }else{
        header('Location:template.php');
    }
}


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

        .main-text{
            text-align: center;
            margin-top: 10%;
            margin-left: 20%;
            margin-right: 20%;
        }

        .main-text button{
            color: white;
            text-align: center;
            padding: 20px;
            text-decoration: none;
            background-color: green;
            
        }

        .error-msg{
            color: red;
            font-size: small;
            margin-top: -1px;
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
   
    <form action="" method="post">
        <div class="main-text">
            <h2>Create your own tier list!</h2>
            <p>A tier list is a ranking system that allows you to rank anything in tiers from the best to worst. Using a tier list allows you to group similar ranked items together and it's quick and easy to create a tier list.</p>
            
            <button name="createTL">Create a tier list!</button>
                <?php
                    if(isset($error)){
                        echo '<p class="error-msg"><strong>'.$error.'</strong></p>';
                    }
                ?>
            
        </div>
    </form>
</body>
</html>