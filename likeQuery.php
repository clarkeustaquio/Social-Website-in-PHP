<?php
    session_start();
    if(!isset($_SESSION['email'])){
        header("Location: index.php");
    }

    include("connection.php");
    $email = $_GET['email'];
    $id = $_GET['id'];
    $emailBy = $_GET['emailBy'];
    $urlImage = "";
    $name = "";

    $previousPage = $_SERVER['HTTP_REFERER'];

    $another = "select urlImage, profileName from accounts where email = '$email'";
			if($accResult = mysqli_query($connection, $another)){
				if(mysqli_num_rows($accResult) >= 0){
					while($accRow = mysqli_fetch_array($accResult)){
                        $urlImage .= $accRow['urlImage'];
                        $name .= $accRow['profileName'];
					}
					mysqli_free_result($accResult);
				}
			}

    echo $urlImage;
    echo $name;
    $sql = "insert into likes(email, id, emailBy, urlImage, profileName) values('$email', '$id', '$emailBy', '$urlImage', '$name')";
    $check = "select * from likes where email = '$email' and id = '$id'";

    $exist = $connection -> query($check);

    if($exist -> num_rows == 0){
        $result = $connection -> query($sql);
    }else{
        $dislike = "delete from likes where email = '$email' and id = '$id'";
        $delete = $connection -> query($dislike);
    }

    $likes = "select * from likes where id = '$id'";
    $res = $connection -> query($likes);
    $numOfRows = mysqli_num_rows($res);
    $count = "update feed set likes = '$numOfRows' where id = '$id'";
    $toUpdate = $connection -> query($count);    

    header('Location:' . $previousPage);
    
?>