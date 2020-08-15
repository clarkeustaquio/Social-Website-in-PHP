<?php
	session_start();
    if(!isset($_SESSION['email'])){
        header("Location: index.php");
    }
    require_once("connection.php");

if(isset($_POST["btnSubmit"])){
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $birthday = $_POST["birthday"];
    $gender = $_POST["gender"];
    $phoneNumber = $_POST["phoneNumber"];
    $id = $_GET['id'];	
    $getEmail = $_GET['email'];
	$profileName = $firstName . " " . $lastName;
    $urlImage = $_GET['urlImage'];

    if($password != $confirmPassword){
        echo "<script>alert('Password not match')</script>";
    }else{
        $file_tmp = $_FILES['profile']['tmp_name'];
        $target_dir = "editedImages/";
        $url = $target_dir . basename($_FILES["profile"]["name"]);

        move_uploaded_file($file_tmp, $url);


        if($url == "editedImages/"){
            $sql = "update accounts set firstName = '$firstName', lastName = '$lastName', email = '$email', password = '$password', birthday = '$birthday', gender = '$gender', phoneNumber = $phoneNumber, urlImage = '$urlImage', profileName = '$profileName' where id = $id"; 
            $update = "update feed set name = '$firstName', urlImage = '$urlImage', email = '$email' where email = '$getEmail'";
            $notify = "update likes set urlImage = '$urlImage', profileName = '$profileName' where email = '$getEmail'";
            $likeEmail = "update likes set emailBy = '$email' where emailBy = '$getEmail'";
            $likes = "update likes set email = '$email', profileName = '$profileName' where email = '$getEmail'";
            $messages = "update messages set whoSend = '$email', sessionImage = '$urlImage' where whoSend = '$getEmail'";
            $set = "update messages set toWhom = '$email', urlImage = '$urlImage' where toWhom = '$getEmail'";
            $untilNot = "update untilNot set toWhom = '$email', profileName = '$profileName', sessionImage = '$urlImage' where toWhom = '$getEmail'";
            $untilNot2 = "update untilNot set whoSend = '$email', sessionProfile = '$profileName' where whoSend = '$getEmail'";
            $comments = "update comments set email = '$email', profileName = '$profileName', urlImage = '$urlImage' where email = '$getEmail'";
            $chat = "update whoImessage set whoSend = '$email', sessionImage = '$urlImage' where whoSend = '$getEmail'";
            $chat2 = "update whoImessage set toWhom = '$email', urlImage = '$urlImage', profileName = '$profileName' where toWhom = '$getEmail'";
            $friend = "update friends set email = '$email', urlImage = '$urlImage', profileName = '$profileName' where email = '$getEmail'";
            $friend2 = "update friends set whoAdd = '$email', sessionName = '$profileName', sessionImage = '$urlImage' where whoAdd = '$getEmail'"; 
            if($_SESSION['email']){
                $_SESSION['email'] = $email;
            }else{
                $_SESSION['email'] = $getEmail;
            }

        }else{
            $sql = "update accounts set firstName = '$firstName', lastName = '$lastName', email = '$email', password = '$password', birthday = '$birthday', gender = '$gender', phoneNumber = $phoneNumber, urlImage = '$url', profileName = '$profileName' where id = $id"; 
            $update = "update feed set name = '$firstName', urlImage = '$url', email = '$email' where email = '$getEmail'";
            $notify = "update likes set urlImage = '$url', profileName = '$profileName', where email = '$getEmail'";
            $likeEmail = "update likes set emailBy = '$email' where emailBy = '$getEmail'";
            $likes = "update likes set email = '$email', profileName = '$profileName' where email = '$getEmail'";
            $messages = "update messages set whoSend = '$email', sessionImage = '$url' where whoSend = '$getEmail'";
            $set = "update messages set toWhom = '$email', urlImage = '$url' where toWhom = '$getEmail'";
            $untilNot = "update untilNot set toWhom = '$email', profileName = '$profileName', sessionImage = '$url' where toWhom = '$getEmail'";
            $untilNot2 = "update untilNot set whoSend = '$email', sessionProfile = '$profileName' where whoSend = '$getEmail'";
            $comments = "update comments set email = '$email', profileName = '$profileName', urlImage = '$url' where email = '$getEmail'";
            $chat = "update whoImessage set whoSend = '$email', sessionImage = '$url' where whoSend = '$getEmail'";
            $chat2 = "update whoImessage set toWhom = '$email', urlImage = '$url', profileName = '$profileName' where toWhom = '$getEmail'";
            $friend = "update friends set email = '$email', urlImage = '$url', profileName = '$profileName' where email = '$getEmail'";
            $friend2 = "update friends set whoAdd = '$email', sessionName = '$profileName', sessionImage = '$url' where whoAdd = '$getEmail'";
            if($_SESSION['email']){
                $_SESSION['email'] = $email;
            }else{
                $_SESSION['email'] = $getEmail;
            }

        }
                $res = $connection->query($update);
                $res2 = $connection->query($notify);
                $res3 = $connection->query($likeEmail);
                $res4 = $connection->query($messages);
                $res5 = $connection->query($set);
                $res6 = $connection->query($untilNot);
                $res7 = $connection->query($untilNot2);
                $res8 = $connection->query($comments);
                $res9 = $connection->query($likes);
                $res10 = $connection->query($chat);
                $res11 = $connection->query($chat2);
                $res12 = $connection->query($friend);
                $res13 = $connection->query($friend2);
                

                if($res == true){
                    $result = $connection->query($sql);
                    if($result == true){
                        header('Location: profile.php?email=' . $email);
                    }else{
                        echo $connection -> error;
                    }
                }else{
                    echo $connection -> error;
                }
            }
        }
