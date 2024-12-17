<?php  
session_start();  
if(!isset($_SESSION["user"]))
{
 header("location:index.php");
}
?> 
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SOLAIRE HOTEL</title>
	<!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
     <!-- Google Fonts-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php">MAIN MENU </a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
			
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="settings.php"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
					
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a class="active-menu" href="settings.php"><i class="fa fa-dashboard"></i>Room Status</a>
                    </li>
					<li>
                        <a  href="roomuser.php"><i class="fa fa-plus-circle"></i>Users</a>
                    </li>
                    <li>
                        <a  href="room.php"><i class="fa fa-plus-circle"></i>Add Room</a>
                    </li>
                    <li>
                        <a   href="roomdel.php"><i class="fa fa-pencil-square-o"></i> Delete Room</a>
                    </li>
					

                    
            </div>

        </nav>
        <!-- /. NAV SIDE  -->
       
        <div id="page-wrapper" >
            <div id="page-inner">
			 <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                           Available <small> Rooms</small>
                        </h1>
                    </div>
                </div> 
                 
                                 
              <?php
include('db.php');

// Fetch rooms and their categories
$sql = "SELECT r.*, c.CategoryName 
        FROM tblroom r
        INNER JOIN tblcategory c ON r.RoomType = c.ID";
$result = mysqli_query($con, $sql);

// Fetch unique categories and assign them colors dynamically
$categorySql = "SELECT DISTINCT CategoryName FROM tblcategory";
$categoryResult = mysqli_query($con, $categorySql);

// Assign colors to categories dynamically
$categoryColors = [];
$defaultColors = ['blue', 'green', 'brown', 'red', 'purple', 'yellow'];
$colorIndex = 0;

while ($categoryRow = mysqli_fetch_array($categoryResult)) {
    $categoryName = $categoryRow['CategoryName'];
    $categoryColors[$categoryName] = "back-footer-" . $defaultColors[$colorIndex % count($defaultColors)];
    $colorIndex++;
}
?>

<div class="row">
    <?php
    while ($row = mysqli_fetch_array($result)) {
        $categoryName = $row['CategoryName'];
        $colorClass = $categoryColors[$categoryName] ?? "back-footer-default"; // Default class if not assigned

        echo "<div class='col-md-3 col-sm-12 col-xs-12'>";
        echo "<div class='panel panel-primary text-center no-boder bg-color-blue'>";
        echo "<div class='panel-body'>";
        echo "<i class='fa fa-users fa-5x'></i>";
        echo "<h6>" . $row['RoomName'] . "</h6>";
        echo "</div>";
        echo "<div class='panel-footer $colorClass'>" . $categoryName . "</div>";
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>

</div>

</div>

                <!-- /. ROW  -->
                
                                
                  
            
			 <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
    
   
</body>
</html>
