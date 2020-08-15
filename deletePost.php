<?php
	session_start();
    if(!isset($_SESSION['email'])){
        header("Location: index.php");
    }

    require_once("connection.php");
    $id = $_GET['id'];
    $previousPage = $_SERVER['HTTP_REFERER'];

    $sql = "delete from feed where id = '$id'";
    $result = $connection -> query($sql);

    $query = "delete from likes where id = '$id'";
    $res = $connection -> query($query);

    header('Location:'. $previousPage); 
?>