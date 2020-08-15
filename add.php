<?php
	session_start();
    if(!isset($_SESSION['email'])){
        header("Location: index.php");
    }
    session_start();

        if(!isset($_SESSION['email'])){
            header("Location: index.php");
        }
        
        include("connection.php");

        $email = $_GET['email'];
        $urlImage = $_GET['urlImage'];
        $profileName = $_GET['profileName'];
        $sessionEmail = $_SESSION['email'];
        $sessionName = $_GET['sessionName'];
        $sessionImage = $_GET['sessionImage'];
        $previousPage = $_SERVER['HTTP_REFERER'];

        $sql = "insert into friends(email, urlImage, profileName, whoAdd, status, sessionName, sessionImage) values('$email','$urlImage','$profileName', '$sessionEmail', 'pending', '$sessionName', '$sessionImage')";
        $check = "select * from friends where email = '$email' and whoAdd = '$sessionEmail'";
        $exist = $connection->query($check);

        if($exist -> num_rows == 0){
            $result = $connection->query($sql);
        }

        header('Location:' . $previousPage);
?>