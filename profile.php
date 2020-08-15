<?php
    session_start();
    if(!isset($_SESSION['email'])){
        header("Location: index.php");
    }

    require_once("connection.php");

    $email = $_GET['email'];
            $sql = "SELECT * FROM accounts WHERE email = '$email'";
            $print = "";
            $image = "";
            $id = "";
            $firstName = "";
            $lastName = "";
            $birthday = "";
            $phoneNumber = "";
            $gender = "";
            $urlImage = "";


			if($result = mysqli_query($connection, $sql)){
				if(mysqli_num_rows($result) >= 0){
					while($row = mysqli_fetch_array($result)){
                        $print .= $row['firstName'];
                        $image .= $row['urlImage'];
                        $id .= $row['id'];
                        $firstName .= $row['firstName'];
                        $lastName .= $row['lastName'];
                        $birthday .= $row['birthday'];
                        $phoneNumber .= $row['phoneNumber'];
                        $gender .= $row['gender'];
                        $urlImage .= $row['urlImage'];
					}
					mysqli_free_result($result);
				}
			}else{
				echo "ERROR: Could not able to execute $sql. " . mysqli_error($connection); 
			}

			if(isset($_POST["btnTweet"])){
				global $print, $connection;

				$tweet = $_POST["txtArea"];
				$get = "profile.php?email=" . $_GET['email'];
				$sql = "insert into feed(feed, name, email, urlImage) values('$tweet', '$print', '$email', '$image')";
				$result = $connection -> query($sql);
				header('Location:' . $get);
            }
            
            if(isset($_POST["editProfile"])){
                    $get = "editProfile.php?email=" . $_GET['email'] . "&id=" . $id . "&firstName=" . $firstName . "&lastName=" . $lastName . "&birthday=" . $birthday . "&phoneNumber=" . $phoneNumber . "&gender=" . $gender . "&urlImage=" . $urlImage;
                    header('Location:' . $get);
            }

            if(isset($_POST["deleteAccount"])){
                $delete = "deleteQuery.php?email=" . $_GET['email'] . "&id=" . $id;
                header('Location:' . $delete);
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
                <input class = "button" style = "margin-left: 900; padding: 15px 30px; border-radius: 100" name = "editProfile" type = "submit" value = "Edit Profile">
                <input onclick = "return confirm('Do you really want to delete?');" style = "margin-top: -70; padding: 15px 15px; border-radius: 100" class = "button" name = "deleteAccount" type = "submit" value = "Delete Account">
                <h4 style = "color: white; margin-left: 570; margin-top: -5"><?=$row['firstName']?> <?=$row['lastName']?></h4>
            </div>
		<?php
			}
        ?>
        <hr style = "color: white; width: 50%">
        <h4>Post</h4>
            <textarea style = "margin-top: 20"name = "txtArea" rows="4" cols="100" placeholder = " What's happening?"></textarea>
            <input name = "btnTweet" class="btn btn-primary" type ="submit" value = "Tweet">

                    <label style = "font-size: 20; border: none; margin-left: -700"class = "custom-file-upload">
                        <input type = "file" name = "profile" id = "uploadfile"/>
                        <span style = "color: #008CBA;" class="glyphicon glyphicon-picture"> Photo/Video</span>
                    </label>

                    <button type="button" style = "font-size: 20; background-color: Transparent; border: none; margin-left: 50">
                        <span style = "color: #008CBA"class="glyphicon glyphicon-map-marker"> Map</span>
                    </button>

            <div id = "box">
                        <?php
                            $email = $_GET['email'];
                            $sql = "select id, feed, date_format(date, '%b %e'), name, email, urlImage, likes from feed where email = '$email' order by id desc";
                            $result = $connection -> query($sql);
                            while($row = $result -> fetch_array()){
                        ?>
                            <div class="table-dark">
                            <img id = "imgIcon" src="<?=$row['urlImage']?>">
                            <a name = "nearIconName" href = "#" style = "color: white"><?=$row['name']?></a> 
                            - <?=$row["date_format(date, '%b %e')"]?></h5>

                                    <div style= "margin-left: 65;margin-top: -20">
                                        <p style='color: white; display: inline; white-space: initial; word-wrap: break-words'><?=$row['feed']?><p>
                                    </div>

                                    <br><br>

                                    <div style = "margin-top: -30;">
                                    <a style = "position: absolute; font-size: 20px; margin-left: 100; color: white" name = "likePost" href="likeQuery.php?id=<?=$row['id']?>&email=<?=$_SESSION['email']?>&emailBy=<?=$row['email']?>&urlImage=<?=$row['urlImage']?>&name=<?=$row['name']?>">
                                            <span class="glyphicon glyphicon-heart"></span>
                                        </a>
                                        <p style = "margin-left: 130; position: absolute; font-size: 15; display: inline;"><?=$row['likes']?></p>


                                        <a href="comment.php?id=<?=$row['id']?>&email=<?=$_SESSION['email']?>" style = "font-size: 20px; margin-left: 270; color: white">
                                                <span class = "glyphicon glyphicon-comment"></span>
                                        </a>
                                        <?php
                                            $id = $row['id'];
                                            $likes = "select * from comments where id = '$id'";
                                            $res = $connection -> query($likes);
                                            $numOfRows = mysqli_num_rows($res);                                        
                                        ?>
                                        <p style = "margin-left: 10; position: absolute; font-size: 15; display: inline;"><?=$numOfRows?></p>

                                        <a href="#" style = "font-size: 20px; margin-left: 150; color: white">
                                            <button style = "background-color: Transparent; border: none">
                                                <span class = "glyphicon glyphicon-edit"></span>
                                            </button>
                                        </a>
                                        <a href = "deletePost.php?id=<?=$row['id']?>" onclick = "return confirm('Do you really want to delete?')" style = "font-size: 20px; margin-left: 150; color: white"> 
                                            <span class = "glyphicon glyphicon-trash"></span>
                                        </a>
                                    </div>
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
              <a href = "home.php?email=<?=$_GET['email']?>"><span class = "glyphicon glyphicon-home"> Home</span></a>
              <a href ="notification.php?email=<?=$_GET['email']?>"><span class="glyphicon glyphicon-bell"> Notifications</span></a>
              <a href ="messages.php?email=<?=$_GET['email']?>"><span class="glyphicon glyphicon-envelope"> Messages</span></a>
              <a href = "friends.php?email=<?=$_GET['email']?>"><span class="glyphicon glyphicon-list-alt"> Friends</span></a>
              <a href ="profile.php?email=<?=$_GET['email']?>"><span class="glyphicon glyphicon-user"> Profile</span></a>
              <a href ="logout.php"><span class="glyphicon glyphicon-log-out"> Log-out</a>
              <br>
                    
    </div>  
    
    <div class = "sidenavB"></div>
        <div id = "searchMe">
                    <div style = "margin-left: 1060; margin-top: -625; position: fixed; display: inline-block">
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