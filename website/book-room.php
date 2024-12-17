<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include the PHPMailer files
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


include('includes/dbconnection.php');

session_start();

error_reporting(0);

if (strlen($_SESSION['hbmsuid']==0)) {

  header('location:logout.php');

  } else{

	$id=$_SESSION['hbmsuid'];

	$sqlGet="SELECT status from  tbluser where ID=:id";

	$query = $dbh -> prepare($sqlGet);

	$query->bindParam(':id',$id,PDO::PARAM_STR);

	$query->execute();

	$results=$query->fetchAll(PDO::FETCH_OBJ);


	foreach ($results as $result) {
		$id=$result->ID;
		$status=$result->status;
		}


		if ($status != 1) {
		
			echo "
			<script>
			document.addEventListener('DOMContentLoaded', function() {
				// Inject modal HTML into the page
				document.body.insertAdjacentHTML('beforeend', `
					<div id='verificationModal' style='display: block; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);'>
						<div style='margin: 10% auto; padding: 20px; background: white; width: 300px; text-align: center; border-radius: 8px;'>
							<h4>Your account is not yet verified.</h4>
							<p>Would you like to verify it first?</p>
							<button id='verifyBtn' style='background-color: #28a745; color: white; padding: 10px 20px; margin: 10px; border: none; border-radius: 5px; cursor: pointer;'>Yes, Verify</button>
							<button id='continueBtn' style='background-color: #007bff; color: white; padding: 10px 20px; margin: 10px; border: none; border-radius: 5px; cursor: pointer;'>No, I'll verify later</button>
						</div>
					</div>
				`);
		
				// Add event listeners for buttons
				document.getElementById('verifyBtn').addEventListener('click', function() {
					window.location.href = 'verify.php';
				});
		
				document.getElementById('continueBtn').addEventListener('click', function() {
					window.location.href = 'index.php';
				});
			});
			</script>";
		} else {
			
		





	if (isset($_POST['submit'])) {
		$booknum = mt_rand(100000000, 999999999);
		$rid = intval($_GET['rmid']);
		$uid = $_SESSION['hbmsuid'];
		$idtype = $_POST['idtype'];
		$gender = $_POST['gender'];
		$address = $_POST['address'];
		$checkindate = $_POST['checkindate'];
		$checkoutdate = $_POST['checkoutdate'];
		$downPay = $_POST['downPay'];
		$cdate = date('Y-m-d');
	
		if ($checkindate < $cdate) {
			echo '<script>alert("Check-in date must be greater than the current date")</script>';
		} else if ($checkindate > $checkoutdate) {
			echo '<script>alert("Check-out date must be equal to or greater than the check-in date")</script>';
		} else if ($downPay != 2500) {
			echo '<script>alert("Down payment must be equal to 2500 pesos")</script>';
		} else {
			// Check room availability
			$checkAvailabilitySql = "SELECT * FROM tblbooking WHERE RoomId = :rid AND (:checkindate < CheckoutDate AND :checkoutdate > CheckinDate)";
			$checkAvailabilityQuery = $dbh->prepare($checkAvailabilitySql);
			$checkAvailabilityQuery->bindParam(':rid', $rid, PDO::PARAM_STR);
			$checkAvailabilityQuery->bindParam(':checkindate', $checkindate, PDO::PARAM_STR);
			$checkAvailabilityQuery->bindParam(':checkoutdate', $checkoutdate, PDO::PARAM_STR);
			$checkAvailabilityQuery->execute();
	
			if ($checkAvailabilityQuery->rowCount() > 0) {
				echo '<script>alert("Sorry, the room is not available for the selected dates. Please choose different dates.")</script>';
			} else {
				// Proceed with inserting the booking
				$sql = "INSERT INTO tblbooking(RoomId, BookingNumber, UserID, IDType, Gender, Address, CheckinDate, CheckoutDate, downPay) 
						VALUES(:rid, :booknum, :uid, :idtype, :gender, :address, :checkindate, :checkoutdate, :downPay)";
				$query = $dbh->prepare($sql);
				$query->bindParam(':rid', $rid, PDO::PARAM_STR);
				$query->bindParam(':booknum', $booknum, PDO::PARAM_STR);
				$query->bindParam(':uid', $uid, PDO::PARAM_STR);
				$query->bindParam(':idtype', $idtype, PDO::PARAM_STR);
				$query->bindParam(':gender', $gender, PDO::PARAM_STR);
				$query->bindParam(':address', $address, PDO::PARAM_STR);
				$query->bindParam(':checkindate', $checkindate, PDO::PARAM_STR);
				$query->bindParam(':checkoutdate', $checkoutdate, PDO::PARAM_STR);
				$query->bindParam(':downPay', $downPay, PDO::PARAM_STR);
				$query->execute();

	
				$uid = $_SESSION['hbmsuid'];
				$userSql = "SELECT * FROM tbluser WHERE ID = :uid";
				$userQuery = $dbh->prepare($userSql);
				$userQuery->bindParam(':uid', $uid, PDO::PARAM_STR);
				$userQuery->execute();
				$userResult = $userQuery->fetch(PDO::FETCH_ASSOC);
	
				// Send booking confirmation email
				sendBookingConfirmationEmail($userResult, $booknum, $checkindate, $checkoutdate);
	
				echo '<script>alert("Your room has been booked successfully. Booking Number is ' . $booknum . '")</script>';
				echo "<script>window.location.href ='index.php'</script>";
			}
		}
	}
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

<body style="background-color: #212121;">

		<!--header-->

			

			<?php include_once('includes/header.php');?>


<!--header-->

		<!--about-->

		
<center>
			<div class="content">

				<div class="contact">

				<div class="container"><br>

					<h2  style="color: #a58f7c;margin-top:px;">BOOKING FORM</h2>
					<p  style="color: #FFFF;">please fill out the form</p><br>

					

				<div class="contact-grids">

					

						<div>

							<form method="post">

					

									

								</select>

								<?php

$uid=$_SESSION['hbmsuid'];

$sql="SELECT * from  tbluser where ID=:uid";

$query = $dbh -> prepare($sql);

$query->bindParam(':uid',$uid,PDO::PARAM_STR);

$query->execute();

$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;

if($query->rowCount() > 0)

{

foreach($results as $row)

{               ?>
<table style="margin-left:-400px;color:white;"><th><tr><td>
								<p>Name</p>

								<input style="width:300px;"type="text"  value="<?php  echo $row->FullName;?>" name="name" class="form-control" required="true" readonly="true">
</td></tr>
<td>
								<br><h5>Mobile Number</h5>

								<input style="width:300px;"type="text" name="phone" class="form-control" required="true" maxlength="10" pattern="[0-9]+" value="<?php  echo $row->MobileNumber;?>" readonly="true">
</td><tr><td>
								<br><h5>Email Address</h5>

								<input  style="width:300px;"type="email" value="<?php  echo $row->Email;?>" class="form-control" name="email" required="true" readonly="true"><?php $cnt=$cnt+1;}} ?>
</td></tr><tr><td>
<br><h5>ID Type</h5>
								
								<select  style="width:300px;"type="text" value="" class="form-control" name="idtype" required="true" class="form-control">

									<option value="">Choose ID Type</option>

									<option value="Voter Card">Voter Card</option>

									<option value="Driving Licence Card">Driving Licence Card</option>

									<option value="Passport">Passport</option>

									</select>
</td></tr>

<tr><td><br><h5>Gender</h5>

								 <p style="text-align: left;"> <input type="radio"  name="gender" id="gender" value="Female" checked="true">Female</p>

								 

                                 <p style="text-align: left;"> <input type="radio" name="gender" id="gender" value="Male">Male</p>
								 </td></tr></th></table>
								 <table style="float:right;margin-top:-355px;margin-right:250px;color:white;"><th><tr><td>       

								<h5>Address</h5>

								 <textarea 	style="height:200px;width:300px;resize:none;color:black;"type="text" rows="10" name="address" required="true"></textarea>

								<br><h5>Checkin Date</h5>

								<input  style="width:300px;"type="date" value="" class="form-control" name="checkindate" required="true">

								<br><h5>Checkout Date</h5>

								<input  style="width:300px;"type="date" value="" class="form-control" name="checkoutdate" required="true">
								<div style="margin-left: -85px;">
								<br><h5>Down Payment (P2500)</h5>
								</div>
								<input  style="margin-left: -170px;width:300px;"type="text" value="" class="form-control" name="downPay" required="true">
								</table><br>
								<div style="margin-top: 50px;">
        						<input style="background-color: #a58f7c; height:45px;width:100px;font-weight:bold;" type="submit" value="SUBMIT" name="submit">
   							 	</div>
						 	 </form>
<br><br><br>
						</div>

						<div class="clearfix"></div>

					</div>

				</div>

			</div>

		<?php include_once('includes/getintouch.php');?>

			</div>

			<?php include_once('includes/footer.php');?>

</html><?php }  ?>

<?php 
function sendBookingConfirmationEmail($user, $bookingNumber, $checkinDate, $checkoutDate)
{
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'solairehotel17@gmail.com';
        $mail->Password   = 'xcierarrpfshpyzd';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom('solairehotel17@gmail.com');
        $mail->addAddress($user['Email']);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Booking Confirmation';
        $mail->Body    = 'Thank you for booking with us! Your booking details are as follows:<br><br>' .
            'Booking Number: ' . $bookingNumber . '<br>' .
            'Check-in Date: ' . $checkinDate . '<br>' .
            'Check-out Date: ' . $checkoutDate . '<br><br>' .
            'For any inquiries, please contact us.';

        $mail->send();
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>


