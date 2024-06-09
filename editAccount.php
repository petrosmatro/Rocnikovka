<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');

if(isset($_POST['saveChanges'])){
    $editUsername = mysqli_real_escape_string($conn, $_POST['editUsername']);
    $id = $_POST['id'];

    $select = "SELECT * FROM users WHERE username = '$editUsername'";
    $result = mysqli_query($conn, $select);
    $user_count = mysqli_num_rows($result);

    if($user_count == 0){
        $updateUser = "UPDATE users SET username = '$editUsername' WHERE id_user = '$id'";
        $_SESSION['username'] = $editUsername;
        mysqli_query($conn, $updateUser);
        $successmsg = "Changes have been saved successfully.";
    } else{
        $errormsg = "This username is already in use";
    }

    if(!empty($_FILES["fileImg"]["name"])){
        $src = $_FILES["fileImg"]["tmp_name"];
        $imageName = uniqid() . $_FILES["fileImg"]["name"];
        $target = "profileimgs/" . $imageName;

        move_uploaded_file($src, $target);

        $updateImg = "UPDATE users SET image = '$imageName' WHERE id_user = '$id'";
        mysqli_query($conn, $updateImg);
        $successmsg = "Changes have been saved successfully.";
    }
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
            transition: background-color 0.5s ease, color 0.5s ease;
            background: linear-gradient(to bottom right, #add8e6, #00008b);
            height: 100vh;
        }

        body.dark-mode{
            margin-top: 0;
            font-family: Arial, sans-serif;
            color: white;
            height: 100vh;
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

        .navbar a:hover {
            background-color: #333333;
            color: #ffffff;
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

        .edit-account img{
            width: 60px;
            height: 60px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            border-radius: 50%;
            border: 2px solid green;
            object-fit: cover;
            
        }

        .edit-account{
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            margin-top: 50px;
            border-radius: 5px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }

        .edit-account input[type="text"],
        .edit-account input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            border-radius: 5px;
        }

        .edit-account button{
            background-color: green;
            color: white;
            position: relative;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 50px;
            overflow: hidden;
        }

        .edit-account button::after {
            content: '';
            left: 0;
            bottom: 0px; 
            width: 100%; 
            height: 2px; 
            background-color: white; 
            position: absolute;  
            transform: scaleX(0); 
            transition: transform 0.7s ease;
        }

        

        .edit-account button:hover::after{
            transform: scaleX(1.0); 
        }

        /* Základní styl pro switch */
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

/* Skrytí standardního checkboxu */
.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

/* Styl pro slider */
.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

/* Styl pro přepnutí */
input:checked + .slider {
    background-color: #2196F3;
}

input:checked + .slider:before {
    transform: translateX(26px);
}

/* Přidání stínu při zaměření */
input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
}

.slider-container{
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
}

body.dark-mode .edit-account{
    background-color: #1a1a1a;
    border-color: #333333;
}

body.dark-mode .navbar{
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
    <div class="edit-account">
        <form action="" method="post" enctype="multipart/form-data">
            <?php echo "<img src='profileimgs/$image' id='image'>"; ?>
            <input type="hidden" name="id" value="<?php echo $user['id_user']?>">
            <label for="fileImg">Profile Image</label>
            <input type="file" name="fileImg" id="fileImg" accept=".jpg, .jpeg, .png">

            <label for="username">Username:</label>
            <input type="text" name="editUsername" value="<?php echo $username; ?>">
            <div class="slider-container">
                <span>Dark Mode</span>
                <label class="switch">
                    <input type="checkbox" id="darkModeToggle">
                    <span class="slider"></span>
                </label>
            </div>
            
            <button type="submit" name="saveChanges">Save Changes</button>
        </form>
        
    </div>
    

    <script>
        let subMenu = document.getElementById('subMenu');

        function toggleMenu(){
            subMenu.classList.toggle('open-menu');
        }

        document.getElementById('fileImg').onchange = function(){
            document.getElementById('image').src = URL.createObjectURL(fileImg.files[0]);
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