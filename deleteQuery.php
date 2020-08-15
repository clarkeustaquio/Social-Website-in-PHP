<?php
	session_start();
		if(!isset($_SESSION['email'])){
			header("Location: index.php");
		}

        require_once("connection.php");
	
	
    $id = $_GET['id'];
    $email = $_GET['email'];

    $sql = "delete from accounts where id = $id";
    $post = "delete from feed where email = '$email'";
	if($connection -> query($post) == true){
        if($connection -> query($sql) == true){
            header('Location: index.php');
        }else{
            echo $connection -> error;
        }	
    }else{
        echo $connection -> error;
    }
    

?>