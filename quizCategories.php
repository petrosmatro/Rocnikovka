<?php
$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');
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
            background: linear-gradient(to bottom right, #add8e6, #00008b);
            height: 100vh;
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

        .sub-menu-wrap{
            position: absolute;
            top: 13%;
            right: 20px;
            width: 200px;
            max-height: 0px;
            overflow: hidden;
            transition: max-height 0.5s;
            z-index: 2;
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

        .cat-container{
            width: 100%;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: row;
            gap: 30px;
            margin-top: 150px;
        }

        .cat{
            height: 100%;
            width: 10%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .cat:hover{
            transform: scale(1.2);
        }

        .cat a{
            width: 100%;
            height: 100%;
            position: absolute;
            z-index: 2;
        }

        .cat-cover{
            height: 70%;
            width: 100%;
            position: absolute;
        }

        .cat-cover img{
            object-fit: cover;
            width: 100%;
            height: 100%;
            position: absolute;
        }

        .cat-info{
            height: 30%;
            width: 100%;
            background-color: #262626;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            bottom: 0;
        }

        .cat-info p{
            color: white;

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
    <div class="cat-container">
        <div class="cat">
            <a href="quizMusic.php"></a>
            <div class="cat-cover">
                <img src="music.jpg" alt="">
            </div>
            <div class="cat-info">
                <p>Music</p>
            </div>
        </div>
        <div class="cat">
            <a href="quizCars.php"></a>
            <div class="cat-cover">
                <img src="cars.jpg" alt="">
            </div>
            <div class="cat-info">
                <p>Cars</p>
            </div>
        </div>
        <div class="cat">
            <a href="quizGames.php"></a>
            <div class="cat-cover">
                <img src="games.png" alt="">
            </div>
            <div class="cat-info">
                <p>Games</p>
            </div>
        </div>
        <div class="cat">
            <a href="quizMovies.php"></a>
            <div class="cat-cover">
                <img src="movies.jpg" alt="">
            </div>
            <div class="cat-info">
                <p>Movies</p>
            </div>
        </div>
        <div class="cat">
            <a href="quizBooks.php"></a>
            <div class="cat-cover">
                <img src="books.png" alt="">
            </div>
            <div class="cat-info">
                <p>Books</p>
            </div>
        </div>
        <div class="cat">
            <a href="quizOther.php"></a>
            <div class="cat-cover">
                <img src="other.jpg" alt="">
            </div>
            <div class="cat-info">
                <p>Other</p>
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