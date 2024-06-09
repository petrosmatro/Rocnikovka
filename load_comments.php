<style>
    .comment-container {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 600px;
    margin: 10px 0;
}

.btn-container{
    width: 100%;
    display: flex;
    justify-content: flex-end;
}

.btn-container button{
    background-color: red;
    border: none;
    border-radius: 20px;
    width: 80px;
    height: 30px;
    color: white;
}



.comment-header {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.profile-pic {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 15px;
    object-fit: cover;
}

.comment-author-info {
    display: flex;
    flex-direction: column;
}

.comment-author {
    font-weight: bold;
    color: #333;
}

.comment-date {
    color: #888;
    font-size: 0.9em;
}

.comment-body {
    margin-bottom: 10px;
}

.comment-body p {
    margin: 0;
    line-height: 1.5;
}

</style>


<?php
$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');
session_start();

$id_tier = $_GET['id'];

$sql = "SELECT * FROM tier_comments JOIN users ON tier_comments.com_author = users.id_user WHERE id_tier = $id_tier ORDER BY id_com DESC";
$result = $conn->query($sql);



if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        ?>
        <div class="comment-container" id="comment-<?php echo $row['id_com'];?>">
            <div class="comment-header">
                <img src="profileimgs/<?php echo $row['image'];?>" alt="Profilový obrázek" class="profile-pic">
                <div class="comment-author-info">
                    <span class="comment-author"><?php echo $row['username'];?></span>
                    <span class="comment-date"><?php echo $row['add_date'];?></span>
                </div>
            </div>
            <div class="comment-body">
                <p><?php echo $row['content'];?></p>
            </div>

            <?php if($_SESSION['username'] == $row['username'] || $_SESSION['user_type'] == 'admin'){?>
                <div class="btn-container">
                    <button onclick="deleteComment(<?php echo $row['id_com'];?>)">Delete</button>
                </div>
            <?php }?>
        </div>
        <?php
    }
} else {
    echo "Žádné komentáře.";
}


?>
