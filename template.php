<?php


$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');
session_start();

if (!isset($_SESSION['session_id'])) {
    $_SESSION['session_id'] = session_id();
}

if (isset($_POST['upload'])) {
    $title = $_POST['tempName'];
    $theme = $_POST['theme'];
    $author = $_SESSION['id'];
    $session_id = $_SESSION['session_id'];

    
    $conn->begin_transaction();

    try {

        mysqli_query($conn, "INSERT INTO tierlists (nazev, tema, autor) VALUES ('$title', (SELECT categories.id_cat FROM categories WHERE nazevCat = '$theme'), $author)");
        
        $post_id = $conn->insert_id;

        $tiers = $_POST['tiers'];
        foreach ($tiers as $tier){
            $tier_name = $tier['tier_name'];
            $color = $tier['color'];

            mysqli_query($conn, "INSERT INTO tier_rows (row_name, color, id_tier) VALUES ('$tier_name', '$color', $post_id)");
        }

        if(!empty($_FILES["cover"]["name"])){
            $src = $_FILES["cover"]["tmp_name"];
            $imageName = uniqid() . $_FILES["cover"]["name"];
            $target = "coverimgs/" . $imageName;
    
            
    
            move_uploaded_file($src, $target);
            $insertCover = "UPDATE tierlists SET cover = '$imageName' WHERE id_tier = '$post_id'";
            mysqli_query($conn, $insertCover);
            
    
            
            
        }

        
        $stmt = $conn->prepare("INSERT INTO images (nazev, tierlist) SELECT img_name, ? FROM temp_images WHERE session_id = ?");
        $stmt->bind_param("is", $post_id, $session_id);
        $stmt->execute();
        $stmt->close();

        
        $stmt = $conn->prepare("DELETE FROM temp_images WHERE session_id = ?");
        $stmt->bind_param("s", $session_id);
        $stmt->execute();
        $stmt->close();

        
        $conn->commit();

        echo "New post and images assigned successfully!";

    } catch (Exception $e) {
        
        $conn->rollback();
        echo "Error: " . $e->getMessage();
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





    .template-container{
        margin: 50px auto;
        width: 60%;
        border-radius: 30px;
        background-color: white;
        padding-top: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        

        
    }

    body.dark-mode .template-container{
        background-color: #1a1a1a;
    }

    .items-container{
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        

    }

    .items-container .temp-name{
        width: 50%;
        padding: 10px;
        margin: 5px 0 20px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
        border-radius: 5px;
    }

    .buttons-container{
        
        display: flex;
        flex-direction: row;
        justify-content: center;
    }

    .buttons-container button{
        margin: 20px;
        background-color: green;
        cursor: pointer;
        color: white;
        padding: 14px 20px;
        border: none;
        border-radius: 5px;
    }

    

    .image-container{
        display: flex;
        flex-wrap: wrap;
        width: 630px;
        min-height: 70px;
        max-height: 500px;
        
        border: 2px solid gray;
        gap: 10px;
    }

    .image-preview{
        height: 80px;
        width: 80px;
        object-fit: cover;
    }

    .tierlist-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 600px;
    }

    .tier {
        display: flex;
        flex-direction: row;
        align-items: center;
        width: 100%;
        height: 80px;
        position: relative;
        
    }

    .tier-name {
        background-color: #f0f0f0;
        height: 100%;
        width: 30%;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
    }

    .tier-content {
        background-color: black;
        height: 100%; /* Adjust as needed */
        width: 100%;
        margin-left: -20px;
        
    }

    body.dark-mode .tier-content {
        background-color: black;
    }

    .tier-button {
        height: 100%;
        font-size: 30px;
        background-color: gray;
        border: none;
        border-radius: 0 10px 10px 0;
    }

    .tier-name input{
        background: none;
        border: none;
        width: 100%;
        height: 100%;
        text-align: center;
        
    }

    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 2; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        border-radius: 10px;
        width: 40%;
        height: 25%;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .color-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .color-picker {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .color-circle.selected {
        border: 2px solid black;
    }

    .add-btn{
        width: 100%;
        background-color: black;
        height: 60px;
        color: white;
        font-size: 50px;
        font-weight: bold;
        border-radius: 10px;
    }

    body.dark-mode .add-btn{
        background-color: black;
    }

    .img-button{
        margin-top: 40px;
    }

    .confirm-btn{
        background-color: black;
        color: white;
        border: none;
        border-radius: 0 0 5px 5px;
        height: 30px;
        width: 130px;
        cursor: pointer;
    }

    body.dark-mode .confirm-btn{
        background-color: black;
    }

    .confirm-btn.disabled-btn{
        cursor: not-allowed; 
        opacity: 0.2; 
    }

    .desc{
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        margin-bottom: -50px;
    }

    .img-button {
        /* Příklad vlastních stylů */
        padding: 10px;
        background-color: #f7f7f7;
        border: 1px dashed black;
        border-bottom: none;
        border-radius: 5px 5px 0 0;
        cursor: pointer;
    }

    body.dark-mode .img-button{
        background-color: #1a1a1a;
        border-color: white;
    }

    .img-button:hover {
        background-color: #e7e7e7;
    }

    .upload-btn{
        width: 600px;
    }

    .cover-container{
        display: flex;
        align-items: center;
        justify-content: center;
        height: 200px;
        width: 400px;
        border: 2px dashed grey;
        border-radius: 10px;
        margin-bottom: 20px;
        overflow: hidden;
        position: relative;
    }
    
    .cover-container input{
        padding: 10px;
        background-color: #f7f7f7;
        border: 1px dashed black;
        border-radius: 5px;
        cursor: pointer;
    }

    body.dark-mode .cover-container input{
        background-color: #1a1a1a;
        border-color: white;
    }

    body.dark-mode .navbar{
        background-color: #1a1a1a;
    }

    body.dark-mode .sub-menu{
        background-color:  #1a1a1a;
    }

    .cover-container input:hover{
        background-color: #e7e7e7;
    }
    
    .full-cover-container{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        width: 100%;
    }

    .cover-preview{
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        z-index: 1;
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

    .delete-btn{
        width: 30%;
        height: 50px;
        background-color: #de5454;
        border: none;
        border-radius: 10px;
        margin-top: 50px;
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


    <div class="desc">
        <h1>Template Maker</h1>
        <p>This template maker is only for creating templates, but not for rate the things in theme.</p>
        <p>Everyone will be able to rank them after you upload it. Good Luck!</p>
    </div>
    <div class="template-container">
        
        <form action="" method="post" id="tierListForm" enctype="multipart/form-data">
            <div class="items-container" id="screenshot">
                <h3>Tier List Title</h3>
                <input type="text" class="temp-name" name="tempName" placeholder="Name your tier list..." required>
                <div class="full-cover-container">
                    <h3>Cover Image</h3>
                    <div class="cover-container">
                        <input type="file" id="coverInput" name="cover" required>
                    </div>
                </div>
                
                <h3>Select Category</h3>
                <select name="theme" style="width: 50%; margin-bottom: 15px;">
                    <option value="music">Music</option>
                    <option value="cars">Cars</option>
                    <option value="games">Games</option>
                    <option value="movies">Movies</option>
                    <option value="books">Books</option>
                    <option value="other">Other</option>
                </select>
                <div class="tierlist-container">
                    <div class="tier">
                        <div style="background-color: red;" class="tier-name">
                            <input type="text" name="tiers[0][tier_name]" value="S" required>
                        </div>
                        <div class="tier-content"></div>
                        <button type="button" class="tier-button" id="editTier">⚙️</button>
                        <div id="colorPickerModal" class="modal">
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <div class="color-picker" id="colorOptions">
                                    <div class="color-circle" style="background-color: red;" data-color="red"></div>
                                    <div class="color-circle" style="background-color: orange;" data-color="orange"></div>
                                    <div class="color-circle" style="background-color: yellow;" data-color="yellow"></div>
                                    <div class="color-circle" style="background-color: lightgreen;" data-color="lightgreen"></div>
                                    <div class="color-circle" style="background-color: lightblue;" data-color="lightblue"></div>
                                    <div class="color-circle" style="background-color: blue;" data-color="blue"></div>
                                    <div class="color-circle" style="background-color: purple;" data-color="purple"></div>
                                    <div class="color-circle" style="background-color: pink;" data-color="pink"></div>
                                </div>
                                <input type="hidden" class="selected-color" name="tiers[0][color]" value="red">
                                <button class="delete-btn">Delete this tier</button>
                            </div>
                        </div>
                    </div>
                    <div class="tier">
                        <div style="background-color: orange;" class="tier-name"><input type="text" name="tiers[1][tier_name]" value="A" required></div>
                        <div class="tier-content"></div>
                        <button type="button" class="tier-button" id="editTier">⚙️</button>
                        <div id="colorPickerModal" class="modal">
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <div class="color-picker" id="colorOptions">
                                    <div class="color-circle" style="background-color: red;" data-color="red"></div>
                                    <div class="color-circle" style="background-color: orange;" data-color="orange"></div>
                                    <div class="color-circle" style="background-color: yellow;" data-color="yellow"></div>
                                    <div class="color-circle" style="background-color: lightgreen;" data-color="lightgreen"></div>
                                    <div class="color-circle" style="background-color: lightblue;" data-color="lightblue"></div>
                                    <div class="color-circle" style="background-color: blue;" data-color="blue"></div>
                                    <div class="color-circle" style="background-color: purple;" data-color="purple"></div>
                                    <div class="color-circle" style="background-color: pink;" data-color="pink"></div>
                                </div>
                                <input type="hidden" class="selected-color" name="tiers[1][color]" value="orange">
                                <button class="delete-btn">Delete this tier</button>
                            </div>
                        </div>
                    </div>
                    <div class="tier">
                        <div style="background-color: yellow;" class="tier-name"><input type="text" name="tiers[2][tier_name]" value="B" required></div>
                        <div class="tier-content"></div>
                        <button type="button" class="tier-button" id="editTier">⚙️</button>
                        <div id="colorPickerModal" class="modal">
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <div class="color-picker" id="colorOptions">
                                    <div class="color-circle" style="background-color: red;" data-color="red"></div>
                                    <div class="color-circle" style="background-color: orange;" data-color="orange"></div>
                                    <div class="color-circle" style="background-color: yellow;" data-color="yellow"></div>
                                    <div class="color-circle" style="background-color: lightgreen;" data-color="lightgreen"></div>
                                    <div class="color-circle" style="background-color: lightblue;" data-color="lightblue"></div>
                                    <div class="color-circle" style="background-color: blue;" data-color="blue"></div>
                                    <div class="color-circle" style="background-color: purple;" data-color="purple"></div>
                                    <div class="color-circle" style="background-color: pink;" data-color="pink"></div>
                                </div>
                                <input type="hidden" class="selected-color" name="tiers[2][color]" value="yellow">
                                <button class="delete-btn">Delete this tier</button>
                            </div>
                        </div>
                    </div>
                    <div class="tier">
                        <div style="background-color: lightgreen;" class="tier-name"><input type="text" name="tiers[3][tier_name]" value="C" required></div>
                        <div class="tier-content"></div>
                        <button type="button" class="tier-button" id="editTier">⚙️</button>
                        <div id="colorPickerModal" class="modal">
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <div class="color-picker" id="colorOptions">
                                    <div class="color-circle" style="background-color: red;" data-color="red"></div>
                                    <div class="color-circle" style="background-color: orange;" data-color="orange"></div>
                                    <div class="color-circle" style="background-color: yellow;" data-color="yellow"></div>
                                    <div class="color-circle" style="background-color: lightgreen;" data-color="lightgreen"></div>
                                    <div class="color-circle" style="background-color: lightblue;" data-color="lightblue"></div>
                                    <div class="color-circle" style="background-color: blue;" data-color="blue"></div>
                                    <div class="color-circle" style="background-color: purple;" data-color="purple"></div>
                                    <div class="color-circle" style="background-color: pink;" data-color="pink"></div>
                                </div>
                                <input type="hidden" class="selected-color" name="tiers[3][color]" value="lightgreen">
                                <button class="delete-btn">Delete this tier</button>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="add-btn">+</button>
                    </div>
                </div>
                    
                

                <input type="file" id="fileInput" name="files[]" accept="image/*" class="img-button" multiple required>
                <div class="image-container" id="imageContainer"></div>
                <button type="button" class="confirm-btn" id="submitButton">Confirm Images</button>
            </div>
            <div class="buttons-container">
                <button type="submit" class="upload-btn" name="upload">Upload Template</button>
                
            </div>
        </form>
        
        
    </div>

    <script>

        document.getElementById("coverInput").addEventListener('change', function(event){
            const coverContainer = document.querySelector(".cover-container");
            var file = document.getElementById("coverInput").files[0];

            const reader = new FileReader();
            reader.onload = function(e){
                const img = document.createElement("img");
                img.src = e.target.result;
                img.classList.add("cover-preview");
                coverContainer.appendChild(img);
            }
            reader.readAsDataURL(file);
        });

        
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('fileInput');
            const submitButton = document.getElementById('submitButton');
            const previewContainer = document.getElementById('imageContainer');
            let filesArray = [];

            
            fileInput.addEventListener('change', function(event) {
                const selectedFiles = event.target.files;
                for (let i = 0; i < selectedFiles.length; i++) {
                    const file = selectedFiles[i];
                    filesArray.push(file);

                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('image-preview');
                        previewContainer.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                }
                
                fileInput.value = '';
            });

            
            submitButton.addEventListener('click', function() {
                if (filesArray.length > 0) {
                    const formData = new FormData();
                    filesArray.forEach((file, index) => {
                        formData.append('files[]', file, file.name);
                    });

                    fetch('upload.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Success:', data);
                        
                        filesArray = [];
                        
                        previewContainer.innerHTML = '';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });

                    submitButton.disabled = true;
                    submitButton.classList.add("disabled-btn");
                    submitButton.removeEventListener('click');
                } else {
                    alert('Žádné soubory k odeslání.');
                }
            });
        });

        

        document.addEventListener('DOMContentLoaded', function() {
            const tiers = document.querySelectorAll('.tier');

            function addEventListeners(tier){
                const btn = tier.querySelector('.tier-button');
                const modal = tier.querySelector('.modal');
                const span = modal.querySelector('.close');
                const colorCircles = modal.querySelectorAll('.color-circle');
                const hiddenInput = modal.querySelector('.selected-color');
                const deleteButton = modal.querySelector('.delete-btn');
                const targetElement = tier.querySelector('.tier-name');

                colorCircles.forEach(circle => {
                    circle.addEventListener('click', function() {
                        
                        colorCircles.forEach(c => c.classList.remove('selected'));
                        
                        circle.classList.add('selected');
                        
                        hiddenInput.value = circle.getAttribute('data-color');

                        targetElement.style.backgroundColor = hiddenInput.value;
                    });
                });

                targetElement.style.backgroundColor = hiddenInput.value;

                btn.onclick = function() {
                    modal.style.display = "block";
                }

                deleteButton.onclick = function() {
                    tier.remove();
                }

                span.onclick = function() {
                    modal.style.display = "none";
                }

                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
            }

            
            tiers.forEach(tier => {
                addEventListeners(tier);
            });
            
            const addButton = document.querySelector('.add-btn');
            const tierListContainer = document.querySelector('.tierlist-container');
            let tierIndex = 4;

            addButton.addEventListener('click', function () {
                const tier = document.querySelector('.tier').cloneNode(true);


                

                resetTierFields(tier);
                addEventListeners(tier);
                updateAttributeIndexes(tier, tierIndex);
                tierIndex++;

                

                tierListContainer.insertBefore(tier, addButton.parentNode);
            });
        });

        function updateAttributeIndexes(questionContainer, index){
            const inputs = questionContainer.querySelectorAll('input');

            inputs.forEach(input => {
                if (input.hasAttribute('name')) {
                    const name = input.getAttribute('name');
                    input.setAttribute('name', updateIndexInString(name, index));
                }
            });
        }

        function updateIndexInString(str, index) {
            
            return str.replace(/\[\d+\]/, '[' + index + ']');
        }





        


        function resetTierFields(tier) {
            const inputs = tier.querySelectorAll('input');

            inputs.forEach(input => {
                if(input.type == 'text'){
                    input.value = 'NEW TIER';
                } else if(input.type == 'hidden'){
                    input.value = 'yellow';
                }
            });

            
        }

        



    </script>
    

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

            
        });
    </script>
    
</body>
</html>