?>

<html>
    <head>
        <title>Edit</title>
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
        <link rel = "stylesheet" type = "text/css" href = "editAccount.css">
    </head>
    
    <body>
    <form method = "POST" align = "center" enctype = "multipart/form-data">
        <div id = "box">
				<h2>Edit Account</h2>
				<div>
					<input value = <?=$_GET['firstName']?> name = "firstName" type = "text" placeholder = "First Name" required>
					<input value = <?=$_GET['lastName']?> name = "lastName" type = "text" placeholder = "Last Name" required>
				</div>
				
				<input value = <?=$_GET['email']?> style = "width: 93.5%" name = "email" type = "email" placeholder = "Your Email" required>
				<input style = "width: 93.5%" name = "password" type = "password" placeholder = "New Password" required>
				<input style = "width: 93.5%" name = "confirmPassword" type = "password" placeholder = "Confirm Password" required>
				<input value = <?=$_GET['birthday']?> style = "width: 93.5%" name = "birthday" type = "date" required>

				<input value = <?=$_GET['phoneNumber']?> style = "width: 93.5%" name = "phoneNumber" type = "number" placeholder= "Phone Number" required>
                    <?php
                        if($_GET['gender'] == "Male"){
                            echo "<input checked name = 'gender' type = 'radio' value = 'Male' required> Male";
                            echo "<input name = 'gender' type = 'radio' value = 'Female' required> Female";
                        }else{
                            echo "<input name = 'gender' type = 'radio' value = 'Male' required> Male";
                            echo "<input checked name = 'gender' type = 'radio' value = 'Female' required> Female";
                        }
                    ?>
                <br>

                <img style = "width:150px; height: 150px;" id ="myImg" src = "image.png"><br>
				<input type = "file" name = "profile" id = "uploadfile"/>

				<input style = "margin-top: 20" class = "button" name = "btnSubmit" type = "submit" value = "Confirm Edit">

                <script src = "JS/jquery.js"></script>
                <script>
                    $(document).ready(function(){
                        $('#uploadfile').change(function(e){
                            if(this.files && this.files[0]){
                                var img = document.querySelector('#myImg');
                                img.src = URL.createObjectURL(this.files[0]);
                            }
                        });
                    });
                </script>

                <a href = "profile.php?email=<?=$_GET['email']?>"  style = "color: black; font-weight: bold">Cancel Edit</a>		
			</div>
		</form>
    </body>
</html>