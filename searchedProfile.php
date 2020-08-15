<?php
	session_start();
    if(!isset($_SESSION['email'])){
        header("Location: index.php");
    }
    require_once("connection.php");

            $email = $_GET['email'];
            $session = $_SESSION['email'];
            $sql = "SELECT * FROM accounts WHERE email = '$email'";
            $url = "SELECT * FROM accounts WHERE email = '$session'";
            $print = "";
            $image = "";
            $id = "";
            $picture = "";
            $profileName = "";
            $sessionName = "";

			if($result = mysqli_query($connection, $sql)){
				if(mysqli_num_rows($result) >= 0){
					while($row = mysqli_fetch_array($result)){
                        $print .= $row['firstName'];
                        $image .= $row['urlImage'];
                        $id .= $row['id'];
                        $profileName .= $row['profileName'];
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
                        $sessionName .= $row2['profileName'];
                    }
                    mysqli_free_result($res);
                }
            }else{
                echo "ERROR: Could not able to execute $url. " . mysqli_error($connection); 
            }
            
            if(isset($_POST["message"])){
                $get = "chat.php?email=" . $_GET['email'] . "&urlImage=" . $image ."&emailBy=" . $_SESSION['email'] . "&mainImage=" . $picture;
                header('Location:' . $get);
            }

            if(isset($_POST["addAccount"])){
                $add = "add.php?email=" . $_GET['email'] . "&urlImage=" . $image . "&profileName=" . $profileName . "&sessionName=" . $sessionName . "&sessionImage=" . $picture;
                header('Location:' . $add); 
            }
?>

<html>
    <head>
        <title>Profile</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
        <link rel = "stylesheet" type = "text/css" href = "sidebar.css">
        <link rel = "stylesheet" type = "text/css" href = "sidebarB.css">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
    <form method = "POST">

        <?php
			$email = $_GET['email'];
			$sql = "select urlImage, coverPhoto, firstName, lastName from accounts where email = '$email'";
			$result = $connection -> query($sql);
							
			while($row = $result -> fetch_array()){
        ?>
            <div style = "margin-left: 380; width: 760px">
                <input type ="image" src = "<?=$row['coverPhoto']?>" style = "max-width: 100%;, max-height: 100%">  
            </div>
                <div id = "imgProfile">
                    <input class = "cover" type ="image" src = "<?=$row['urlImage']?>" style = "border-radius: 50%;">
                </div>                         

            <div class = "editProfile">
                <input class = "button" style = "margin-left: 920; padding: 15px 30px; border-radius: 100" name = "message" type = "submit" value = "Message">
                <input onclick = "return confirm('Do you really want to add?');" style = "margin-top: -70; padding: 15px 15px; border-radius: 100" class = "button" name = "addAccount" type = "submit" value = "Add Account">
                <h4 style = "color: white; margin-left: 570; margin-top: -5"><?=$row['firstName']?> <?=$row['lastName']?></h4>
            </div>
		<?php
			}
        ?>
        <hr style = "color: white; width: 50%">
        

            <div id = "box">
                        <?php
                            $email = $_GET['email'];
                            $sql = "select id, feed, date_format(date, '%b %e'), name, email, urlImage, likes from feed where email = '$email' order by id desc";
                            $result = $connection -> query($sql);
                            while($row = $result -> fetch_array()){
                        ?>
                            <div class="table-dark">
                            <img id = "imgIcon" src="<?=$row['urlImage']?>">
                            <a name = "nearIconName" href = "action.php" style = "color: white"><?=$row['name']?></a> 
                            - <?=$row["date_format(date, '%b %e')"]?></h5>

                            <div style= "margin-left: 65;margin-top: -20">
                                        <p style="color: white; display: inline; white-space: initial; word-wrap: break-words; text-align: justify"><?=$row['feed']?></p>
                                    </div>
                                    <br>
                                    <br>
                                    <div style = "margin-top: -30;">
                                        <a style = "position: absolute; font-size: 20px; margin-left: 250;color: white" name = "likePost" href="likeQuery.php?id=<?=$row['id']?>&email=<?=$_SESSION['email']?>&emailBy=<?=$row['email']?>&urlImage=<?=$row['urlImage']?>&name=<?=$row['name']?>">
                                            <span class="glyphicon glyphicon-heart"></span>
                                        </a>
                                        <p style = "margin-left: 280; position: absolute; font-size: 15; display: inline;"><?=$row['likes']?></p>
                                        <a href="comment.php?id=<?=$row['id']?>&email=<?=$_SESSION['email']?>" style = "font-size: 20px; margin-left: 470; color: white">
                                            <span class = "glyphicon glyphicon-comment"></span> 
                                        </a>
                                        <?php
                                            $id = $row['id'];
                                            $likes = "select * from comments where id = '$id'";
                                            $res = $connection -> query($likes);
                                            $numOfRows = mysqli_num_rows($res);                                        
                                        ?>
                                        <p style = "margin-left: 10; position: absolute; font-size: 15; display: inline;"><?=$numOfRows?></p>
                                        
                                    </div>   
                                    <br> 
                            </div>
                        </br>
                        <?php
                            }
                        ?>
                        <br>
                    </div>	
    </form>
    

    <div class = "sidenav">
              <img src = "images/mysql.png" style = "width: 70px; height: 70px; margin-left: 100; transform: scaleX(-1);">
              <a href = "home.php?email=<?=$_SESSION['email']?>"><span class = "glyphicon glyphicon-home"> Home</span</a>
              <a href ="notification.php?email=<?=$_SESSION['email']?>"><span class="glyphicon glyphicon-bell"> Notifications</span</a>
              <a href ="messages.php?email=<?=$_SESSION['email']?>"><span class="glyphicon glyphicon-envelope"> Messages</span</a>
              <a href = "friends.php?email=<?=$_SESSION['email']?>"><span class="glyphicon glyphicon-list-alt"> Friends</span></a>
              <a href ="profile.php?email=<?=$_SESSION['email']?>"><span class="glyphicon glyphicon-user"> Profile</span</a>
              <a href ="logout.php"><span class="glyphicon glyphicon-log-out"> Log-out</a>
              <br>
    </div>  
    <div class = "sidenavB">
    </div>


    <div id = "searchMe">
                    <div style = "margin-left: 1060; margin-top: -410; position: fixed; display: inline-block">
                        <form action = "showProfile.php?" method = "POST" id = "form" class="form-inline my-2 my-lg-0">
                            <input autocomplete = "off" style = "width: 300" name = "Search" id = "search" class="form-control mr-sm-2" name = "txtSearch" type="text" placeholder="Search" aria-label="Search">
                            <button name = "submit" style = "height: 36" id = "search" class="btn btn-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>    
                        </form>
                        <div id = "show-list" style = "width: 300; margin-left: 100"></div> 
                        </div>
                        
                </div>
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