<?php

session_start();

error_reporting(0);



include('includes/dbconnection.php');

?>

<!DOCTYPE HTML>

<html>

<head>

<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />

<link rel="stylesheet" href="css/lightbox.css">



<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/bootstrap.js"></script>

<script src="js/responsiveslides.min.js"></script>

 <script>

    $(function () {

      $("#slider").responsiveSlides({

      	auto: true,

      	nav: true,

      	speed: 500,

        namespace: "callbacks",

        pager: true,

      });

    });

  </script>



</head>

<body>

		<!--header-->

		

				<?php include_once('includes/header.php');?>


<!--header-->

	<!--rooms-->
<div class="room-section">
    <div class="container">
        <br>
        <h1>Choose your Desired Room</h1>
        <br>
        <div class="room-grids">

            <?php
            $cid = intval($_GET['catid']);
            $limit = 6; // Max number of rooms per page
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Current page
            $offset = ($page - 1) * $limit; // Calculate the starting point

            // Count the total number of rooms
            $countSql = "SELECT COUNT(*) as totalRooms FROM tblroom WHERE RoomType = :cid";
            $countQuery = $dbh->prepare($countSql);
            $countQuery->bindParam(':cid', $cid, PDO::PARAM_STR);
            $countQuery->execute();
            $totalRooms = $countQuery->fetch(PDO::FETCH_OBJ)->totalRooms;
            $totalPages = ceil($totalRooms / $limit); // Calculate total pages

            // Fetch the rooms for the current page
            $sql = "SELECT tblroom.*, tblroom.id as rmid, tblcategory.ID, tblcategory.CategoryName 
                    FROM tblroom 
                    JOIN tblcategory ON tblroom.RoomType = tblcategory.ID 
                    WHERE tblroom.RoomType = :cid 
                    LIMIT :offset, :limit";

            $query = $dbh->prepare($sql);
            $query->bindParam(':cid', $cid, PDO::PARAM_STR);
            $query->bindParam(':offset', $offset, PDO::PARAM_INT);
            $query->bindParam(':limit', $limit, PDO::PARAM_INT);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            if ($query->rowCount() > 0) {
                foreach ($results as $row) { 
					?>
                    <div class="room1">
                        <div class="col-md-5 room-grid" style="padding-bottom: 50px">
                            <a href="#" class="mask" style="color:#a58f7c;">
                                <h1><?php echo htmlentities($row->RoomName); ?></h1>
                                <img src="admin/images/<?php echo $row->Image; ?>" class="mask img-responsive zoom-img" alt="" />
                            </a>
                        </div>
                        <div class="col-md-7 room-grid1">
                            <br><br>
                            <h2>Room Description</h2>
                            <p><?php echo htmlentities($row->RoomDesc); ?></p>
                            <p><b>No of Beds: </b><?php echo htmlentities($row->NoofBed); ?></p>
                            <p><b>Price: PHP</b> <?php echo htmlentities($row->room_price); ?></p>
                            <button style="background-color: #a58f7c; width:140px;">
                                <a style="color:black;" href="book-room.php?rmid=<?php echo $row->rmid; ?>">Book Now</a>
                            </button>
                            <hr>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                <?php }
            } else { ?>
                <p>No rooms found.</p>
            <?php } ?>

            <div class="clearfix"></div>

            <!-- Pagination -->
            <div class="pagination">
                <ul style="list-style-type: none; padding: 0; display: flex; justify-content: center;">
                    <?php if ($page > 1) { ?>
                        <li style="margin: 0 5px;"><a href="?catid=<?php echo $cid; ?>&page=<?php echo $page - 1; ?>" style="text-decoration: none; color: #a58f7c;">&laquo; Prev</a></li>
                    <?php }
                    for ($i = 1; $i <= $totalPages; $i++) { ?>
                        <li style="margin: 0 5px;">
                            <a href="?catid=<?php echo $cid; ?>&page=<?php echo $i; ?>" style="text-decoration: none; color: <?php echo $i == $page ? 'black' : '#a58f7c'; ?>;">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php }
                    if ($page < $totalPages) { ?>
                        <li style="margin: 0 5px;"><a href="?catid=<?php echo $cid; ?>&page=<?php echo $page + 1; ?>" style="text-decoration: none; color: #a58f7c;">Next &raquo;</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

				<!--rooms-->

				<?php include_once('includes/getintouch.php');?>

			</div>

			<!--footer-->

				<?php include_once('includes/footer.php');?>

</body>

</html>

