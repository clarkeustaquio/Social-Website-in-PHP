<?php
	session_start();
    if(!isset($_SESSION['email'])){
        header("Location: index.php");
    }
    include("connection.php");


                if(isset($_POST['submit'])){
                    $data = $_POST['Search'];
                    if($data != ""){
                        echo $data;
                        $sql = "select email from accounts where profileName = '$data'";
                        $result = $connection ->query($sql);
                        $row = $result->fetch_assoc();

                        if($row['email'] != $_SESSION['email']){
                            header('Location:' . "searchedProfile.php?email=" . $row['email']);
                        }else{
                            header('Location:' . "profile.php?email=" . $row['email']);
                        }
                    }
                }                
?>