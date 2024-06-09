<?php
$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');
session_start();


if(isset($_POST['createTL'])){
    if(!isset($_SESSION['username'])){
        $error = 'You must be logged in to create a tier list';
    }else{
        header('Location:template.php');
    }
}

$random = mysqli_query($conn, "SELECT * FROM tierlists JOIN users ON tierlists.autor = users.id_user ORDER BY RAND() LIMIT 10");


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

        .navbar li .quiz-link{
            padding: 10px 10px;
            display: flex;
            gap: 10px;
            top: 17px;
            background-color: #0574a1;
            border-radius: 10px;
            left: 15px;
        }

        .navbar li .quiz-link span{
            font-size: 12px;
            transition: transform 0.5s;
        }

        .navbar li .quiz-link:hover span{
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
            padding: 30px;
            border-radius: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            background-color: white;
        }

        body.dark-mode .main-text{
            background-color: #1a1a1a;
        }

        .main-text button{
            color: white;
            text-align: center;
            padding: 20px;
            text-decoration: none;
            background-color: green;
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

        body.dark-mode .navbar{
            background-color: #1a1a1a;
        }

        body.dark-mode .sub-menu{
            background-color:  #1a1a1a;
        }

        .tierlist{
            display: inline-block;
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
            object-fit: cover;
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

        .random-tierlists{
            padding-left: 20px;
            padding-right: 20px;
            padding-top: 10px;
            width: 1000px;
            border-radius: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            background-color: white;
            margin-left: 130px;
            margin-top: 40px;
            margin-bottom: 40px;
            overflow: hidden;
            padding-bottom: 20px;
        }

        body.dark-mode .random-tierlists{
            background-color: #1a1a1a;
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

    <div class="random-tierlists">
    <h2 class="random-title">Random Tierlists</h2>
    <div class="random-container">
        
        <div class="scrollable-container">
            <div class="scrollable-content">
                <?php foreach($random as $r){?>
                    <div class="tierlist">
                        
                    <a href="viewlist.php?id=<?php echo $r['id_tier']?>">
                        <div class="cover-img">
                            <img src="coverimgs/<?php echo $r['cover'];?>">
                        </div>
                        <div class="tier-name">
                            <div class="author-container">
                                <img src="profileimgs/<?php echo $r['image']?>" alt="">
                            </div>
                            <div class="tier-info">
                                <span class="tier-title"><?php echo $r['nazev'];?></span>
                                <span class="author-username"><?php echo $r['username'];?></span>
                            </div>
                            
                        </div>
                    </a>
                        
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