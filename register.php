<?php
$conn = mysqli_connect('localhost', 'root', '', 'mytierlist');

if(isset($_POST['submit'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);



    $select = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $select);
    $email_count = mysqli_num_rows($result);

    $select = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $select);
    $user_count = mysqli_num_rows($result);


    if($email_count == 0 && $user_count == 0 && $pass == $cpass){
        $insert = "INSERT INTO users(username, email, password)
            VALUES('$username', '$email', '$pass')";

            mysqli_query($conn, $insert);
            header('location:main.php');
    }else{
        if($email_count > 0){
            $error1 = 'This email is already in use!';
        }
        if($user_count > 0){
            $error2 = 'This username is already taken!';
        }
        if($pass != $cpass){
            $error3 = 'Passwords are not matching!';
        }

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
            height: 100vh;
        }

        .register-container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            margin-top: 50px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            background-color: white;
        }

        .register-container h2 {
            text-align: center;
        }

        .register-container input[type="text"],
        .register-container input[type="email"],
        .register-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            border-radius: 5px;
        }

        .register-container button {
            background-color: #5291f7;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 20px;
        }
        .register-container button:hover {
            opacity: 0.8;
        }

        .error-msg{
            color: red;
            font-size: small;
            margin-top: -6px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required placeholder="Enter your username">

            <?php
                if(isset($error2)){ 
                    echo '<p class="error-msg">'.$error2.'</p>';
                }   
            ?>

            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="Enter your email">

            <?php
                if(isset($error1)){ 
                    echo '<p class="error-msg">'.$error1.'</p>';
                }   
            ?>

            
        
            <label for="password">Password (8 characters minimum):</label>
            <input type="password" id="password" name="password" minlength="8" required placeholder="Enter your password">
        
            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="cpassword" name="cpassword" required placeholder="Confirm your password">
            <?php
                if(isset($error3)){ 
                    echo '<p class="error-msg">'.$error3.'</p>';
                }   
            ?>
        
            <button type="submit" name="submit">Register</button>
            <p>Do you have an account?</p><a href="login.php">Login now!</a>

        </form>
    </div>
</body>
</html>