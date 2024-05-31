<?php
    $conn = mysqli_connect('localhost', 'root', '', 'mytierlist');
    session_start();

    $sql = "SELECT * FROM quizzes JOIN users ON quizzes.author = users.id_user";
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

        body.dark-mode{
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
        }

        body.dark-mode .quiz-card-title{
            color: white;
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

        .navbar li .tier-link{
            padding: 10px 10px;
            display: flex;
            gap: 10px;
            top: 17px;
            background-color: green;
            border-radius: 10px;
            left: 15px;
        }

        .navbar li .tier-link span{
            font-size: 12px;
            transition: transform 0.5s;
        }

        .navbar li .tier-link:hover span{
            transform: translateX(5px);
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

        .quizzes-container{
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 10%;

        }

        .quiz{
            border-radius: 10px;
            padding: 7px;
            width: 300px;
            height: 300pxpx;
            cursor: pointer;
            
            
        }

        .quiz a{
            width: 100%;
            display: block;
            text-decoration: none;
            color: black;
        }

        .quiz a .quiz-card-image{
            width: 300px;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.5s;
        }

        .quiz a .quiz-card-image:hover{
            transform: scale(0.9)
        }

        .quiz:hover {
            background-color: lightgrey;
            border: 1px solid grey;
            -webkit-transition: background-color 600ms linear;
            -ms-transition: background-color 600ms linear;
            transition: background-color 600ms linear;
            
        }

        body.dark-mode .quiz:hover{
            background-color: #525252;
        }

        .quiz-author{
            font-size: small;
            color: grey;
        }

        body.dark-mode .quiz-author{
            color: #a9abaa;
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
                    echo "<a href='login.php' style='background-color: #0574a1;'>LOG IN</a>";
                }
            ?>
        </li>
        <li><a href="myTemplates.php">My Templates</a></li>
        <li><a href="quizzes.php">Quizzes</a></li>
        <li><a href="categories.php">Categories</a></li>
        <li style="float:left"><a class="tier-link" href="main.php">Switch to Tier Lists Page <span>></span></a></li>
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

    <div class="quizzes-container">
        <?php foreach ($query as $q){?>
            <div class="quiz">

                <a href="viewquiz.php?id=<?php echo $q['id_quiz']?>"> 
                    <img class="quiz-card-image" src="coverimgs/<?php echo $q['cover']?>" alt="">
                </a>

                <a href="viewquiz.php?id=<?php echo $q['id_quiz']?>">
                    <p class="quiz-card-title"><?php echo $q['quiz_name']?></p>
                </a>

                <p class="quiz-author">By <?php echo $q['username']?></p>
                
                    
            </div>
        <?php }?>
    </div>

    <script>
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