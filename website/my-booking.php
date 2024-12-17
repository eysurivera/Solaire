<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include('includes/dbconnection.php');

session_start();

error_reporting(0);

if (strlen($_SESSION['hbmsuid']==0)) {

  header('location:logout.php');

  } else{
	if (isset($_POST['cancelBooking'])) {
        $bookingId = $_POST['bookingId'];
        $cancelStatus = "Cancelled";

		$getUserEmail = "SELECT Email FROM tbluser WHERE ID = :userId";
        $stmt = $dbh->prepare($getUserEmail);
        $stmt->bindParam(':userId', $_SESSION['hbmsuid'], PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $userEmail = $result['Email'];

        // Update booking status
        $sql = "UPDATE tblbooking SET Status=:cancelStatus WHERE ID=:bookingId";
        $query = $dbh->prepare($sql);
        $query->bindParam(':cancelStatus', $cancelStatus, PDO::PARAM_STR);
        $query->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
        $query->execute();

        // Send cancellation email
        sendCancellationEmail($userEmail);
    }
?>

<!DOCTYPE HTML>

<html>

<head>

<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />



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

		<!-- typography -->

	<div class="typography">

			<!-- container-wrap -->

			<div class="container">

				<div class="typography-info">
<br>
					<h2 class="type">My Transactions</h2>

				</div>

				

				<div class="bs-docs-example">

					<table class="table table-bordered">

						<thead>

							<tr>

								<th>#</th>

								<th>Booking Number</th>

								<th>Name</th>

								<th>Mobile Number</th>

								<th>Email</th>

								<th>Status</th>

								<th>Action</th>

							</tr>

						</thead>

						<tbody>

							<?php

                                            $uid= $_SESSION['hbmsuid'];

$sql="SELECT tbluser.*,tblbooking.BookingNumber,tblbooking.Status,tblbooking.ID as bid from tblbooking join tbluser on tblbooking.UserID=tbluser.ID where UserID=:uid";



$query = $dbh -> prepare($sql);

$query-> bindParam(':uid', $uid, PDO::PARAM_STR);

$query->execute();

$results=$query->fetchAll(PDO::FETCH_OBJ);



$cnt=1;

if($query->rowCount() > 0)

{

foreach($results as $row)

{               ?>

<tr>
    <td><?php echo htmlentities($cnt); ?></td>
    <td><?php echo htmlentities($row->BookingNumber); ?></td>
    <td><?php echo htmlentities($row->FullName); ?></td>
    <td><?php echo htmlentities($row->MobileNumber); ?></td>
    <td><?php echo htmlentities($row->Email); ?></td>
    <td><?php echo $row->Status ? htmlentities($row->Status) : "Still Pending"; ?></td>
    <td>
        <a href="view-application-detail.php?viewid=<?php echo htmlentities($row->bid); ?>" class="btn btn-danger">View</a>
        <?php if ($row->Status !== "Cancelled") { ?>
            <form method="post" style="display: inline;">
                <input type="hidden" name="bookingId" value="<?php echo $row->bid; ?>">
                <button type="submit" name="cancelBooking" class="btn btn-warning" onclick="return confirm('Are you sure you want to cancel this booking?')">Cancel</button>
            </form>
        <?php } ?>
    </td>
</tr>


							<?php $cnt=$cnt+1;}} ?>

							

						</tbody>

					</table>

				</div>

			

			</div>

			<!-- //container-wrap -->

	</div>

	<!-- //typography -->



			<?php include_once('includes/getintouch.php');?>

			</div>

			<!--footer-->

				<?php include_once('includes/footer.php');?>

</body>

</html><?php }  ?>

<?php
function sendCancellationEmail($email)
{
    $mail = new PHPMailer(true);
    try {
        // Set SMTPDebug to 0 to suppress debug output
        $mail->SMTPDebug = 0;

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'solairehotel17@gmail.com';
        $mail->Password   = 'bticwmgqcgtohqtv';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('solairehotel17@gmail.com');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Booking Cancellation';
        $mail->Body    = 'Your booking has been cancelled.';

        $mail->send();
        echo "<script>alert('Cancellation Email has been sent succesfully.');</script>";
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>