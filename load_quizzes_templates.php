<?php

$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');
session_start();

$sql = "SELECT * FROM quizzes JOIN users ON quizzes.author = users.id_user WHERE users.id_user = $_SESSION[id]";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        ?>
        <div class="quiz" id="quiz-<?php echo $row['id_quiz'];?>">

            <div class="cover-container">
                <a href="viewquiz.php?id=<?php echo $row['id_quiz']?>"> 
                    <img class="quiz-card-image" src="coverimgs/<?php echo $row['cover']?>" alt="">
                </a>
            </div>

            <div class="quiz-info">
                <a href="viewquiz.php?id=<?php echo $row['id_quiz']?>">
                    <p class="quiz-card-title"><?php echo $row['quiz_name']?></p>
                </a>

                <div class="author-info">
                    <img src="profileimgs/<?php echo $row['image'];?>" alt="">
                    <p class="quiz-author"><?php echo $row['username']?></p>
                </div>
                
            </div> 
            <div class="quiz-btns">
                <button class="quiz-delete-btn" onclick="deleteQuiz(<?php echo $row['id_quiz']?>)">Delete</button>
                <button class="quiz-view-btn" onclick="viewQuiz('viewquiz.php?id=<?php echo $row['id_quiz'];?>')">View</button>
            </div> 
        </div>
    <?php } 
    
} else {
    echo "Žádné záznamy nenalezeny.";
}

?>