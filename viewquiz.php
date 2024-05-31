<?php

$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');
session_start();

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM quizzes JOIN categories ON quizzes.category = categories.id_cat WHERE id_quiz = '$id'";
    $sqlQuestions = "SELECT COUNT(questions.id_question) AS amount FROM questions WHERE id_quiz = '$id'";
    $queryQuestions = mysqli_query($conn, $sqlQuestions);
    $questionRows = mysqli_fetch_assoc($queryQuestions);
    $questionsAmount = $questionRows['amount'];
    $query = mysqli_query($conn, $sql);
    $quiz = mysqli_fetch_assoc($query);
    $title = $quiz['quiz_name'];
    $cover = $quiz['cover'];
    $author = $quiz['author'];
    $releaseDate = $quiz['created_on'];

    $results = mysqli_query($conn, "SELECT * FROM results JOIN users ON results.user = users.id_user WHERE id_quiz = $id ORDER BY accuracy DESC");
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

        .quiz-preview{
            margin: 50px auto;
            width: 900px;
            height: 350px;
            background-color: #f4f4f4;
            border-radius: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: row;
            overflow: hidden;
            border: 1px solid #ddd;
        }

        .quiz-preview div{
            flex: 1;
            height: 100%;
        }

        





        .play-container a{
            position: relative;
            width: 90%;
            height: 10%;
            color: white;
            background-color: #e02690;
            font-size: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            margin-left: 22px;
            margin-top: 20px;
            border-radius: 15px;
        }

        

        .quiz-image img{
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .right-side .quiz-image{
            position: relative;
            height: 80%;
            width: 95%;
            margin-top: 5px;
            border-radius: 15px;
            margin-left: 12px;
            overflow: hidden;
        }

        .left-side .quiz-info{
            height: 70%;
            width: 50%;
            position: relative;
            
            left: 12%;
            top: 15%;

        }

        .quiz-info .user-row{
            width: 100%;
            height: 30%;
            position: relative;
        }

        .user-row{
            display: flex;
            align-items: center;
        }

        .user-row img{
            height: 50px;
            width: 50px;
            border-radius: 50%;
            margin-right: 20px;
        }

        .user-row h3{
            color: black;
            font-weight: bold;
        }

        .left-side hr{
            border: 0;
            height: 2px;
            width: 100%;
            background: lightgray;
            border-radius: 50px;
            margin-top: -3px;
        }

        .left-side p a{
            text-decoration: none;
            background-color: lightgray;
            padding: 5px;
            color: black;
            border-radius: 5px;

        }

        .quiz-title{
            margin-left: 190px;
            margin-bottom: -45px;
        }

        .table-container {
            width: 50%;
            height: 200px; /* Nastavte požadovanou výšku */
            margin: 50px auto;
            overflow: auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
        }

        .results-table th, .results-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .results-table th {
            background-color: #f4f4f4;
            font-weight: bold;
            position: sticky;
            top: 0; /* Fixuje hlavičku tabulky při rolování */
        }

        .results-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .results-table tr:hover {
            background-color: #f1f1f1;
        }

        .results-table a{
            text-decoration: none;
            padding: 7px;
            background-color: #0574a1;
            border-radius: 3px;
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
                    echo "<a href='login.php' style='background-color: green;'>LOG IN</a>";
                }
            ?>
        </li>
        <li><a href="myTemplates.php">My Templates</a></li>
        <li><a href="tierlists.php">Tier Lists</a></li>
        <li><a href="categories.php">Categories</a></li>
        <li style="float:left"><a style="padding: 0;" href="main.php"><img src="logoprostranku.png" alt="" width="150" height="70"></a></li>
        <li style="float:left"><a class="quiz-link" href="quizMain.php">Switch to Quiz Page <span>></span></a></li>
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


    <h1 class="quiz-title"><?php echo $title;?></h1>
    <div class="quiz-preview">
        <div class="left-side">
            <div class="quiz-info">
                <div class="user-row">
                    <?php echo "<img src='profileimgs/$image'>" ?>
                    <?php echo "<h3>".$username."</h3>"; ?>
                </div>
                <hr>
                <p>Created on: <strong><?php echo $releaseDate;?></strong><p></p></p>
                <p>Category: <a href="<?php echo strtolower($quiz['nazevCat'])?>.php"><?php echo $quiz['nazevCat']?></a></p>
                <p>Questions: <strong><?php echo $questionsAmount;?> questions</strong></p>
            </div>
        </div>

        <div class="right-side">
            <div class="quiz-image">
                <img src="coverimgs/<?php echo $cover;?>" alt="">
            </div>
            <div class="play-container">
                <a href="playquiz.php?id=<?php echo $id;?>">PLAY</a>
            </div>
        </div>

        
    </div>
    <div class="table-container">
            <table class="results-table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Player</th>
                        <th>Correct</th>
                        <th>Wrong</th>
                        <th>Accuracy</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $rank = 1; foreach ($results as $res){?>
                        <tr>
                            <td>
                                <?php echo $rank;?>
                            </td>
                            <td>
                                <?php echo $res['username'];?>
                            </td>
                            <td>
                                <?php echo $res['correct_answers'];?>
                            </td>
                            <td>
                                <?php echo $res['wrong_answers'];?>
                            </td>
                            <td>
                                <?php echo $res['accuracy'];?>%
                            </td>
                            <td>
                                <a href="playquiz.php?id=<?php echo $id;?>&player=<?php echo $res['id_user'];?>">PLAY AGAINST⚔️</a>
                            </td>
                        </tr>
                    <?php $rank++; }?>
                </tbody>
            </table>
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