<?php
	session_start();
		if(!isset($_SESSION['email'])){
			header("Location: index.php");
		}

        require_once("connection.php");
        if(isset($_POST['backToFriends'])){
            $back = "friends.php?email=" . $_SESSION['email'];
            header('Location:' . $back);
        }
?>

<html>
    <head>
        <title>Pending</title>

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

        <form method = "POSt">
        <div class = "header"id = "myHeader">
                <h3 style = "margin-left: 20;">Pending Requests</h3>

                        <button name = "backToFriends" style = "position: absolute; background-color: Transparent; border: none; font-size: 20px; margin-left: 650; margin-top: -45; color: white">
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
                <hr style = "color: white; width: 50%">

                <div id = "Box" class ="content">
                        <?php
                            $whoSend = $_SESSION['email'];
                            $sql = "select * from friends where email = '$whoSend'";
                            $result = $connection->query($sql);                            
                            while($row = $result -> fetch_array()){
                                if($row['status'] == "pending"){
                            ?>
                                <div class = "table-dark">
                                <img style = "margin-bottom: 10" id = "imgIconChat" src="<?=$row['sessionImage']?>">
                                    <div style= "margin-left: -300; margin-top: -60;">
                                            <h4 style='position: absolute; color: white;'><?=$row['sessionName']?></h4>
                                            <a style = "position: absolute; margin-left: 700; margin-top: 10;" class = "button" name = "accept" href = "pendingQuery.php?email=<?=$row['email']?>&whoAdd=<?=$row['whoAdd']?>&status=yes">Accept Request</a>
                                            <a style = "position: absolute; margin-left: 880; margin-top: 10"class = "button" name = "accept" href = "pendingQuery.php?email=<?=$row['email']?>&whoAdd=<?=$row['whoAdd']?>&status=no">Cancel Request</a>
                                        </div> 
                                        <br>
                                        <br>
                                        <hr style = "color: white; width: 100%"> 
                                </div>
                                
                        <?php
                                }
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