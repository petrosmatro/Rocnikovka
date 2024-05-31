<?php
$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');
session_start();


$question_no = "";
$question = "";
$ans = "";


$queno = $_GET['questionno'];

if(isset($_SESSION["answer"][$queno])){
    $ans = $_SESSION["answer"][$queno];
}

$res = mysqli_query($conn, "SELECT * FROM questions RIGHT JOIN answers USING (id_question) WHERE id_quiz = $_SESSION[current_quiz_id] && question_no = $_GET[questionno]");
$count = mysqli_num_rows($res);

if($count == 0){
    echo "over";
}
else{
    while($row = mysqli_fetch_array($res)){
        $question_no = $row['question_no'];
        $question = $row['question_text'];
        $questionImg = $row['question_image'];

        
        
    }



?>

<style>
    .question{
        width: 50%;
        margin: 50px auto;
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
        width: 40%;
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


</style>

<div class="question" id="question">
    <div class="question-text"><h2><?php echo $question;?></h2></div>

    <div class="file-upload" id="file-upload">
        <img src="questionimgs/<?php echo $questionImg;?>" alt="">
    </div>

    <div class="answers">
        <?php $word = 'A'; $index = 1; foreach($res as $r){?>
            <div onclick="toggleCheckbox();" class="answer-item-<?php echo $index?>"><div class="answer-word"><?php echo $word;?></div><input type="hidden" value="<?php echo $r['id_ans']?>"><span><?php echo $r['answer_text'];?><input type="checkbox" value="<?php echo $r['answer_text']?>" onclick="checkboxClick(this.value, <?php echo $question_no;?>);" <?php if($ans == $r['answer_text']){ echo "checked";} ?>></span></div>
        <?php $index++; $word = chr(ord($word) + 1); }?>
    </div>
            
</div>




<?php
}
?>
