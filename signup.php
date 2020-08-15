<?php
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
	$profileName = $firstName . " " . $lastName;
		
	if($password != $confirmPassword){
		echo "<script>alert('Password not match')</script>";
	}else{
		//size
		//type
		//name
		/*$file_size = $_FILES['profile']['size'];
//				echo "<script>alert($file_size);</script>";

		if($file_size > 200000){

				//something later
		}

		$file_tmp = $_FILES['profile']['tmp_name'];
		$target_dir = "saveHere/";
		$url = $target_dir . basename($_FILES["profile"]["name"]);
		move_uploaded_file($file_tmp, $url);*/
		if($gender == "Male"){
			$url = "images/defaultMale.png";
		}else{
			$url = "images/defaultFemale.png";
		}
		$cover = "images/defaultCover.jfif";

		$sql = "insert into accounts(firstName, lastName, email, password, birthday, gender, phoneNumber, urlImage, coverPhoto, profileName) 
		values('$firstName', '$lastName', '$email', '$password', '$birthday', '$gender', $phoneNumber, '$url', '$cover', '$profileName')";

		
		$check = "select * from accounts where email = '$email'";
		$exist = $connection -> query($check);
		
			if($exist -> num_rows == 0){
				$result = $connection->query($sql);
				if($result == true){
					echo "<script>alert('Account Created')</script>";
				}else{
					echo $connection -> error;
				}
			}else{
				echo "<script>alert('Account Existed')</script>";
			}
		}
	}
?>

<html>
	<head>
		<title>Sign-up</title>
		<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
		<link rel = "stylesheet" type = "text/css" href = "signup_login.css">
	</head>
	
	<body>
		<form method = "POST" align = "center">
			<div id = "box">
				<h2>Create Account</h2>
				<div>
					<input name = "firstName" type = "text" placeholder = "First Name" required>
					<input name = "lastName" type = "text" placeholder = "Last Name" required>
				</div>
				
				<input style = "width: 93.5%" name = "email" type = "email" placeholder = "Your Email" required>
				<input style = "width: 93.5%" name = "password" type = "password" placeholder = "New Password" required>
				<input style = "width: 93.5%" name = "confirmPassword" type = "password" placeholder = "Confirm Password" required>
				<input style = "width: 93.5%" name = "birthday" type = "date" required>

				<input style = "width: 93.5%" name = "phoneNumber" type = "number" placeholder= "Phone Number" required>

				<input name = "gender" type = "radio" value = "Male" required> Male	
				<input name = "gender" type = "radio" value = "Female" required> Female
				
				<input style = "margin-top: 3%" class = "button" name = "btnSubmit" type = "submit" value = "SIGN UP">

					<p>Have already an account?</p>
					<a href = "index.php"  style = "color: black; font-weight: bold">Login here</a>
			</div>
		</form>
	</body>
</html>

