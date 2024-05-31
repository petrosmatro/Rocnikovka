<?php
$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');
session_start();

$correct = 0;
$wrong = 0;

if(isset($_SESSION['answer'])){
    for($i = 1; $i <= sizeof($_SESSION['answer']); $i++){
        $answer = "";
        $res = mysqli_query($conn, "SELECT * FROM questions JOIN answers USING (id_question) WHERE id_quiz = $_SESSION[current_quiz_id] && question_no = $i && is_true = 1");
        while($row = mysqli_fetch_array($res)){
            $answer = $row['answer_text'];
        }

        if(isset($_SESSION['answer'][$i])){
            if($answer == $_SESSION['answer'][$i]){
                $correct = $correct + 1;
            }
            else{
                $wrong = $wrong + 1;
            }
        }
        else{
            $wrong = $wrong + 1;
        }
    }

}


$count = 0;
$res = mysqli_query($conn, "SELECT * FROM questions WHERE id_quiz = $_SESSION[current_quiz_id]");
$count = mysqli_num_rows($res);
$wrong = $count - $correct;
$accuracy = 100 / $count * $correct;

if(isset($_SESSION['current_quiz_id'])){
    $delete_sql = "DELETE FROM results WHERE user = $_SESSION[id] && id_quiz = $_SESSION[current_quiz_id]";
    if(mysqli_query($conn, $delete_sql)){
        mysqli_query($conn, "INSERT INTO results (user, total_questions, correct_answers, wrong_answers, accuracy, id_quiz) VALUES ($_SESSION[id], $count, $correct, $wrong, $accuracy, $_SESSION[current_quiz_id])");
    }
    
    
}

