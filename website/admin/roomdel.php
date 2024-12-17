<?php  
session_start();  
if(!isset($_SESSION["user"]))
{
 header("location:index.php");
}
ob_start();
?> 

<?php
include('db.php');
$rsql ="select id from tblroom";
$rre=mysqli_query($con,$rsql);

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
                        <a  href="settings.php"><i class="fa fa-dashboard"></i>Room Status</a>
                    </li>
                    <li>
                        <a  href="roomuser.php"><i class="fa fa-plus-circle"></i>Users</a>
                    </li>
					<li>
                        <a   href="room.php"><i class="fa fa-plus-circle"></i>Add Room</a>
                    </li>
                    <li>
                        <a  class="active-menu" href="roomdel.php"><i class="fa fa-pencil-square-o"></i> Delete Room</a>
                    </li>
					

                    
            </div>

        </nav>
        <!-- /. NAV SIDE  -->
       
       
        <div id="page-wrapper" >
            <div id="page-inner">
			 <div class="row">
                    <div class="col-md-12">
                    <h1 class="page-header">
                           DELETE CATEGORY AND ROOMS <small></small>
                        </h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div>
                            <?php
                            if (isset($_POST['del_category'])) {
                                if (!empty($_POST['category_ids'])) {
                                    $category_ids = implode(',', $_POST['category_ids']);

                                    // Delete rooms associated with selected categories
                                    $deleteRoomsQuery = "DELETE r FROM tblroom r
                                                        INNER JOIN tblcategory c ON r.RoomType = c.CategoryName
                                                        WHERE c.ID IN ($category_ids)";

                                    // Delete selected categories
                                    $deleteCategoriesQuery = "DELETE FROM tblcategory WHERE ID IN ($category_ids)";

                                    if (mysqli_query($con, $deleteRoomsQuery) && mysqli_query($con, $deleteCategoriesQuery)) {
                                        echo '<script type="text/javascript">alert("Delete the Categories and Rooms") </script>';
                                        header("Location: roomdel.php");
                                    } else {
                                        echo '<script>alert("Sorry ! Check The System") </script>';
                                    }
                                } else {
                                    echo '<script>alert("Please select at least one category to delete") </script>';
                                }
                            }
                            ?>
                        </div>

                        <form method="post" action="">
                            <div class="table-responsive">
                                <?php
                                $categoryQuery = "SELECT * FROM tblcategory";
                                $categoryResult = mysqli_query($con, $categoryQuery);

                                if (!$categoryResult) {
                                    die("Query failed: " . mysqli_error($con));
                                }

                                if (mysqli_num_rows($categoryResult) > 0) {
                                ?>
                                    <button type="submit" class="btn btn-danger" name="del_category">Delete Selected Categories</button><br>
                                <?php
                                } else {
                                    echo "No categories found.";
                                }
                                ?><br>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Select</th>
                                            <th>Category ID</th>
                                            <th>Category Name</th>
                                            <th>Category Description</th>
                                    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($categoryRow = mysqli_fetch_array($categoryResult)) {
                                            $category_id = $categoryRow['ID'];
                                            $class = $category_id % 2 == 0 ? 'odd gradeX' : 'even gradeC';

                                            echo "<tr class='$class'>
                                                    <td><input type='checkbox' name='category_ids[]' value='" . $categoryRow['ID'] . "'></td>
                                                    <td>" . $categoryRow['ID'] . "</td>
                                                    <td>" . $categoryRow['CategoryName'] . "</td>
                                                    <td>" . $categoryRow['Description'] . "</td>
                                                </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <h1 class="page-header">
                           DELETE ROOM <small></small>
                        </h1>
                    </div>
                </div> 
                 
                                 
				<div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div >
                            

                            <?php
                            include('db.php');

                            if (isset($_POST['del'])) {
                                if (!empty($_POST['ids'])) {
                                    $ids = implode(',', $_POST['ids']);
                                    $sql = "DELETE FROM tblroom WHERE id IN ($ids)";

                                    if (mysqli_query($con, $sql)) {
                                        echo '<script type="text/javascript">alert("Delete the Rooms") </script>';
                                        header("Location: roomdel.php");
                                    } else {
                                        echo '<script>alert("Sorry ! Check The System") </script>';
                                    }
                                } else {
                                    echo '<script>alert("Please select at least one room to delete") </script>';
                                }
                            }
                            ?>
                        </div>

                        <form method="post" action="">
                            <div class="table-responsive">
                                <?php
                                $query = "SELECT r.*, c.CategoryName
                                        FROM tblroom r
                                        LEFT JOIN tblcategory c ON r.RoomType = c.ID";
                                $re = mysqli_query($con, $query);

                                if (!$re) {
                                    die("Query failed: " . mysqli_error($con));
                                }

                                if (mysqli_num_rows($re) > 0) {
                                ?>
								  <button type="submit" class="btn btn-danger" name="del">Delete Selected</button><br>
                                <?php
                                } else {
                                    echo "No rooms found.";
                                }
                                ?><br>
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th>Room ID</th>
                                                <th>Room Type</th>
                                                <th>Bedding</th>
                                                <th>Max Adults</th>
                                                <th>Max Children</th>
                                                <th>Room Description</th>
                                                <th>No. of Beds</th>
                                                <th>Image</th>
                                                <th>Room Status</th>
                                                <th>Creation Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_array($re)) {
                                                $id = $row['ID'];
                                                $class = $id % 2 == 0 ? 'odd gradeX' : 'even gradeC';

                                                echo "<tr class='$class'>
                                                        <td><input type='checkbox' name='ids[]' value='" . $row['ID'] . "'></td>
                                                        <td>" . $row['ID'] . "</td>
                                                        <td>" . $row['CategoryName'] . "</td>
                                                        <td>" . $row['RoomName'] . "</td>
                                                        <td>" . $row['MaxAdult'] . "</td>
                                                        <td>" . $row['MaxChild'] . "</td>
                                                        <td>" . $row['RoomDesc'] . "</td>
                                                        <td>" . $row['NoofBed'] . "</td>
                                                        <td><img src='images/" . $row['Image'] . "' alt='Room Image' style='max-height: 100px;'></td>
                                                        <td>" . $row['RoomFacility'] . "</td>
                                                        <td>" . $row['CreationDate'] . "</td>
                                                    </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                  
                            </div>
                        </form>
    </div>
</div>

                    
                </div>
            <?php
				
			ob_end_flush();
			?>
                    
            
				
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
