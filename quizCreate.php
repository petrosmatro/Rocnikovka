<?php
$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');
session_start();

if(isset($_POST['submit'])){
    
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = $_POST['category'];
    $autor = $_SESSION['id'];
    $currentDate = date('Y-m-d');
    $query = "INSERT INTO quizzes(quiz_name, category, author, created_on) VALUES ('$title', (SELECT categories.id_cat FROM categories WHERE nazevCat = '$category'), $autor, '$currentDate')";
    mysqli_query($conn, $query);

    
    
    $quiz_id = $conn -> insert_id;

    $select = "SELECT * FROM quizzes WHERE id_quiz = '$quiz_id'";
    $result = mysqli_query($conn, $select);
    $row = mysqli_fetch_array($result);
    $_SESSION['quiz_id'] = $row['id_quiz'];

    if(!empty($_FILES["fileImg"]["name"])){
        $src = $_FILES["fileImg"]["tmp_name"];
        $imageName = uniqid() . $_FILES["fileImg"]["name"];
        $target = "coverimgs/" . $imageName;

        

        move_uploaded_file($src, $target);
        $insertCover = "UPDATE quizzes SET cover = '$imageName' WHERE id_quiz = '$quiz_id'";
        mysqli_query($conn, $insertCover);
        

        
        
    }

    header('location:quizQuestions.php');


}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <style>
        .overview-container{
            width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            margin-top: 50px;
            border-radius: 5px;
        }

        .overview-container input{
            width: 100%;
        }

        .overview-container button{
            padding: 10px;
            color: white;
            background-color: #d92bd0;
            padding: 12px 32px;
            border: none;
            border-radius: 7px;
            text-decoration: none;
            text-align: center;

        }

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


    <div class="overview-container">
        <h1>Quiz Overview</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" name="title" required>

            <label for="fileImg">Cover for your Quiz</label>
            <input type="file" name="fileImg" id="fileImg" accept=".jpg, .jpeg, .png">

            <label for="category">Select Category</label>
            <select name="category" id="category">
                <option value="music">Music</option>
                <option value="movies">Movies</option>
                <option value="cars">Cars</option>
                <option value="books">Books</option>
                <option value="games">Games</option>
                <option value="other">Other</option>
            </select>

            <button name="submit">Submit</button>
        </form>
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