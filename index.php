<?php
    require_once("connection.php");
        
    if(isset($_POST["btnSubmit"])){
        $email =  $_POST["email"];
        $password = $_POST["password"];
        
        $sql = "select * from accounts where email = '$email' and password = '$password'";
        $result = $connection -> query($sql);
        $get = "home.php?email=" . $email;
        
            if($result -> num_rows == 0){
                echo "<script>alert('Invalid Account')</script>";
            }else{

                session_start();
                $_SESSION['email'] = $email;
                header('Location:'. $get);
            }
        $connection -> close();
    }
?>

<html>
    <head>
        <title>Login</title>
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
        <link rel = "stylesheet" type = "text/css" href = "signup_login.css">
    </head>
    
    <body>
    <form method = "POST" align = "center">
			<div id = "box">
				<h2>Login Account</h2>
				
				<input style = "width: 93.5%" name = "email" type = "email" placeholder = "Email" required>
				<input style = "width: 93.5%" name = "password" type = "password" placeholder = "Password" required>

				<input style = "margin-bottom: 30" class = "button" name = "btnSubmit" type = "submit" value = "SIGN IN">

				<a href = "signup.php"  style = "color: black; font-weight: bold">Create an Account?</a>
			</div>
		</form>
    </body>
</html>