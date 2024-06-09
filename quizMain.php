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
            background: linear-gradient(to bottom right, #add8e6, #00008b);
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
            object-fit: cover;
        }

        .main-text{
            text-align: center;
            margin-top: 10%;
            margin-left: 20%;
            margin-right: 20%;
            border-radius: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            background-color: white;
            padding: 20px;
        }

        body.dark-mode .main-text{
            background-color: #1a1a1a;
        }

        .main-text button{
            color: white;
            text-align: center;
            padding: 20px;
            background-color: #0574a1;
            border: none;
            border-radius: 20px;
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

        .quiz{
            border-radius: 7px;
            width: 300px;
            height: 260px;
            cursor: pointer;
            overflow: hidden;
            display: inline-block;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            position: relative;
        }

        .quiz a{
            text-decoration: none;
            color: white;
        }

        .cover-container{
            width: 100%;
            height: 65%;
            position: relative;
            overflow: hidden;
        }

        .cover-container a{
            width: 100%;
            height: 100%;
            text-decoration: none;
            position: absolute;
        }

        .quiz-card-image{
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            transition: transform 0.6s ease;
        }

        .cover-container a .quiz-card-image:hover{
            transform: scale(1.1);
        }

        .quiz-info{
            width: 100%;
            height: 35%;
            background-color: black;
            position: absolute;
        }

        .quiz-info a{
            font-weight: bold;
        }

        body.dark-mode .quiz-info{
            background-color: #1a1a1a;
        }

        .author-info{
            width: 100%;
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 10px;
            margin-top: -10px;
        }

        .author-info img{
            object-fit: cover;
            width: 30px;
            height: 30px;
            margin-left: 10px;
            border-radius: 50%;
            
        }

        .quiz-card-title{
            margin-left: 10px;
        }
        

        .quiz-author{
            font-size: small;
            color: grey;
        }

        

        .scrollable-container {
            overflow-x: auto;
            white-space: nowrap;
            background-color: #fff;
            border: 1px solid black;
            width: 1000px;
        }

        body.dark-mode .scrollable-container {
            background-color: #1a1a1a;
        }

        

        .scrollable-content {
            display: inline-block;
        }

        .random-container{
            width: 100%;
            
            display: flex;
            align-items: center;
            flex-direction: column;
        }

        .random-title{
           
        }

        .random-quizzes{
            padding-left: 20px;
            padding-right: 20px;
            padding-top: 10px;
            width: 1000px;
            border-radius: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            background-color: white;
            margin-left: 130px;
            margin-top: 40px;
            overflow: hidden;
            padding-bottom: 20px;
        }

        body.dark-mode .random-quizzes{
            background-color: #1a1a1a;
        }

        body.dark-mode .navbar{
            background-color: #1a1a1a;
        }

        body.dark-mode .sub-menu{
            background-color:  #1a1a1a;
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
        <li><a href="quizzes.php">Quizzes</a></li>
        <li><a href="quizCategories.php">Categories</a></li>
        <li style="float:left"><a style="padding: 0;" href="quizMain.php"><img src="quizSection.png" alt="" width="150" height="70"></a></li>
        <li style="float:left"><a class="tier-link" href="main.php">Switch to Tier Lists Page</a></li>
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


    <div class="random-quizzes">
    <h2 class="random-title">Random Quizzes</h2>
    <div class="random-container">
        
        <div class="scrollable-container">
            <div class="scrollable-content">
                <?php foreach($randQuizzes as $rq){?>
                <div class="quiz">

                    <div class="cover-container">
                        <a href="viewquiz.php?id=<?php echo $rq['id_quiz']?>"> 
                            <img class="quiz-card-image" src="coverimgs/<?php echo $rq['cover']?>" alt="">
                        </a>
                    </div>

                    <div class="quiz-info">
                        <a href="viewquiz.php?id=<?php echo $rq['id_quiz']?>">
                            <p class="quiz-card-title"><?php echo $rq['quiz_name']?></p>
                        </a>

                        <div class="author-info">
                            <img src="profileimgs/<?php echo $rq['image'];?>" alt="">
                            <p class="quiz-author"><?php echo $rq['username']?></p>
                        </div>
                        
                    </div>
                

                
                
                    
                </div>
                <?php }?>
            </div>
        </div>
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