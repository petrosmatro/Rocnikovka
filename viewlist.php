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

        .profile-img{
            display: block;
            top: 12px;
            right: 30px;
            position: relative;
            border-radius: 50%;
            margin-left: 30px;
        }

        .sub-menu-wrap{
            position: absolute;
            top: 13%;
            right: 20px;
            width: 200px;
            max-height: 0px;
            z-index: 1;
            overflow: hidden;
            transition: max-height 0.5s;
        }

        .sub-menu-wrap.open-menu{
            max-height: 400px;
        }

        .sub-menu{
            background: black;
            padding: 20px;
            margin: 10px;
            border-radius: 30px;
        }

        .user-info{
            display: flex;
            align-items: center;
        }
        .user-info h3{
            font-weight: 500;
            color: white;
        }

        .user-info img{
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .sub-menu hr{
            border: 0;
            height: 1px;
            width: 100%;
            background: white;
        }

        .sub-menu-link{
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white;
            margin: 12px 0;
        }
        .sub-menu-link p{
            width: 100%;
        }

        .sub-menu-link span{
            font-size: 22px;
            transition: transform 0.5s;
        }

        .sub-menu-link:hover span{
            transform: translateX(5px);
        }

        .sub-menu-link:hover p{
            font-weight: 600;
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
                        $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'"));
                        $image = $user['image'];
                        echo "<img src='profileimgs/$image' class='profile-img' width=50 height=50 onclick='toggleMenu()'>";
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
        <li style="float:left"><a style="padding: 0;" href="main.php"><img src="logoprostranku.png" alt="" width="150" height="70"></a></li>
    </ul>

    <div class="sub-menu-wrap" id="subMenu">
        <div class="sub-menu">
            <div class="user-info">
                <?php echo "<img src='profileimgs/$image'>" ?>
                <?php echo "<h3>".$username."</h3>"; ?>
            </div>
            <hr>
            <a href="editAccount.php" class="sub-menu-link">
                <p>Edit Account</p>
                <span>></span>
            </a>
            <a href="logout.php" class="sub-menu-link">
                <p>Logout</p>
                <span>></span>
            </a>
        </div>
    </div>

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

    <script>
        let subMenu = document.getElementById('subMenu');

        function toggleMenu(){
            subMenu.classList.toggle('open-menu');
        }

        
    </script>
</body>
</html>