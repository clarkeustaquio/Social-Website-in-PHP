<?php
	session_start();
		if(!isset($_SESSION['email'])){
			header("Location: index.php");
		}

        require_once("connection.php");

        $email = $_GET['email'];
        $whoAdd = $_GET['whoAdd'];
        $status = $_GET['status'];
        $previousPage = $_SERVER['HTTP_REFERER'];
        if($status == "yes"){
            $sql = "update friends set status ='$status' where email = '$email' and whoAdd = '$whoAdd'";
        }else{
            $sql = "delete from friends where email = '$email' and whoAdd = '$whoAdd'";
        }
        $result = $connection -> query($sql);

        header('Location:' . $previousPage);
?>