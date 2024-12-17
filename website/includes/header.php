<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');

// Fetch color and background values from the database
$query = "SELECT * FROM maintenance WHERE id = 1";
$result = $dbh->query($query); // Use PDO query method

$row = $result->fetch(PDO::FETCH_ASSOC);

$backgroundColor = $row['color'];
$backgroundImage = $row['background'];
$logoImage = $row['logo'];




?>
<head>
<title>SOLAIRE HOTEL</title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Resort Inn Responsive , Smartphone Compatible web template , Samsung, LG, Sony Ericsson, Motorola web design" /><link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" /><link rel="stylesheet" href="css/jquery-ui.css" /><link href="css/font-awesome.css" rel="stylesheet"> <link rel="stylesheet" href="css/chocolat.css" type="text/css" media="screen"><link href="css/easy-responsive-tabs.css" rel='stylesheet' type='text/css'/><link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" property="" /><link href="css/style.css" rel="stylesheet" type="text/css" media="all" /><script type="text/javascript" src="js/modernizr-2.6.2.min.js"></script>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->








<!--fonts-->
<link href="//fonts.googleapis.com/css?family=Oswald:300,400,700" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Federo" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
<!--//fonts-->
</head>
<div class="w3_navigation">
		<div class="container">
			<nav class="navbar navbar-default">
				<div class="navbar-header navbar-left">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
                    
					<h1><a class="navbar-brand" href="index.php"><img style="height:70px;width 70px;position:absolute;margin-left:-90px;margin-top:-15px;"src="admin/images/<?php echo $logoImage; ?>">SOLAIRE <span>HOTEL</span><p class="logo_w3l_agile_caption"> Elegant, Luxurious, Inviting.</p></a></h1>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
					<nav class="menu menu--iris">
						<ul class="nav navbar-nav menu__list">
							
							
							
							
							
							
						
    
                            <li class="menu__item"><a href="index.php">Home</a></li>

                            <li class="menu__item"><a href="#about" >About</a></li>

                            

                                    <li class="dropdown">

                                        <a href="#" class="" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Rooms <span class="caret"></span></a>

                                <ul class="dropdown-menu">

                                    <?php

$ret="SELECT * from tblcategory";

$query1 = $dbh -> prepare($ret);

$query1->execute();

$resultss=$query1->fetchAll(PDO::FETCH_OBJ);

foreach($resultss as $rows){     
 ?>

                                   <li><a href="category-details.php?catid=<?php echo htmlentities($rows->ID)?>"><?php echo htmlentities($rows->CategoryName)?></a></li>

                                    <?php } ?> 

                                </ul>

                                    </li>

                                    <li class="menu__item"><a href="#gallery" >Gallery</a></li>

                                    <li class="menu__item"><a href="#contact" >Contact Us</a></li>

                                     <?php if (strlen($_SESSION['hbmsuid']==0)) {?>

                                    
                                    

                                    <li class="menu__item"><a href="signin.php">Login</a></li><?php } ?>

                                    <?php if (strlen($_SESSION['hbmsuid']!=0)) {?>

                                    <li class="dropdown">

                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Profile<span class="caret"></span></a>

                                <ul class="dropdown-menu">
                                            
                                    <li><a href="profile.php">Profile</a></li>

                                    <li><a href="my-booking.php">My Booking</a></li>

                                    <li><a href="change-password.php">Change Password</a></li>

                                    <li><a href="logout.php">Logout</a></li>

                                    

                                </ul>

                                    </li><?php } ?>

                                  
                    </ul>
					</nav>
				</div>
			</nav>
		</div>
	</div>