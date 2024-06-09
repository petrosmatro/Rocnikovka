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

    $query3 = mysqli_query($conn, "SELECT * FROM tier_rows WHERE id_tier = $id_tier");

    




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

        .tier-container{
            
            width: 100%;
            margin-bottom: 20%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        body.dark-mode .tier-name{
            color: black;
        }

        .items-container{
            display: flex;
            margin-top: 20px;
            flex-direction: column;
            align-items: center;
            width: 850px;


        }
        
        .images-container{
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            width: 800px;
        }

        .full-images-container{
            width: 100%;
            display: flex;
            
            justify-content: center;
        }
        
        .images-container img{
            height: 80px;
            width: 80px;
            object-fit: cover;
        }

        .tier {
            display: flex;
            align-items: stretch;
            width: 100%;
            min-height: 80px;
            max-height: 240px;
            position: relative;
        }

        .tier-name {
            background-color: #f0f0f0;
            width: 30%;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        .tier-content {
            background-color: black;
            width: 100%;
            margin-left: -20px;
            display: flex;
            flex-wrap: wrap;
            
        }

        .tier-desc{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .tier-content img{
            height: 80px;
            width: 80px;
        }

        .download-btn{
            padding: 10px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 20px;
            margin-top: 50px;
        }

        .tiers-container{
            width: 90%;
            display: flex;
            flex-direction: column;
            gap: 10px;
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

        .comment-form-container {
            margin-top: 20px;
            display: flex;
            align-items: flex-start;
            width: 700px;
        }

        .profile-picture {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
        }

        .comment-form {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .comment-form textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
            font-size: 14px;
            margin-bottom: 10px;
        }

        body.dark-mode .comment-form textarea {
            background-color: #1a1a1a;
        }

        .comment-form button {
            align-self: flex-end;
            padding: 10px 20px;
            background-color: #0574a1;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
        }

        .comment-form button:hover {
            background-color: #0056b3;
        }

        body.dark-mode .comment-container{
            background-color: #1a1a1a;
        }

        body.dark-mode .comment-container span{
            color: white;
        }


        
    </style>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    <div class="tier-container">
        <div class="tier-desc">
            <h1>Tierlist Using</h1>
            <p>Here you can finally rank things to tiers in the way that you want.</p>
            <p>Feel free to make your own opinion.</p>
        </div>
        <?php foreach ($query as $q){?>
            <div class="items-container">
                <h2><?php echo $q['nazev']?></h2>
                <div class="tiers-container">
                    <?php foreach ($query3 as $q3){?>
                        <div class="tier">
                            <div style="background-color: <?php echo $q3['color'];?>;" class="tier-name"><span><?php echo $q3['row_name'];?></span></div>
                            <div class="tier-content"></div>
                        </div>
                    <?php }?>
                </div>
                
                
                <div class="full-images-container">
                    <div class="images-container">
                        <?php foreach ($query2 as $q2){ ?>
                            <img src="uploads/<?php echo $q2['nazev'];?>" alt="" id="img<?php echo $q2['id_img'];?>" draggable="true" class="draggable">
                        <?php } ?>
                    </div>
                </div>
                    
                
            </div>
        <?php } ?>
        
        <button class="download-btn">Download Tierlist as Image</button>

        <div class="comment-form-container">
            <img src="profileimgs/<?php echo $image?>" alt="Profile Picture" class="profile-picture">
            <form id="commentForm" class="comment-form" method="post">
                <textarea id="comment" name="comment" placeholder="Write your comment..." required></textarea>
                <button name="post_comment" type="submit">Post</button>
            </form>
        </div>

        <div id="comments" class="comments-container">
            
        </div>

        

            
    </div>

    <script>

        $(document).ready(function() {
            loadComments();
            $('#commentForm').on('submit', function(event) {
                event.preventDefault();

                var comment = $('#comment').val();

                $.ajax({
                    url: 'add_comment.php?id=<?php echo $id_tier;?>',
                    type: 'POST',
                    data: {comment: comment},
                    success: function() {
                        loadComments();
                        $('#comment').val('');
                    }
                });
            });

            function loadComments() {
                $.ajax({
                    url: 'load_comments.php?id=<?php echo $id_tier;?>',
                    type: 'GET',
                    success: function(response) {
                        $('#comments').html(response);
                    }
                });
            }
        });

        document.querySelector('.download-btn').addEventListener('click', function() {
            html2canvas(document.querySelector('.tiers-container')).then(function(canvas) {
                
                document.body.appendChild(canvas);
                
                var imgData = canvas.toDataURL('image/png');
                
                var link = document.createElement('a');
                link.href = imgData;
                link.download = 'screenshot.png';
                link.click();
            });
        });

            
        document.addEventListener('DOMContentLoaded', () => {
            const draggables = document.querySelectorAll('.draggable');
            const dropZones = document.querySelectorAll('.tier-content');

            draggables.forEach(draggable => {
                draggable.addEventListener('dragstart', dragStart);
                draggable.addEventListener('dragend', dragEnd);
            });

            dropZones.forEach(zone => {
                zone.addEventListener('dragover', dragOver);
                zone.addEventListener('drop', drop);
            });

            function dragStart(event) {
                event.dataTransfer.setData('text/plain', event.target.id);
                event.target.classList.add('dragging');
                setTimeout(() => {
                    event.target.style.visibility = 'hidden';
                }, 0);
            }

            function dragEnd(event) {
                event.target.style.visibility = 'visible';
                event.target.classList.remove('dragging');
            }

            function dragOver(event) {
                event.preventDefault();
                const dragging = document.querySelector('.dragging');
                const afterElement = getDragAfterElement(event.currentTarget, event.clientX);

                if (afterElement == null) {
                    event.currentTarget.appendChild(dragging);
                } else {
                    const bounding = afterElement.getBoundingClientRect();
                    const offset = event.clientX - bounding.left - bounding.width / 2;
                    if (offset > 0) {
                        event.currentTarget.insertBefore(dragging, afterElement.nextElementSibling);
                    } else {
                        event.currentTarget.insertBefore(dragging, afterElement);
                    }
                }
            }

            function drop(event) {
                event.preventDefault();
                const id = event.dataTransfer.getData('text');
                const draggable = document.getElementById(id);
                draggable.style.visibility = 'visible';
                draggable.classList.remove('dragging');
            }

            function getDragAfterElement(container, x) {
                const draggableElements = [...container.querySelectorAll('.draggable:not(.dragging)')];

                return draggableElements.reduce((closest, child) => {
                    const box = child.getBoundingClientRect();
                    const offset = x - box.left - box.width / 2;

                    if (offset < 0 && offset > closest.offset) {
                        return { offset: offset, element: child };
                    } else {
                        return closest;
                    }
                }, { offset: Number.NEGATIVE_INFINITY }).element;
            }
        });




        
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

            
        });

        function deleteComment(id) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_comment.php?id=' + id, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('comment-' + id).remove();
                } else {
                    alert('Chyba při mazání záznamu.');
                }
            }
            xhr.send();
        }
    </script>
</body>
</html>