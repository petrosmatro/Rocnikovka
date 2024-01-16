<?php
    $conn = mysqli_connect('localhost', 'root', '', 'mytierlist');
    session_start();

    $sql = "SELECT * FROM tierlists";
    $query = mysqli_query($conn, $sql);

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "SELECT * FROM tierlists WHERE id_tier = $id";
        $query = mysqli_query($conn, $sql);
    }

    $id_tier = $_GET['id'];
    $sql2 = "SELECT * FROM images WHERE tierlist = $id_tier";
    $query2 = mysqli_query($conn, $sql2);
    $resultArray = [];
    while ($row = mysqli_fetch_assoc($query2)) {
        $resultArray[] = $row;
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

        .tier-container{
            margin-top: 10%;
        
            margin-bottom: 20%;
        }

        .items-container{
            display: flex;
            flex-direction: column;
            align-items: center;


        }
        
        .images-container{
            display: flex;
            flex-wrap: wrap;
            
        }
        
        .images-container img{
            height: 100px;
            width: 100px;
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

    <div class="tier-container">
        <?php foreach ($query as $q){?>
            <div class="items-container">
                <h2><?php echo $q['nazev']?></h2>
                <h4><?php echo $q['tema']?></h4>
                <img src="TierList.jpg" alt="" width="768" height="432">
                
                    <div class="images-container">
                        <?php foreach ($resultArray as $q2): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($q2['obrazek']); ?>" alt="Image">
                        <?php endforeach; ?>
                    </div>
                
            </div>
        <?php } ?>
        

            
    </div>
</body>
</html>