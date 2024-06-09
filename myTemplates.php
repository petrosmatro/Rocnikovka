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
        }

        body.dark-mode{
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom right, #4b0082, #800080, #8b008b);
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

        .full-container{
            width: 800px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            margin: 50px auto;
            gap: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            background-color: white;
            padding-top: 20px;
            padding-bottom: 20px;
            border-radius: 30px;
        }

        .btns-container{
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: row;
        }

        

        .templates-container{
            height: 500px;
            width: 73%;
            border-top: 1px solid gray;
            display: flex;
            flex-wrap: wrap;
            gap: 3px;
            align-content: flex-start;
            overflow-y: auto;
            white-space: nowrap;
            padding-top: 10px;
        }

        .btn{
            border: none;
            background: none;
            transition: color 0.5s ease;
            position: relative;
            
        }

        .btn::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            display: block;
            right: 0;
            background: blue;
            transition: width 0.3s ease;
        }

        .btn:hover {
            color: blue;
        }

        .btn:hover::after {
            width: 100%;
            left: 0;
            background: blue;
        }

        .btn.active{
            color: blue;

        }

        .btn.active::after {
            position: absolute;
            width: 100%;
            height: 2px;
            display: block;
            right: 0;
            background: blue;
        }

        .tierlist{
            height: 130px;
            width: 190px;
            position: relative;
            border: 1.5px solid black;
            margin: 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);

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
            height: 40%;
            background-color: #1A1A1A;
            position: absolute;
            bottom: 0;
            z-index: 2;
            display: flex;
            align-items: center;
        }

        

        .author-container{
            width: 30px;
            height: 30px;
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

        .tier-btns{
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: row;
            position: absolute;
            background-color: rgba(0, 0, 0, 0.5);
            bottom: 0;
            top: 0;
            gap: 4px;
            opacity: 0;
            z-index: 3;
            transition: opacity 0.5s ease;
        }

        .tierlist:hover .tier-btns{
            opacity: 1;
        }

        .tier-btns button{
            width: 60px;
            height: 30px;
            border: none;
            border-radius: 20px;
        }

        .delete-btn{
            background-color: red;
            color: white;
        }

        .view-btn{
            background-color: skyblue;
            color: white;
        }

        .quiz{
            border-radius: 7px;
            width: 185px;
            height: 150px;
            cursor: pointer;
            overflow: hidden;
            display: flex;
            flex-direction: column;
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
            position: absolute;
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
            bottom: 0;
        }

        .quiz-info a{
            font-weight: bold;
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
            width: 20px;
            height: 20px;
            margin-left: 10px;
            border-radius: 50%;
            
        }

        .quiz-card-title{
            margin-left: 10px;
            font-size: 10px;
        }
        

        .quiz-author{
            font-size: 8px;
            color: grey;
        }

        .quiz-btns button{
            width: 60px;
            height: 30px;
            border: none;
            border-radius: 20px;
        }

        .quiz-delete-btn{
            background-color: red;
            color: white;
        }

        .quiz-view-btn{
            background-color: skyblue;
            color: white;
        }

        .quiz-btns{
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: row;
            position: relative;
            background-color: rgba(0, 0, 0, 0.5);
            bottom: 0;
            top: 0;
            gap: 4px;
            opacity: 0;
            z-index: 3;
            transition: opacity 0.5s ease;
        }

        .quiz:hover .quiz-btns{
            opacity: 1;
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

    <div class="full-container">
        <div class="btns-container">
            <button class="btn" onclick="loadData('load_tierlists_templates', this)">Tier Lists</button>
            <button class="btn" onclick="loadData('load_quizzes_templates', this)">Quizzes</button>
        </div>
        <div id="templatesContainer" class="templates-container"></div>
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

        function loadData(type, btn) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', type + '.php', true); // Zde předpokládáme, že data jsou načítána z tierlists.php nebo quizzes.php
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('templatesContainer').innerHTML = this.responseText;
                } else {
                    document.getElementById('templatesContainer').innerHTML = 'Chyba při načítání dat.';
                }
            }
            xhr.send();

            // Nastavíme aktivní tlačítko a zrušíme aktivitu ostatních
            document.querySelectorAll('.btn').forEach(button => {
                button.classList.remove('active');
                
            });
            btn.classList.add('active');
            
        }

        function deleteTierlist(id) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_tier.php?id=' + id, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('tierlist-' + id).remove();
                } else {
                    alert('Chyba při mazání záznamu.');
                }
            }
            xhr.send();
        }

        function deleteQuiz(id) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_quiz.php?id=' + id, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('quiz-' + id).remove();
                } else {
                    alert('Chyba při mazání záznamu.');
                }
            }
            xhr.send();
        }

        function viewTierlist(url){
            window.location.href = url;
        }

        function viewQuiz(url){
            window.location.href = url;
        }
    </script>
</body>
</html>