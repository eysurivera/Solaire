<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

session_start();

error_reporting(0);

include('includes/dbconnection.php');



if(isset($_POST['submit']))

  {

	unset($_SESSION['forcrea_email']);

    $email=$_POST['email'];

	$code=mt_rand(111111,999999);

  	$sql ="SELECT Email FROM tbluser WHERE Email=:email";

	$query= $dbh -> prepare($sql);

	$query-> bindParam(':email', $email, PDO::PARAM_STR);

	$query-> execute();

$results = $query -> fetchAll(PDO::FETCH_OBJ);

if($query -> rowCount() > 0)

{

$con="update tbluser set code=:code where Email=:email";

$resetpwd = $dbh->prepare($con);

$resetpwd->bindParam(':email', $email, PDO::PARAM_STR);

$resetpwd->bindParam(':code',$code,PDO::PARAM_STR);

$resetpwd->execute();

echo "<div style='display: none;'>";
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
	//Server settings
						$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
						$mail->Username   = 'solairehotel17@gmail.com';             //SMTP username
						$mail->Password   = 'bticwmgqcgtohqtv';                     //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        //Recipients
                        $mail->setFrom('amthysthotel@gmail.com');
                        $mail->addAddress($email);

	//Content
	$mail->isHTML(true);                                  //Set email format to HTML
	$mail->Subject = 'Password Reset';
	$mail->Body = "
    <p>Dear User,</p>
    <p>We received a request to recover your account. Please use the One Time Password (OTP) below to proceed:</p>
    <h2 style='color: #5c5c5c;'>$code</h2>
    <p>If you did not request account recovery, you can ignore this email. For further assistance, please contact our support team.</p>
    <p>Best regards,<br>Solaire Hotel Team</p>
";


	$mail->send();
	echo 'Message has been sent';
} catch (Exception $e) {
	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

$_SESSION["forrec_email"] = $email;
header("Location: verify.php");

}

else {

echo "<script>alert('Email id is invalid');</script>"; 

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

<script type="text/javascript">

function valid()

{

if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)

{

alert("New Password and Confirm Password Field do not match  !!");

document.chngpwd.confirmpassword.focus();

return false;

}

return true;

}

</script>

</head>

<body>

		<!--header-->

			

			<?php include_once('includes/header.php');?>


<!--header-->

		<!--about-->

		<br>

			

				<div class="contact">

				<div class="container" style="border-style: solid;">

					
<center><br>
				<h1><a style="color: #a58f7c;">Forgot Password Form</a></h1>
          <a style="color: gray;"href="signin.php">go back</a><br>

					

				<div class="contact-grids">

					

						<div>

							<form method="post" name="chngpwd" onSubmit="return valid();">

								

								<br><h5>Email Address</h5>

								<input style="width:300px;" type="email" placeholder="Email address" class="form-control" value="" name="email" required="true">

								<br/>

								 <input style="background-color: #a58f7c; width:100px;font-weight:bold;"type="submit" value="Reset" name="submit">

						 	 </form>



						</div>

						<div class="clearfix"></div>

					</div><br>

				</div>


		<?php include_once('includes/getintouch.php');?>

			</div>

			<?php include_once('includes/footer.php');?>

</html>