<?php
	session_start();
    if(!isset($_SESSION['email'])){
        header("Location: index.php");
    }
    
    include("connection.php");

    if(isset($_POST['query'])){
        $inpText = $_POST['query'];
        $query = "select firstName, lastName, email from accounts where firstName like '%$inpText%' or lastName like '%$inpText%' or email like '%$inpText%'";

        $result = $connection->query($query);

        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                echo "<a class = 'list-group-item list-group-item-action border-1'>".$row['firstName'] . " " . $row['lastName']."</a>";
            }
        }
        else{
            echo "<p class = 'list-group-item border-1'> No Record</p>";
        }
    }
?>