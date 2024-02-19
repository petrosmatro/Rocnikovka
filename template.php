<?php
$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');
session_start();

if(isset($_POST['save'])){
    $tempName = mysqli_real_escape_string($conn, $_POST['tempName']);
    $theme = $_POST['theme'];
    $author = $_SESSION['username'];

    $insert = "INSERT INTO tierlists(nazev, tema, autor) VALUES('$tempName', '$theme', '$author')";
    mysqli_query($conn, $insert);

    $post_id = $conn -> insert_id;
    if (!empty($_FILES["images"]["name"][0])){
        foreach($_FILES["images"]["name"] as $key => $imageName) {
            $uniqueName = uniqid() . "_" . $imageName;
            $imageTmp = $_FILES["images"]["tmp_name"][$key];
            $imageContent = file_get_contents($imageTmp);
    
            $insertImages = "INSERT INTO images(nazev, obrazek, tierlist) VALUES(?, ?, ?)";
            $imagestmt = $conn -> prepare($insertImages);
            $imagestmt -> bind_param("ssi", $uniqueName, $imageContent, $post_id);
            $imagestmt -> execute();
            $imagestmt -> close();
        }
    }
    
    header('location:tierlists.php');
}



?>
<style>
    body{
            margin: 0;
            font-family: Arial, sans-serif;
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





    .template-container{
        margin-top: 10%;
        
        margin-bottom: 20%;
        
        

        
    }

    .items-container{
        display: flex;
        flex-direction: column;
        align-items: center;

    }

    .items-container input[type="text"]{
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
        gap: 10px;
    }

    .image-preview{
        height: 100px;
        width: 100px;
    }



</style>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>

    <ul class="navbar">
        <li>
        <?php 
            if (isset($_SESSION['id'])){
                    if(isset($_SESSION['username'])){
                        $username = $_SESSION['username'];
                        echo "<a href='logout.php'>".$username."</a>";
                    }
                }
                else{
                    echo "<a href='login.php' style='background-color: green;'>LOG IN</a>";
                }
            ?>



        </li>
        <li><a href="myTemplates.php">My Templates</a></li>
        <li><a href="tierlists.php">Tier Lists</a></li>
        <li><a href="main.php">Main Page</a></li>
        <li style="float:left"><img src="logoprostranku.png" alt="" width="150" height="70"></li>
    </ul>


    <div class="template-container">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="items-container" id="screenshot">
                <input type="text" name="tempName" placeholder="Name your template">
                <select name="theme" style="width: 50%; margin-bottom: 15px;">
                    <option value="music">Music</option>
                    <option value="cars">Cars</option>
                    <option value="games">Games</option>
                    <option value="movies">Movies</option>
                    <option value="books">Books</option>
                    <option value="other">Other</option>
                </select>
                <img src="TierList.jpg" alt="" width="768" height="432">

                <input type="file" id="imageInput" name="images[]" multiple onchange="previewImages()" accept="image/*" class="img-button">
                <div class="image-container" id="imageContainer"></div>
            </div>
            <div class="buttons-container">
                <button type="submit" name="save">Upload Template</button>
                
            </div>
        </form>
        <div class="buttons-container">
            <button id="downloadbtn">Download Template</button>
        </div>
        
    </div>

    <script>
        function previewImages() {
            var input = document.getElementById('imageInput');
            var container = document.getElementById('imageContainer');

            for (var i = 0; i < input.files.length; i++) {
                (function (file) {
                    var reader = new FileReader();

                    reader.onloadend = function () {
                        var img = document.createElement('img');
                        img.src = reader.result;
                        img.classList.add('image-preview');

                        img.addEventListener('click', function () {
                            this.remove();
                        });
                        container.appendChild(img);
                    };

                    if (file) {
                        reader.readAsDataURL(file);
                    }
                })(input.files[i]);
            }
        }

        document.getElementById('downloadbtn').addEventListener('click', function(){
            html2canvas(document.getElementById('screenshot')).then(function(canvas) {
        
                var dataUrl = canvas.toDataURL('image/jpeg');
                
                var link = document.createElement('a');
                link.href = dataUrl;
                link.download = 'template.jpg';
                
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });
        });

        



    </script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    
</body>
</html>