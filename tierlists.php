<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');

$sql = "SELECT * FROM tierlists";
$query = mysqli_query($conn, $sql);

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

        .tiers-container{
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 10%;

        }

        .tierlist{
            border: 1px solid #ccc;
            box-sizing: border-box;
            border-radius: 5px;
            padding: 7px;

            
            
        }

        .tierlist a{
            display: block;
            color: white;
            text-align: center;
            padding: 10px 5px;
            text-decoration: none;
            background-color: green;
            border-radius: 5px;
        }

        .author{
            font-size: 10px;
            color: gray;
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

    <div class="tiers-container">
        <?php foreach ($query as $q){?>
            <div class="tierlist">
                    
                
                <h4><?php echo $q['nazev']?></h4>
                <h6><?php echo $q['tema']?></h6>
                <p class="author"><p class="author">Created by: </p><?php echo $q['autor']?></p>
                <a href="viewlist.php?id=<?php echo $q['id_tier']?>">View tier list!</a>
                
                    
            </div>
        <?php }?>
    </div>
</body>
</html>