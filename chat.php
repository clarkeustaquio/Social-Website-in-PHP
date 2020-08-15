<?php
	session_start();
		if(!isset($_SESSION['email'])){
			header("Location: index.php");
		}

        require_once("connection.php");


        $email = $_GET['email'];
        $emailBy = $_GET['emailBy'];
        $urlImage = $_GET['urlImage'];
        $sessionImage = $_GET['mainImage'];
        $userName = "";
        $sessionProfile = "";

        $profileName = "select profileName from accounts where email = '$email'";
        if($res = mysqli_query($connection, $profileName)){
            if(mysqli_num_rows($res) >= 0){
                while($row1 = mysqli_fetch_array($res)){
                    $userName .= $row1['profileName'];
                }
                mysqli_free_result($res);
            }
        }

        $sessionName = "select profileName from accounts where email = '$emailBy'";
        if($res2 = mysqli_query($connection, $sessionName)){
            if(mysqli_num_rows($res2) >= 0){
                while($row2 = mysqli_fetch_array($res2)){
                    $sessionProfile .= $row2['profileName'];
                }
                mysqli_free_result($res2);
            }
        }

        if(isset($_POST["btnTweet"])){
            
                global $print, $connection;

                $tweet = $_POST["txtArea"];       
                $get = "chat.php?email=" . $_GET['email'] . "&emailBy=" . $emailBy . "&urlImage=" . $urlImage . "&mainImage=" . $_GET['mainImage'];
                $sql = "insert into messages(theMessage, whoSend, toWhom, urlImage, sessionImage) values('$tweet', '$emailBy', '$email', '$urlImage', '$sessionImage')";
                $result = $connection -> query($sql);

                $whoImessage = "insert into whoImessage(whoSend, toWhom, urlImage, profileName, sessionImage) values('$emailBy', '$email', '$urlImage', '$userName', '$sessionImage')";
                $check = "select * from whoImessage where toWhom = '$email' and whoSend = '$emailBy'";
                $exist = $connection->query($check);

                $untilNot = "insert into untilNot(toWhom, profileName, sessionImage, sessionProfile, whoSend) values('$email', '$userName', '$sessionImage', '$sessionProfile', '$emailBy')";
                $check2 = "select * from untilNot where toWhom = '$email'";
                $execute = $connection->query($check2);

                if($exist -> num_rows == 0){
                    $final = $connection->query($whoImessage);
                }
                if($execute -> num_rows == 0){
                    $final2 = $connection->query($untilNot);
                }
    
                header('Location:' . $get);
        }

        if(isset($_POST['backToMessage'])){
            $back = "messages.php?email=" . $_SESSION['email'];
            header('Location:' . $back);
        }
?>

<html>
    <head>
        <title>Messages</title>

        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
        <link rel = "stylesheet" type = "text/css" href = "sidebar.css">
        <link rel = "stylesheet" type = "text/css" href = "sidebarB.css">
        <link rel = "stylesheet" type = "text/css" href = "chat.css">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   
    </head>
    <body>
            
            <div class = "sidenav">
                    <img src = "images/mysql.png" style = "width: 70px; height: 70px; margin-left: 100; transform: scaleX(-1);">
                    <a href = "home.php?email=<?=$_SESSION['email']?>"><span class = "glyphicon glyphicon-home"> Home</a>
                    <a href ="notification.php?email=<?=$_SESSION['email']?>"><span class="glyphicon glyphicon-bell"> Notifications</a>
                    <a href ="messages.php?email=<?=$_SESSION['email']?>"><span class="glyphicon glyphicon-envelope"> Messages</a>
                    <a href = "friends.php?email=<?=$_SESSION['email']?>"><span class="glyphicon glyphicon-list-alt"> Friends</span></a>
                    <a href ="profile.php?email=<?=$_SESSION['email']?>"><span class="glyphicon glyphicon-user"> Profile</a>
                    <a href ="logout.php"><span class="glyphicon glyphicon-log-out"> Log-out</a>
                <br>


            </div>  
            
            <div class = "sidenavB">
            </div>

        <form method = "POST">
            <div class = "header" id = "myHeader">
                <h3 style = "margin-left: 20;">Chat - </h3>
                <?php
                    $email = $_GET['email'];
                    $getName = "select profileName from accounts where email = '$email'";
                    $name = "";

                    if($result = mysqli_query($connection, $getName)){
                        if(mysqli_num_rows($result) >= 0){
                            while($row = mysqli_fetch_array($result)){
                                $name .= $row['profileName'];
                            }
                            mysqli_free_result($result);
                        }
                    }
                    echo "<h3 style ='margin-left: 100; margin-top: -46; position: absolute'>$name</h3>";
                ?>
                        <button name = "backToMessage" style = "position: absolute; background-color: Transparent; border: none; font-size: 20px; margin-left: 650; margin-top: -45; color: white">
                            <span class="glyphicon glyphicon-circle-arrow-left"></span> Back 
                        </button>
            </div>
            <script>
                window.onscroll = function() {myFunction()};

                var header = document.getElementById("myHeader");
                var sticky = header.offsetTop;

                function myFunction() {
                if (window.pageYOffset > sticky) {
                    header.classList.add("sticky");
                } else {
                    header.classList.remove("sticky");
                    }
                }
            </script>
            <hr style = "color: white; width: 50%;">

            <div id = "chatBox" class ="content">
                        <?php
                            $whoSend = $_SESSION['email'];
                            $toWhom = $_GET['email'];
                            $sql = "select * from messages where whoSend = '$whoSend' AND toWhom = '$toWhom' or whoSend = '$toWhom' and toWhom = '$whoSend'";
                            $result = $connection -> query($sql);

                            while($row = $result -> fetch_array()){
                        ?>
                            <div>
                                <?php
                                    if($_SESSION['email']){
                                ?>
                                    <img id = "imgIconChat" src="<?=$row['sessionImage']?>">
                                <?php
                                    }else{
                                ?>
                                    <img id = "imgIconChat" src="<?=$rowT['urlImage']?>">
                                <?php
                                    }
                                ?>
                                
                                <div style= "margin-left: 65;margin-top: -55;">
                                    <p style='color: white; display: inline; white-space: initial; word-wrap: break-words'><?=$row['theMessage']?><p>
                                </div>           
                            </div>
                        <?php
                            }
                        ?>
                    
            </div>
        
            <hr style = "color: white; width: 50%; bottom: 55; position: fixed; margin-left: 380">
            <div class = "lowerSend">
                    <textarea style = "position: absolute; display: inline; margin-left: 200; border-color: #1DA1F2; border-radius: 50px; background-color: Transparent; color: white" name = "txtArea" rows="2" cols="80" placeholder = " What's happening?"></textarea>
                    <input style = "position: absolute; margin-left: 800; margin-top: 5" name = "btnTweet" class="btn btn-primary" type ="submit" value = "Send">
            </div>
        </form>
    </body>
    <script type = "text/javascript">
        $(document).ready(function(){
        $("#search").keyup(function(){
            var searchText = $(this).val();
            if(searchText != ''){
                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: {query: searchText},
                    success: function(response){
                        $("#show-list").html(response);
                    }
                });
            }
            else{
                $("#show-list").html('');
            }
        });
        $(document).on('click','a', function(){
            $("#search").val($(this).text());
            $("#show-list").html('');
        });
    });
    </script>
</html>