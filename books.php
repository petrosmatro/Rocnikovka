<?php
    session_start();

    $conn = mysqli_connect('localhost', 'root', '', 'mytierlist');
    $sql = "SELECT * FROM tierlists JOIN categories ON tierlists.tema = categories.id_cat JOIN users ON tierlists.autor = users.id_user WHERE tema = 5";
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
            background: linear-gradient(to bottom right, #add8e6, #00008b);
            height: 200vh;
        }

        body.dark-mode{
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
            background: linear-gradient(to bottom right, #4b0082, #800080, #8b008b);
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
            position: relative;
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
            object-fit: cover;
        }

        .sub-menu-wrap{
            position: absolute;
            top: 13%;
            right: 20px;
            width: 200px;
            max-height: 0px;
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
            object-fit: cover;
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

        .tiers-container{
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 10%;
            position: absolute;

        }

        .tierlist{
            height: 200px;
            width: 300px;
            position: relative;
            border: 1.5px solid black;
        }

        .tierlist a{
            width: 100%;
            height: 100%;
            display: block;
            text-decoration: none;
            color: white;
            position: relative;
        }

        .cover-img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
        }

        .cover-img img{
            width: 100%;
            height: 100%;
        }

        .tier-name{
            width: 100%;
            height: 30%;
            background-color: #1A1A1A;
            position: absolute;
            margin-top: 140px;
            z-index: 2;
            display: flex;
            align-items: center;
        }

        

        .author-container{
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-left: 10px;
            overflow: hidden;
        }

        .author-container img{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .tier-info{
            height: 100%;
            display: flex;
            justify-content: center;
            margin-left: 10px;
            flex-direction: column;
            
        }

        .author-username{
            font-size: 12px;
        }

        body.dark-mode .navbar{
            background-color: #1a1a1a;
        }

        body.dark-mode .sub-menu{
            background-color:  #1a1a1a;
        }

        .navbar li .quiz-link{
            padding: 10px 10px;
            display: flex;
            gap: 10px;
            top: 17px;
            background-color: #0574a1;
            border-radius: 10px;
            left: 15px;
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
        <li><a href="tierlists.php">Tier Lists</a></li>
        <li><a href="categories.php">Categories</a></li>
        <li style="float:left"><a style="padding: 0;" href="main.php"><img src="logoprostranku.png" alt="" width="150" height="70"></a></li>
        <li style="float:left"><a class="quiz-link" href="quizMain.php">Switch to Quiz Page</a></li>
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
            <a href="myTemplates.php" class="sub-menu-link">
                <p>My Templates</p>
                <span>></span>
            </a>
            <?php if($_SESSION['user_type'] == 'admin'){?>
                <a href="database.php" class="sub-menu-link">
                    <p>Database</p>
                    <span>></span>
                </a>
            <?php }?>
            <a href="logout.php" class="sub-menu-link">
                <p>Logout</p>
                <span>></span>
            </a>
            
        </div>
    </div>

    <div class="tiers-container">
        <?php foreach ($query as $q){?>
            <div class="tierlist">
                    
                <a href="viewlist.php?id=<?php echo $q['id_tier']?>">
                    <div class="cover-img">
                        <img src="coverimgs/<?php echo $q['cover'];?>">
                    </div>
                    <div class="tier-name">
                        <div class="author-container">
                            <img src="profileimgs/<?php echo $q['image']?>" alt="">
                        </div>
                        <div class="tier-info">
                            <span class="tier-title"><?php echo $q['nazev'];?></span>
                            <span class="author-username"><?php echo $q['username'];?></span>
                        </div>
                        
                    </div>
                </a>
                    
            </div>
        <?php }?>
        
    </div>

    <script>
        let subMenu = document.getElementById('subMenu');

        function toggleMenu(){
            subMenu.classList.toggle('open-menu');
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            const toggle = document.getElementById('darkModeToggle');

            // Zkontrolovat a aplikovat uložené nastavení
            if (localStorage.getItem('darkMode') === 'enabled') {
                document.body.classList.add('dark-mode');
                toggle.checked = true;
            }

            // Při změně přepínače změnit režim
            toggle.addEventListener('change', () => {
                if (toggle.checked) {
                    document.body.classList.add('dark-mode');
                    localStorage.setItem('darkMode', 'enabled');
                } else {
                    document.body.classList.remove('dark-mode');
                    localStorage.setItem('darkMode', 'disabled');
                }
            });
        });
    </script>
</body>
</html>