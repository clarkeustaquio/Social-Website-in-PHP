<?php
	session_start();
    if(!isset($_SESSION['email'])){
        header("Location: index.php");
    }
    require_once("connection.php");

            $email = $_GET['email'];
            $session = $_SESSION['email'];
            $sql = "SELECT * FROM accounts WHERE email = '$email'";
            $url = "SELECT urlImage FROM accounts WHERE email = '$session'";
            $print = "";
            $image = "";
            $id = "";
            $picture = "";

			if($result = mysqli_query($connection, $sql)){
				if(mysqli_num_rows($result) >= 0){
					while($row = mysqli_fetch_array($result)){
                        $print .= $row['firstName'];
                        $image .= $row['urlImage'];
                        $id .= $row['id'];
					}
					mysqli_free_result($result);
				}
			}else{
				echo "ERROR: Could not able to execute $sql. " . mysqli_error($connection); 
            }

            if($res = mysqli_query($connection, $url)){
                if(mysqli_num_rows($res) >= 0){
                    while($row2 = mysqli_fetch_array($res)){
                        $picture .= $row2['urlImage'];
                    }
                    mysqli_free_result($res);
                }
            }else{
                echo "ERROR: Could not able to execute $url. " . mysqli_error($connection); 
            }

                $get = "chat.php?email=" . $_GET['email'] . "&urlImage=" . $image ."&emailBy=" . $_SESSION['email'] . "&mainImage=" . $picture;
                header('Location:' . $get);
?>