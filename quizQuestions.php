<?php
    $conn = mysqli_connect('localhost', 'root', '', 'mytierlist');
    session_start();

    if(isset($_POST['upload'])){
        $questions = $_POST['questions'];

        $quiz_id = $_SESSION['quiz_id'];
        foreach($questions as $questionIndex => $question){
            $questionText = $question['question'];

            $src = $_FILES['questions']['tmp_name'][$questionIndex]['questionImage'];
            $imageName = uniqid() . $_FILES['questions']['name'][$questionIndex]['questionImage'];
            $target = "questionimgs/" . $imageName;

            move_uploaded_file($src, $target);

            $query = "INSERT INTO questions(question_text, question_image, question_no, id_quiz) VALUES ('$questionText', '$imageName', $questionIndex + 1, $quiz_id)";
            mysqli_query($conn, $query);

            $questionId = $conn -> insert_id;

            if(isset($question['optionA'])){
                $answerText = $question['optionA'];
                if(isset($question['answerCheckA'])){
                    $query = "INSERT INTO answers(answer_text, is_true, id_question) VALUES ('$answerText', 1, $questionId)";
                    mysqli_query($conn, $query);
                } else{
                    $query = "INSERT INTO answers(answer_text, is_true, id_question) VALUES ('$answerText', 0, $questionId)";
                    mysqli_query($conn, $query);
                }
            }
            
            if(isset($question['optionB'])){
                $answerText = $question['optionB'];
                if(isset($question['answerCheckB'])){
                    $query = "INSERT INTO answers(answer_text, is_true, id_question) VALUES ('$answerText', 1, $questionId)";
                    mysqli_query($conn, $query);
                } else{
                    $query = "INSERT INTO answers(answer_text, is_true, id_question) VALUES ('$answerText', 0, $questionId)";
                    mysqli_query($conn, $query);
                }
            }
            
            if(isset($question['optionC'])){
                $answerText = $question['optionC'];
                if(isset($question['answerCheckC'])){
                    $query = "INSERT INTO answers(answer_text, is_true, id_question) VALUES ('$answerText', 1, $questionId)";
                    mysqli_query($conn, $query);
                } else{
                    $query = "INSERT INTO answers(answer_text, is_true, id_question) VALUES ('$answerText', 0, $questionId)";
                    mysqli_query($conn, $query);
                }
            }
            
            if(isset($question['optionD'])){
                $answerText = $question['optionD'];
                if(isset($question['answerCheckD'])){
                    $query = "INSERT INTO answers(answer_text, is_true, id_question) VALUES ('$answerText', 1, $questionId)";
                    mysqli_query($conn, $query);
                } else{
                    $query = "INSERT INTO answers(answer_text, is_true, id_question) VALUES ('$answerText', 0, $questionId)";
                    mysqli_query($conn, $query);
                }
            } 
        }
        header("Location:quizzes.php");
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

        .question {
            width: 100%;
            margin-top: 30px;
        }

        .delete-btn{
            background-color: red;
            color: white;
            border-radius: 20px;
            border: none;
        }

        .question-text {
            width: 100%;
            font-size: 20px;
            margin-bottom: 20px;
            display: flex;
            flex-direction: row;
            justify-content: center;
            gap: 200px;
        }

        .file-upload {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 350px;
            border: 5px solid black;
            border-radius: 10px;
            overflow: hidden;
            flex-direction: column;
        }

        body.dark-mode .file-upload{
            border-color: #545454;
        }

        .answers {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            justify-content: center;
            align-items: center;
        }

        .answer {
            display: flex;
            flex-direction: row;
            border: 2px solid;
            
            border-radius: 5px;
            padding: 5px;
            margin: 10px;
            width: 40%;
        }

        .answer span{
            margin-left: 5px;
        }

        .answer span input{
            border: none;
            background-color: #e0dede;
            border-radius: 5px;
        }

        .answer input[type="radio"]{
            margin-left: 60px;
        }

        .answer-word{
            color: white;
            padding: 2px;
            border-radius: 2px;
        }

        .file-upload .image-preview{
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            z-index: 1;
        }

        .file-upload input{
            position: relative;
        }
        
        .btns-container .add-btn{
            background-color: white;
            color: #1e6696;
            border: 1px solid #1e6696;
            padding: 8px;
            border-radius: 20px;
        }

        body.dark-mode .btns-container button{
            background-color: #1a1a1a;
        }

        body.dark-mode .add-btn:hover{
            background-color: #1e6696;
            color: #1a1a1a;
        }

        body.dark-mode .upload-btn:hover{
            background-color: #e622c5;
            color: #1a1a1a;
        }

        .add-btn:hover{
            color: white;
            background-color: #1e6696;
        }

        .btns-container .upload-btn{
            background-color: white;
            color: #e622c5;
            border: 1px solid #e622c5;
            padding: 8px;
            border-radius: 20px;
        }

        .upload-btn:hover{
            color: white;
            background-color: #e622c5;
        }

        .btns-container{
            display: flex;
            align-items: center;
            justify-content: center;
            
            
            gap: 20px;
        }
        
        .question-text input{
            background-color: #e0dede;
            border: none;
            border-radius: 10px;
            padding: 10px;
            width: 50%;
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

        input[type="file"] {
            padding: 10px;
            background-color: #f7f7f7;
            border: 1px dashed black;
            border-radius: 5px;
            cursor: pointer;
        }

        body.dark-mode input[type="file"] {
            background-color: #545454;
            border-color: #a3a3a3;
        }

        input[type="file"]:hover {
            background-color: #e7e7e7;
        }

        body.dark-mode .navbar{
            background-color: #1a1a1a;
        }

        body.dark-mode .sub-menu{
            background-color:  #1a1a1a;
        }

        .questions-container{
            background-color: white;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            width: 50%;
            margin: 50px auto;
        }

        body.dark-mode .questions-container{
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

    <div class="questions-container">
        <form action="" method="post" id="quizForm" enctype="multipart/form-data">
            <div class="question" id="question">
                <div class="question-text">
                    <input type="text" name="questions[0][question]" placeholder="Question:" required>
                    <button type="button" style="visibility: hidden;" class="delete-btn">Delete question</button>
                </div>

                <div class="file-upload" id="file-upload">
                    <input type="file" id="questionImage" name="questions[0][questionImage]" accept=".jpg, .jpeg, .png" required>
                </div>

                <div class="answers">
                    <div class="answer" style="border-color: red;">
                        <div class="answer-word" style="background-color: red;">A</div>
                        <span>
                            <input name="questions[0][optionA]" type="text" placeholder="Option A..." required>
                        </span>
                        <input type="checkbox" name="questions[0][answerCheckA]" id="">
                    </div>
                    <div class="answer" style="border-color: blue;"><div class="answer-word" style="background-color: blue;">B</div><span><input name="questions[0][optionB]" type="text" placeholder="Option B..." required></span><input type="checkbox" name="questions[0][answerCheckB]" id=""></div>
                    <div class="answer" style="border-color: #f2e01b;"><div class="answer-word" style="background-color: #f2e01b;">C</div><span><input name="questions[0][optionC]" type="text" placeholder="Option C..." required></span><input type="checkbox" name="questions[0][answerCheckC]" id=""></div>
                    <div class="answer" style="border-color: green;"><div class="answer-word" style="background-color: green">D</div><span><input name="questions[0][optionD]" type="text" placeholder="Option D..." required></span><input type="checkbox" name="questions[0][answerCheckD]" id=""></div>
                </div>
                
            </div>

            <div class="btns-container">
                    <button name="upload" class="upload-btn">Upload Quiz</button>
                    <button type="button" class="add-btn">Add Question</button>
            </div>
        </form>
    </div>
    


    <script>
        let subMenu = document.getElementById('subMenu');
        function toggleMenu(){
            subMenu.classList.toggle('open-menu');
        }

        

        quizForm.addEventListener('change', function(event) {
        if (event.target && event.target.matches('input[type="file"]')) {
            var fileInput = event.target;
            var file = fileInput.files[0]; // získání prvního vybraného souboru
            var reader = new FileReader();

            reader.onload = function(event) {
                var imageUrl = event.target.result; // získání URL nahraného obrázku
                var imageElement = document.createElement('img'); // vytvoření nového <img> elementu
                imageElement.src = imageUrl; // nastavení src atributu pro zobrazení obrázku
                imageElement.classList.add('image-preview');
                
                fileInput.parentNode.appendChild(imageElement); // přidání obrázku do kontejneru

            };

            reader.readAsDataURL(file); // načtení nahraného souboru jako data URL
        }
    });

        document.addEventListener('DOMContentLoaded', function () {
            const addButton = document.querySelector('.add-btn');
            const quizForm = document.getElementById('quizForm');
            let questionIndex = document.querySelectorAll('.question').length - 1;

            addButton.addEventListener('click', function () {
                const questionContainer = document.querySelector('.question').cloneNode(true);

                const fileUpload = questionContainer.querySelector('.file-upload');

                const images = fileUpload.querySelectorAll('img');
                images.forEach(img => img.remove());

                

                const deleteBtn = questionContainer.querySelector('.delete-btn');
                deleteBtn.style.visibility = 'visible';
                resetQuestionFields(questionContainer);

                questionIndex++;

                updateAttributeIndexes(questionContainer, questionIndex);

                quizForm.insertBefore(questionContainer, addButton.parentNode);
            });

            quizForm.addEventListener('click', function (event) {
                if (event.target && event.target.classList.contains('delete-btn')) {
                    event.preventDefault();
                    deleteQuestion(event.target);
                }
            });

            function deleteQuestion(button){
                var container = button.parentElement;
                var question = container.parentElement;

                question.remove();
                questionIndex--;
                reindexQuestions();
            }
        });

        function reindexQuestions() {
            const questions = document.querySelectorAll('.question');
            questions.forEach((question, index) => {
                updateAttributeIndexes(question, index);
            });
        }


        function resetQuestionFields(questionContainer) {
            const inputs = questionContainer.querySelectorAll('input');

            inputs.forEach(input => {
                if(input.type == 'file'){
                    const newFileInput = input.cloneNode();
                    newFileInput.value = '';
                    input.parentNode.replaceChild(newFileInput, input);
                } else if(input.type == 'checkbox'){
                    input.checked = false;
                } else{
                    input.value = '';
                }
            });

            
        }


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
            // Nahrazení [0] za nový index v řetězci
            return str.replace(/\[\d+\]/, '[' + index + ']');
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