<?php
	session_start();
		if(!isset($_SESSION['email'])){
			header("Location: index.php");
		}

        require_once("connection.php");
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
                    <div style = "margin-left: 1060; margin-top: 15; position: fixed; display: inline-block">
                        <form action = "showProfile.php?" method = "POST" id = "form" class="form-inline my-2 my-lg-0">
                            <input autocomplete = "off" style = "width: 300" name = "Search" id = "search" class="form-control mr-sm-2" name = "txtSearch" type="text" placeholder="Search" aria-label="Search">
                            <button name = "submit" style = "height: 36" id = "search" class="btn btn-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>

                            
                        </form>
                        <div id = "show-list" style = "width: 300; margin-left: 100"></div> 
                        </div>
                        
                </div>

        <form>
        <div class = "header"id = "myHeader">
                <h3 style = "margin-left: 20;">Messages</h3>
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

                <div id = "Box" class ="content">
                        <?php
                            $whoSend = $_SESSION['email'];
                            $sql = "select * from whoImessage where whoSend = '$whoSend'";

                            $toWhom = "select * from untilNot where toWhom = '$whoSend'";
                            $sessionImage = "";
                            $email = "";
                            $sessionProfile = "";
                            $whoSendEmail = "";

                            if($res = mysqli_query($connection, $toWhom)){
                                if(mysqli_num_rows($res) >= 0){
                                    while($row2 = mysqli_fetch_array($res)){
                                        $email .= $row2['toWhom'];
                                        $sessionImage .= $row2['sessionImage'];
                                        $sessionProfile .= $row2['sessionProfile'];
                                        $whoSendEmail .= $row2['whoSend'];
                                    }
                                    mysqli_free_result($res);
                                }
                            }

                            $result = $connection -> query($sql);
                            $count = mysqli_num_rows($result);

                            if($count == 0 && ($email != "")){
                                echo "<div class = 'table-dark'>";
                                echo "<img style = 'margin-bottom: 10' id = 'imgIconChat' src='$sessionImage'>";
                                    
                                echo "<div style= 'margin-left: -300;margin-top: -60;'>";
                                echo    "<a href = 'toChat.php?email=$whoSendEmail''>";
                                echo        "<h4 style='position: absolute; color: white; display: inline; white-space: initial; word-wrap: break-words'>" . $sessionProfile . "</h4>";
                                echo     "</a>";
                                echo "</div>";
                                echo "</div><br><br>";
                                echo "<hr style = 'color: white; width: 100%'>";
                            }
                            
                            while($row = $result -> fetch_array()){
                            ?>

                            <div class = "table-dark">
                            <img style = "margin-bottom: 10" id = "imgIconChat" src="<?=$row['urlImage']?>">
                                <div style= "margin-left: -300; margin-top: -60;">
                                    <a href = "toChat.php?email=<?=$row['toWhom']?>">
                                        <h4 style='position: absolute; color: white; display: inline; white-space: initial; word-wrap: break-words'><?=$row['profileName']?></h4>
                                    </a>
                                </div>  
                            </div>
                            <br>
                            <br>
                            <hr style = "color: white; width: 100%">
                        <?php
                            }
                        ?>
                        
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