if(isset($_GET['player'])){
    $opponentId = $_GET['player'];
    $opponentRes = mysqli_query($conn, "SELECT * FROM results JOIN users ON results.user = users.id_user WHERE user = $opponentId");
    while($row = mysqli_fetch_array($opponentRes)){
        $opponent = $row['username'];
        $opponentAccuracy = $row['accuracy'];
    }
    
    if($accuracy > $opponentAccuracy){
        $winmsg = "THE $opponent HAS BEEN SLAIN";
    }
    elseif($accuracy < $opponentAccuracy){
        $losemsg = "THE $opponent HAS DESTROYED YOU";
    } elseif($accuracy == $opponentAccuracy){
        $draw = "YOU ARE BALLIN THE SAME WAY AS $opponent";
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
        }

        body.dark-mode{
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
        }

        .cards-wrap > div{
            width: 200px;
            height: 300px;
            border: 2px solid gray;
            border-radius: 15px;
            overflow: hidden;
        }
        .cards-wrap{
            margin: 50px auto;
            width: 45%;
            height: 400px;
            display: flex;
            gap: 100px;
            flex-direction: row;
        }

        .text{
            width: 100%;
            height: 25%;
            border-bottom: 2px solid gray;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .number{
            width: 100%;
            height: 75%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .number p{
            font-size: 200px;
        }

        .correct-card .text{
            background-color: lightgreen;
        }

        .wrong-card .text{
            background-color: #ffcccb;
        }

        .circle-meter-container {
  width: 50%;
  margin: 50px auto;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.circle-meter-svg {

}

.circle-meter-background {
  fill: none;
  stroke-width: 8;
}

.circle-meter-progress {
  fill: none;
  stroke: #007bff;
  stroke-width: 8;
  stroke-dasharray: 251; /* Obvod kruhu (2 * Math.PI * r) */
  stroke-dashoffset: 251; /* Počáteční offset odpovídající 60% (začíná na 60%) */
  transition: stroke-dashoffset 1s ease-out;
}

.circle-meter-text {
  font-size: 16px;
  fill: #000;
  font-family: Arial, sans-serif;
  transition: opacity 0.5s ease-in;
  opacity: 0;
}

    .questions{
        width: 50%;
        margin: 50px auto;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .question{
        width: 50%;
    }

    .file-upload {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 200px;
        border: 5px solid black;
        border-radius: 10px;
        overflow: hidden;
    }

    .file-upload img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
    }

    .answers {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        justify-content: center;
        align-items: center;
    }

    .answers > div{
        display: flex;
        flex-direction: row;
        border-radius: 5px;
        padding: 5px;
        margin: 10px;
        width: 30%;
    }

    .answer-word{
        color: white;
        padding: 2px;
        border-radius: 2px;
    }

    .answers span{
        margin-left: 5px;
    }

    .answer-item-1{
        border: 2px solid;
        border-color: red;
    }

    .answer-item-2{
        border: 2px solid;
        border-color: blue;
    }

    .answer-item-3{
        border: 2px solid;
        border-color: #f2e01b;
    }

    .answer-item-4{
        border: 2px solid;
        border-color: green;
    }

    .answer-item-1 .answer-word{
        background-color: red;
    }

    .answer-item-2 .answer-word{
        background-color: blue;
    }

    .answer-item-3 .answer-word{
        background-color: #f2e01b;
    }

    .answer-item-4 .answer-word{
        background-color: green;
    }

    .btn-container{
        width: 100%;
        position: absolute;
        margin-top: -70px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .show-btn{
        padding: 10px;
        border: 1px solid grey;
        border-radius: 30px;
        background-color: transparent;
        transition: background-color 0.3s ease, color 0.3s ease;
        color: grey;
    }

    .show-btn:hover{
        background-color: grey;
        color: white;
    }

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

        .draw-msg{
            width: 40%;
            margin: 50px auto;
            padding: 30px;
            background-color: #0574a1;
            text-align: center;
            border-radius: 10px;
            font-weight: bold;
            color: white;
        }

        .win-msg{
            width: 40%;
            margin: 50px auto;
            padding: 30px;
            background-color: lightgreen;
            text-align: center;
            border-radius: 10px;
            font-weight: bold;
            color: white;
        }

        .lose-msg{
            width: 40%;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffcccb;
            text-align: center;
            border-radius: 10px;
            font-weight: bold;
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


    <?php if(isset($winmsg)){?>
        <div class="win-msg"><?php echo $winmsg; ?></div>
    <?php }?>
    <?php if(isset($losemsg)){?>
        <div class="lose-msg"><?php echo $losemsg; ?></div>
    <?php }?>
    <?php if(isset($draw)){?>
        <div class="draw-msg"><?php echo $draw; ?></div>
    <?php }?>
    <div class="circle-meter-container">
        <div><strong>Accuracy</strong></div>
        <svg class="circle-meter-svg" height="100" width="100">
          <circle class="circle-meter-background" cx="50" cy="50" r="40"></circle>
          <circle class="circle-meter-progress" cx="50" cy="50" r="40"></circle>
          <text class="circle-meter-text" x="50" y="50" text-anchor="middle" dominant-baseline="middle">0%</text>
        </svg>
    </div>
    <div class="cards-wrap">
        <div class="total-card">
            <div class="text">
                <p>Total questions</p>
            </div>
            <div class="number">
                <p><?php echo $count;?></p>
            </div>
        </div>
        <div class="correct-card">
            <div class="text">
                <p>Correct answers</p>
            </div>
            <div class="number">
                <p><?php echo $correct;?></p>
            </div>
        </div>
        <div class="wrong-card">
            <div class="text">
                <p>Wrong answers</p>
            </div>
            <div class="number">
                <p><?php echo $wrong;?></p>
            </div>
        </div>
    </div>
    <div class="btn-container">
        <button class="show-btn" id="showBtn">Wrong Answers</button>
    </div>
    <div class="questions">
        <?php
            for($i = 1; $i <= sizeof($_SESSION['answer']); $i++){
                $answer = "";
                $res = mysqli_query($conn, "SELECT * FROM questions JOIN answers USING (id_question) WHERE id_quiz = $_SESSION[current_quiz_id] && question_no = $i && is_true = 1");

                while($row = mysqli_fetch_array($res)){
                    $answer = $row['answer_text'];
                    $question = $row['question_text'];
                    $image = $row['question_image'];
                }

                if(!isset($_SESSION['answer'][$i]) || $answer != $_SESSION['answer'][$i]){
                    $res = mysqli_query($conn, "SELECT * FROM questions RIGHT JOIN answers USING (id_question) WHERE id_quiz = $_SESSION[current_quiz_id] && question_no = $i")
                    ?>
                    <div class="question">
                        <div class="question-text"><h2><?php echo $question;?></h2></div>

                        <div class="file-upload" id="file-upload">
                            <img src="questionimgs/<?php echo $questionImg;?>" alt="">
                        </div>

                        <div class="answers">
                            <?php $word = 'A'; $index = 1; foreach($res as $r){?>
                                <div onclick="toggleCheckbox();" class="answer-item-<?php echo $index?>"><div class="answer-word"><?php echo $word;?></div><input type="hidden" value="<?php echo $r['id_ans']?>"><span><?php echo $r['answer_text'];?></span><?php if($r['answer_text'] == $_SESSION['answer'][$i]){ echo "<span>Wrong</span>"; } elseif ($r['answer_text'] == $answer){ echo "<span>Right</span>"; }?></div>
                            <?php $index++; $word = chr(ord($word) + 1); }?>
                        </div>

                    </div>
                <?php
                }
                
            }
            ?>
        
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
  const progressCircle = document.querySelector('.circle-meter-progress');
  const textElement = document.querySelector('.circle-meter-text');

  const radius = progressCircle.getAttribute('r');
  const circumference = 2 * Math.PI * radius;

  // Funkce pro aktualizaci kruhového měřiče
  function updateCircle(progress) {
    const percent = Math.min(progress, 100); // Omezíme procenta na maximálně 100

    const dashOffset = circumference - (percent / 100) * circumference;
    progressCircle.style.strokeDashoffset = dashOffset;

    textElement.textContent = `${Math.round(percent)}%`;
    textElement.style.opacity = 1;
  }

  // Animace načítání kruhu
  let currentProgress = 0;
  const targetProgress = <?php echo $accuracy;?>; // Cílové procento

  const animationInterval = setInterval(() => {
    updateCircle(currentProgress);

    if (currentProgress >= targetProgress) {
      clearInterval(animationInterval); // Zastavíme animaci, když dosáhneme cílového procenta
    }

    currentProgress += 1; // Inkrementujeme procenta
  }, 10); // Interval animace (čím menší, tím plynulejší)
});

    document.querySelector('.questions').style.display = 'none';
    let isToggled = false;
    document.getElementById('showBtn').addEventListener('click', function(){
        if(isToggled){
            document.querySelector('.questions').style.display = 'none';
        } else{
            document.querySelector('.questions').style.display = 'flex';
        }

        isToggled = !isToggled;
    });

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