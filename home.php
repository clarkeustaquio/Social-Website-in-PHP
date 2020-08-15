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

			if($result = mysqli_query($connection, $sql)){
				if(mysqli_num_rows($result) >= 0){
					while($row = mysqli_fetch_array($result)){
                        $print .= $row['firstName'];
                        $image .= $row['urlImage'];
					}
					mysqli_free_result($result);
				}
			}else{
				echo "ERROR: Could not able to execute $sql. " . mysqli_error($connection); 
			}

			if(isset($_POST["btnTweet"])){
                
                    global $print, $connection;

                    $tweet = $_POST["txtArea"];       
                    $get = "home.php?email=" . $_GET['email'];
                    $sql = "insert into feed(feed, name, email, urlImage) values('$tweet', '$print', '$email', '$image')";
                    $result = $connection -> query($sql);
                    header('Location:' . $get);
            }
            
            /*<?php
            $curr = $row['id'];
            $edit = $_POST["editArea"];
            $emailSession = $_SESSION['email'];

   
            if(isset($_POST["editButton"])){
                $update = "update feed set feed = '$edit' where id = '$curr'";
                $res2 = $connection->query($update);
            }
        ?>*/


?>

<html>
    <head>
        <title>Home</title>

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
            
            <div class = "sidenav">
                    <img src = "images/mysql.png" style = "width: 18%; height: 10%; margin-left: 27%; transform: scaleX(-1);">
                    <a href = "home.php?email=<?=$_GET['email']?>"><span class = "glyphicon glyphicon-home"> Home</span></a>
                    <a href ="notification.php?email=<?=$_GET['email']?>"><span class="glyphicon glyphicon-bell"> Notifications</span></a>
                    <a href ="messages.php?email=<?=$_GET['email']?>"><span class="glyphicon glyphicon-envelope"> Messages</span></a>
                    <a href = "friends.php?email=<?=$_GET['email']?>"><span class="glyphicon glyphicon-list-alt"> Friends</span></a>
                    <a href ="profile.php?email=<?=$_GET['email']?>"><span class="glyphicon glyphicon-user"> Profile</span></a>
                    <a href ="logout.php"><span class="glyphicon glyphicon-log-out"> Log-out</a>
                <br>
            </div>  
            
            <div class = "sidenavB">
            </div>
            <div id = "searchMe">
                    <div style = "margin-left: 69%; margin-top: 1%; position: fixed; display: inline-block">
                        <form action = "showProfile.php?" method = "POST" id = "form" class="form-inline my-2 my-lg-0">
                            <input autocomplete = "off" style = "width: 300px" name = "Search" id = "search" class="form-control mr-sm-2" name = "txtSearch" type="text" placeholder="Search" aria-label="Search">
                            <button name = "submit" style = "height: 36" id = "search" class="btn btn-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                        <div id = "show-list" style = "width: 300; margin-left: 22.5%"></div> 
                        </div>
                        
                </div>
            <form method = "POST">

            <div class = "header" id = "myHeader">
                <h3 style = "margin-left: 3%;">Home</h3>
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
            
            <hr style = "color: white; width: 50%">
                
                    <textarea name = "txtArea" rows="4" cols="100" placeholder = " What's happening?"></textarea>
                    <input name = "btnTweet" class="btn btn-primary" type ="submit" value = "Tweet">
            
                    <label style = "font-size: 20; border: none; margin-left: -47.5%"class = "custom-file-upload">
                        <input type = "file" name = "profile" id = "uploadfile"/>
                        <span style = "color: #008CBA;" class="glyphicon glyphicon-picture"> Photo/Video</span>
                    </label>

                    <button type="button" style = "font-size: 20; background-color: Transparent; border: none; margin-left: 1%">
                        <span style = "color: #008CBA"class="glyphicon glyphicon-map-marker"> Map</span>
                    </button>

                <script src = "JS/jquery.js"></script>
                <script>
                    $(document).ready(function(){
                        $('#uploadfile').change(function(e){
                            if(this.files && this.files[0]){
                                var img = document.querySelector('#myImg');
                                img.src = URL.createObjectURL(this.files[0]);
                            }
                        });
                    });
                </script>

                <div id = "box">
                        <?php
                            $sql = "select id, feed, date_format(date, '%b %e'), name, email, urlImage, likes from feed order by id desc";
                            $result = $connection -> query($sql);

                            while($row = $result -> fetch_array()){
                        ?>
                            <div class="table-dark">
                            
                            <img id = "imgIcon" src="<?=$row['urlImage']?>">
                            <h5 style ="display: inline">
                                <a name = "nearIconName" href = "searchedProfile.php?email=<?=$row['email']?>" style = "color: white"><?=$row['name']?></a> 
                                - <?=$row["date_format(date, '%b %e')"]?>
                            </h5>

                                    <div style= "margin-left: 8.5%; margin-top: -3%;">
                                        <p style='color: white; display: inline; white-space: initial; word-wrap: break-words'><?=$row['feed']?></p>
                                    </div>
                                    <br><br>

                                    <div style = "margin-top: -3%;">
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
                                            <button type = "button" data-toggle="modal" data-target="#myModal" style = "background-color: Transparent; border: none; font-size: 20px; margin-left: 150; color: white">
                                                <span class = "glyphicon glyphicon-edit"></span>
                                            </button>

                                            <div class="modal fade" id="myModal" role="dialog">
                                                <div class="modal-dialog">
                                                    <div style = "background-color: #292F33" class="modal-content">
                                                        <div class = "modal-header">
                                                            <h4 style = "all: unset; font-size: 25">Edit Post</h4>
                                                            <button style = "color: white" type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <form method = "POST">
                                                        <div class = "modal-body">
                                                            
                                                                <textarea style = "color: black" name = "editArea" rows="3" cols="60" placeholder = " What's happening?"></textarea>
                                                            
                                                        </div>
                                                        
                                                        <div class = "modal-footer">
                                                            <input style = "position: absolute; margin-left: -80; margin-top: -10" class = "button" name = "cancelButton" type = "submit" value = "Cancel">
                                                            <input style = "margin-top: -1;" class = "button" name = "editButton" type = "submit" value = "Edit">
                                                        </div>
                                                        </form>
                                                    </div>
                                                
                                                </div>
                                            </div>
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
    </body>
    <script>
        function Like(){

        }
    </script>

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