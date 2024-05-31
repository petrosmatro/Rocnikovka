<?php
$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');
session_start();

if(isset($_POST['createQ'])){
    if(!isset($_SESSION['username'])){
        $error = 'You must be logged in to create a tier list';
    }else{
        header('Location:quizCreate.php');
    }
}

$randQuizzes = mysqli_query($conn, 'SELECT * FROM quizzes JOIN users ON quizzes.author = users.id_user ORDER BY RAND() LIMIT 8');


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
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
            background-color: #0574a1;
            border-radius: 8px;
        }

        .error-msg{
            color: red;
            font-size: small;
            margin-top: -1px;
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

        .quiz{
            display: inline-block;
            width: 200px;
            height: 150px;
            color: white;
            text-align: center;
            line-height: 150px;
            font-size: 24px;
            border-radius: 10px;
            
            
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

        

        .scroll-container {
            width: 80%;
            overflow-x: scroll;
            white-space: nowrap;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #fff;
        }

        .scroll-content {
            display: flex;
            gap: 20px;
        }

        

        

</style>
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
   
    <form action="" method="post">
        <div class="main-text">
            <h2>Create your own quiz!</h2>
            <p>At this page, you can create your own quiz with your favorite themes. It's easy, fast and funny.</p>
            
            <button name="createQ">Create a quiz!</button>
                <?php
                    if(isset($error)){
                        echo '<p class="error-msg"><strong>'.$error.'</strong></p>';
                    }
                ?>
            
        </div>
    </form>


    <div class="scroll-container">
        <div class="scroll-content">
            <?php foreach($randQuizzes as $rq){?>
                <div class="quiz">

                    <a href="viewquiz.php?id=<?php echo $rq['id_quiz']?>"> 
                        <img class="quiz-card-image" src="coverimgs/<?php echo $rq['cover']?>" alt="">
                    </a>

                    <a href="viewquiz.php?id=<?php echo $rq['id_quiz']?>">
                        <p class="quiz-card-title"><?php echo $rq['quiz_name']?></p>
                    </a>

                    <p class="quiz-author">By <?php echo $rq['username']?></p>
                
                    
                </div>
            <?php }?>
        </div>
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