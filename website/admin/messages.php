<?php
session_start();
include('db.php');

// User authentication check
if (!isset($_SESSION["user"])) {
    header("location:index.php");
    exit();
}

$uploadDir = "images/"; // Change this path if needed

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Validate form data
    if (isset($_POST["color"])) {
        $color = $_POST["color"];

        // Check if the directory exists, if not, create it
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Upload Logo
        if (isset($_FILES["logo"]) && $_FILES["logo"]["error"] == UPLOAD_ERR_OK) {
            $logoImageName = basename($_FILES["logo"]["name"]);
            $logoTargetPath = $uploadDir . $logoImageName;
            move_uploaded_file($_FILES["logo"]["tmp_name"], $logoTargetPath);
        }

        // Upload Background Image
        if (isset($_FILES["background"]) && $_FILES["background"]["error"] == UPLOAD_ERR_OK) {
            $backgroundImageName = basename($_FILES["background"]["name"]);
            $backgroundTargetPath = $uploadDir . $backgroundImageName;
            move_uploaded_file($_FILES["background"]["tmp_name"], $backgroundTargetPath);
        }

        // Update the database with new values
        $updateSql = "UPDATE maintenance SET logo = ?, background = ?, color = ? WHERE id = 1";
        $stmt = $con->prepare($updateSql);
        $stmt->bind_param("sss", $logoImageName, $backgroundImageName, $color);
        $stmt->execute();
        $stmt->close();
    }

    // Update slideshow images
    $slideshowImageNames = [];

    for ($i = 1; $i <= 3; $i++) {
        $inputName = "slideshow_image{$i}";

        if (isset($_FILES[$inputName]) && $_FILES[$inputName]["error"] == UPLOAD_ERR_OK) {
            $slideshowImageName = basename($_FILES[$inputName]["name"]);
            $slideshowTargetPath = $uploadDir . $slideshowImageName;
            move_uploaded_file($_FILES[$inputName]["tmp_name"], $slideshowTargetPath);

            $slideshowImageNames[] = $slideshowImageName;
        }
    }

    // Update slideshow image paths in the database
    $updateSlideshowSql = "UPDATE maintenance SET slideshow_image1 = ?, slideshow_image2 = ?, slideshow_image3 = ? WHERE id = 1";
    $stmt = $con->prepare($updateSlideshowSql);
    $stmt->bind_param("sss", $slideshowImageNames[0], $slideshowImageNames[1], $slideshowImageNames[2]);
    $stmt->execute();
    $stmt->close();
}

// Fetch current values from the database
$query = "SELECT * FROM maintenance WHERE id = 1";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$logo = $row['logo'];
$background = $row['background'];
$color = $row['color'];

// Fetch slideshow image paths from the database
$querySlideshow = "SELECT slideshow_image1, slideshow_image2, slideshow_image3 FROM maintenance WHERE id = 1";
$resultSlideshow = mysqli_query($con, $querySlideshow);
$rowSlideshow = mysqli_fetch_assoc($resultSlideshow);

$slideshowImage1 = $rowSlideshow['slideshow_image1'];
$slideshowImage2 = $rowSlideshow['slideshow_image2'];
$slideshowImage3 = $rowSlideshow['slideshow_image3'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Solaire Hotel</title>
	<!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- Morris Chart Styles-->
   
        <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
     <!-- Google Fonts-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
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
                <a class="navbar-brand" href="home.php"><?php echo $_SESSION["user"]; ?> </a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="usersetting.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
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
                        <a href="home.php"><i class="fa fa-dashboard"></i> Status</a>
                    </li>
                    <li>
                        <a class="active-menu" href="messages.php"><i class="fa fa-desktop"></i> Maintenance</a>
                    </li>
					<li>
                        <a href="roombook.php"><i class="fa fa-bar-chart-o"></i>Room Booking</a>
                    </li>
                    <li>
                        <a href="Payment.php"><i class="fa fa-qrcode"></i> Payment</a>
                    </li>
                    <li>
                        <a  href="profit.php"><i class="fa fa-qrcode"></i> Profit</a>
                    </li>
                    <li>
                        <a href="logout.php" ><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                    


                    
            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
			 <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                           Maintenance<small> panel</small>
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
                 <form action="messages.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="logo">Upload Logo:</label>
                        <input type="file" name="logo" id="logo" accept="image/*" >
                    </div>

                    <div class="form-group">
                        <label for="background">Upload Background Image:</label>
                        <input type="file" name="background" id="background" accept="image/*" >
                    </div>
                    <div class="form-group">
                        <label for="backgroundColorPicker">Choose Background Color:</label>
                        <input type="color" id="backgroundColorPicker" name="color" value="<?php echo $backgroundColor; ?>">
                    </div>
                    <div class="form-group">
            <label for="slideshow_image1">Upload Slideshow Image 1:</label>
            <input type="file" name="slideshow_image1" id="slideshow_image1" accept="image/*">
        </div>

        <div class="form-group">
            <label for="slideshow_image2">Upload Slideshow Image 2:</label>
            <input type="file" name="slideshow_image2" id="slideshow_image2" accept="image/*">
        </div>

        <div class="form-group">
            <label for="slideshow_image3">Upload Slideshow Image 3:</label>
            <input type="file" name="slideshow_image3" id="slideshow_image3" accept="image/*">
        </div>
                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                </form>
         <!-- /. PAGE WRAPPER  -->
     <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
         <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
    
   
</body>
</html>
