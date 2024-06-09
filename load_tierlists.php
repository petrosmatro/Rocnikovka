

<?php
// Připojení k databázi
$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');
session_start();

if ($conn->connect_error) {
    die("Připojení selhalo: " . $conn->connect_error);
}

$sql = "SELECT * FROM tierlists JOIN users ON tierlists.autor = users.id_user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        ?>
        <div class="tierlist" id="tierlist-<?php echo $row['id_tier'];?>">
                    
            <a href="viewlist.php?id=<?php echo $row['id_tier']?>">
                <div class="cover-img">
                    <img src="coverimgs/<?php echo $row['cover'];?>">
                </div>
                <div class="tier-name">
                    <div class="author-container">
                        <img src="profileimgs/<?php echo $row['image']?>" alt="">
                    </div>
                    <div class="tier-info">
                        <span class="tier-title"><?php echo $row['nazev'];?></span>
                        <span class="author-username"><?php echo $row['username'];?></span>
                    </div>
                            
                </div>
            </a>

            <div class="tier-btns">
                <button class="delete-btn" onclick="deleteTierlist(<?php echo $row['id_tier']?>)">Delete</button>
                <button class="view-btn" onclick="viewTierlist('viewlist.php?id=<?php echo $row['id_tier'];?>')">View</button>
            </div>
            
                        
        </div>
    <?php } 
    
} else {
    echo "Žádné záznamy nenalezeny.";
}
$conn->close();
?>


