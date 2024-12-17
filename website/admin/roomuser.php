<?php
session_start();
include('includes/dbconnection.php');

if (!isset($_SESSION["user"])) {
    header("location:index.php");
    exit();
}

// Fetch user data from the database
$query = "SELECT ID, FullName, MobileNumber, Email, avatar, status, privilege FROM tbluser";
$result = $dbh->query($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['userID'])) {
        $action = $_POST['action'];
        $userID = $_POST['userID'];

        switch ($action) {
            case 'block':
                updatePrivilege($userID, 'Blocked');
                echo "<script>window.location.href='roomuser.php';</script>";
                break;

            case 'unblock':
                updatePrivilege($userID, 'Unblocked');
                echo "<script>window.location.href='roomuser.php';</script>";
                break;

            case 'delete':
                deleteUsers([$userID]);
                echo "<script>window.location.href='roomuser.php';</script>";
                break;
        }
    }
}

function updatePrivilege($userID, $newPrivilege) {
    global $dbh;

    $updateSql = "UPDATE tbluser SET privilege = ? WHERE ID = ?";
    $stmt = $dbh->prepare($updateSql);
    $stmt->bindParam(1, $newPrivilege, PDO::PARAM_STR);
    $stmt->bindParam(2, $userID, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
}

function deleteUsers($userIDs) {
    global $dbh;

    $userIDsString = implode(',', $userIDs);
    $deleteSql = "DELETE FROM tbluser WHERE ID IN ({$userIDsString})";
    $stmt = $dbh->prepare($deleteSql);
    $stmt->execute();
    $stmt->closeCursor();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AMETHYST HOTEL</title>
    <!-- Bootstrap Styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom Styles -->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <!-- jQuery -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
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
                        <a  class="active-menu" href="roomuser.php"><i class="fa fa-plus-circle"></i>Users</a>
                    </li>
					<li>
                        <a   href="room.php"><i class="fa fa-plus-circle"></i>Add Room</a>
                    </li>
                    <li>
                        <a  href="roomdel.php"><i class="fa fa-desktop"></i> Delete Room</a>
                    </li>
					

                    
            </div>

        </nav>
        <!-- /. NAV SIDE  -->
       
        
       
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            USERS <small></small>
                        </h1>
                    </div>
                </div>

                <!-- Display user table -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Users Information
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <form action="" method="post">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Full Name</th>
                                                    <th>Mobile Number</th>
                                                    <th>Email</th>
                                                    <th>Avatar</th>
                                                    <th>Status</th>
                                                    <th>Privilege</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                                    echo "<tr>";
                                                    echo "<td>{$row['ID']}</td>";
                                                    echo "<td>{$row['FullName']}</td>";
                                                    echo "<td>{$row['MobileNumber']}</td>";
                                                    echo "<td>{$row['Email']}</td>";
                                                    echo "<td><img src='../images/avatar/{$row['avatar']}' alt='Avatar' height='50' width='50'></td>";
                                                    echo "<td>{$row['status']}</td>";
                                                    echo "<td>{$row['privilege']}</td>";
                                                    echo "<td>
                                                        <button type='submit' class='btn btn-warning btn-xs' name='action' value='block'>Block</button>
                                                        <button type='submit' class='btn btn-success btn-xs' name='action' value='unblock'>Unblock</button>
                                                        <button type='submit' class='btn btn-danger btn-xs' name='action' value='delete'>Delete</button>
                                                        <input type='hidden' name='userID' value='{$row['ID']}'>
                                                      </td>";
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End user table -->
            </div>
        </div>
    </div>
</body>
</html>