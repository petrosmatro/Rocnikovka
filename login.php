<?php
$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');
session_start();
if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']);
    

    $select = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    $select = "SELECT * FROM users WHERE password = '$pass'";
    $passres = mysqli_query($conn, $select);
    $pass_count = mysqli_num_rows($passres);

    if(mysqli_num_rows($result) == 0){
        $error = "This account does not exist";
    }
    else if($pass_count == 0){
        $error2 = "Wrong password!!";
    }else{
        $row = mysqli_fetch_array($result);
        $_SESSION['id'] = $row['id_user'];
        $_SESSION['username'] = $row['username'];
        header('location:main.php');
    }
}






?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="" method="post">
            <label for="username">E-mail:</label>
            <input type="text" id="email" name="email" placeholder="Enter your E-mail">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password">

            <button type="submit" name="submit">Login</button>
            <?php
                if(isset($error)){
                    echo '<p class="error-msg"><strong>'.$error.'</strong></p>';
                }
            
                if(isset($error2)){
                    echo '<p class="error-msg"><strong>'.$error2.'</strong></p>';
                }
            ?>

            <p>Don't you have an account?</p><a href="register.php">Register now</a>
            
        </form>
    </div>
</body>
</html>