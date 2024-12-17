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
    <title>AMETHYST HOTEL</title>
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
                        <a  href="settings.php"><i class="fa fa-dashboard"></i>Room Status</a>
                    </li>
                    <li>
                        <a  href="roomuser.php"><i class="fa fa-plus-circle"></i>Users</a>
                    </li>
					<li>
                        <a  class="active-menu" href="room.php"><i class="fa fa-plus-circle"></i>Add Room</a>
                    </li>
                    <li>
                        <a  href="roomdel.php"><i class="fa fa-desktop"></i> Delete Room</a>
                    </li>
					

                    
            </div>

        </nav>
        <!-- /. NAV SIDE  -->
       
        
       
        <div id="page-wrapper" >
            <div id="page-inner">
                
			 <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                           NEW ROOM <small></small>
                        </h1>
                    </div>
                </div> 
                 
                                 
         
                
                <div class="col-md-5 col-sm-5">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            ADD NEW ROOM
                        </div>
                        <div class="panel-body">
                        <form method="post">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="text" name="category_name" class="form-control" placeholder="Enter Category Name" required>
                                </div>
                                <div class="form-group">
                                    <label>Category Description</label>
                                    <textarea name="category_desc" class="form-control" placeholder="Enter Category Description" required></textarea>
                                </div>
                                <!-- <div class="form-group">
                                    <label>Category Price</label>
                                    <input type="number" name="category_price" class="form-control" placeholder="Enter Category Price" required>
                                </div> -->
                                <input type="submit" name="add_category" value="Add Category" class="btn btn-primary">
                            </form><br>
						<form name="form" method="post" enctype="multipart/form-data">
                            
    <div class="form-group">
        <label>Type Of Room *</label>
        <select name="room-type" class="form-control" required>
                                        <option value="" selected disabled>Select Category</option>
                                        <?php
                                        include('db.php');
                                        $categoryQuery = "SELECT * FROM tblcategory";
                                        $categoryResult = mysqli_query($con, $categoryQuery);

                                        while ($category = mysqli_fetch_assoc($categoryResult)) {
                                            echo "<option value='{$category['ID']}'>{$category['CategoryName']}</option>";
                                        }
                                        ?>
                                    </select>
    </div>

    <div class="form-group">
        <label>Bedding Type</label>
        <input type="text" name="bed" class="form-control" placeholder="Enter Bedding Type" required>
    </div>

    <div class="form-group">
        <label>Room Description</label>
        <textarea name="room_desc" class="form-control" placeholder="Enter Room Description" required></textarea>
    </div>

    <div class="form-group">
        <label>Number of Beds</label>
        <input type="number" name="no_of_beds" class="form-control" placeholder="Enter Number of Beds" required>
    </div>
    <div class="form-group">
        <label>Room Price</label>
        <input type="number" name="room-price" class="form-control" placeholder="Enter the room price" required min="0">
    </div>

    <div class="form-group">
        <label>Room Image</label>
        <input type="file" name="room_image" class="form-control" accept="image/*" required>
    </div>

    <input type="submit" name="add" value="Add New" class="btn btn-primary">
</form>

<?php
include('db.php');

if (isset($_POST['add'])) {
    $roomType = $_POST['room-type'];
    $roomName = $_POST['bed'];
    $roomDesc = $_POST['room_desc'];
    $noOfBeds = $_POST['no_of_beds'];
    $rmprice = $_POST['room-price'];
    $roomFacility = 'Available';

    // Handling Room Image
    $imageFileName = $_FILES['room_image']['name'];
    $imageTempName = $_FILES['room_image']['tmp_name'];
    $imageDestination = "images/" . $imageFileName;


move_uploaded_file($imageTempName, $imageDestination);


    // Check if the room already exists
    $checkQuery = "SELECT * FROM tblroom WHERE RoomType = '$roomType' AND RoomName = '$roomName'";
    $checkResult = mysqli_query($con, $checkQuery);
    $checkData = mysqli_fetch_array($checkResult, MYSQLI_NUM);

    if (!empty($checkData) && $checkData[0] > 0) {
        echo "<script type='text/javascript'> alert('Room Already Exists')</script>";
    } else {
        $insertQuery = "INSERT INTO `tblroom`(`RoomType`, `RoomName`, `RoomDesc`, `NoofBed`, `Image`, `RoomFacility`, `room_price`)
                        VALUES ('$roomType', '$roomName', '$roomDesc', '$noOfBeds', '$imageDestination', '$roomFacility','$rmprice')";
        
        if (mysqli_query($con, $insertQuery)) {
            echo '<script>alert("New Room Added") </script>';
        } else {
            echo '<script>alert("Sorry! Check The System") </script>';
        }
    }
}
if (isset($_POST['add_category'])) {
    $categoryName = $_POST['category_name'];
    $categoryDesc = $_POST['category_desc'];
   // $categoryPrice = $_POST['category_price'];
    

   // $insertCategoryQuery = "INSERT INTO `tblcategory` (`CategoryName`, `Description`, `Price`) VALUES ('$categoryName', '$categoryDesc', '$categoryPrice')";

    $insertCategoryQuery = "INSERT INTO `tblcategory` (`CategoryName`, `Description`) VALUES ('$categoryName', '$categoryDesc')";
    
    
    if (mysqli_query($con, $insertCategoryQuery)) {
        echo '<script>alert("New Category Added")</script>';
    } else {
        echo '<script>alert("Sorry! Check The System")</script>';
    }
}
?>

                        </div>
                        
                    </div>
                </div>
                
                  
                <?php



$recordsPerPage = 10;

// Get the current page number from the URL, default to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;


$offset = ($page - 1) * $recordsPerPage;

// Get the total number of records
$totalRecordsQuery = "SELECT COUNT(*) AS total FROM tblroom";
$totalRecordsResult = mysqli_query($con, $totalRecordsQuery);
$totalRecordsRow = mysqli_fetch_assoc($totalRecordsResult);
$totalRecords = $totalRecordsRow['total'];

// Calculate total pages
$totalPages = ceil($totalRecords / $recordsPerPage);

// Fetch the records for the current page
$sql = "SELECT * FROM tblroom LIMIT $offset, $recordsPerPage";

$re = mysqli_query($con, $sql);
?>
           
    <div class="col-md-6 col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                ROOMS INFORMATION
            </div>
<div class="panel-body">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th>Room ID</th>
                    <th>Room Type</th>
                    <th>Bedding</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($re)) {
                    $id = $row['ID'];
                    $rowClass = ($id % 2 == 0) ? 'odd gradeX' : 'even gradeC';
                    echo "<tr class='{$rowClass}'>
                            <td>{$row['ID']}</td>
                            <td>{$row['RoomType']}</td>
                            <td>{$row['RoomName']}</td>
                            <td>{$row['room_price']}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="pagination">
        <?php
        // Display pagination links
        if ($totalPages > 1) {
            for ($i = 1; $i <= $totalPages; $i++) {
                $activeClass = ($i == $page) ? 'class="active"' : '';
                echo "<a href='?page={$i}' {$activeClass}>{$i}</a> ";
            }
        }
        ?>
    </div>
</div>
</div>
</div>
</div>


                <!-- End Advanced Tables -->

            </div>

        </div>
    </div>
</div>
                    
            
				
					</div>
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
