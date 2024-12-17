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


if (isset($_SESSION['forrec_email']))
{


//this button will show if the user wants to reset password
	echo '<button onclick="changeEmail()">Change Email</button>';



	if(isset($_POST['verify_btn']))
	{
		$otp1=$_POST['otp1'];
		$otp2=$_POST['otp2'];
		$otp3=$_POST['otp3'];
		$otp4=$_POST['otp4'];
		$otp5=$_POST['otp5'];
		$otp6=$_POST['otp6'];

		$email=$_SESSION['forrec_email'];
		$otp=$otp1.$otp2.$otp3.$otp4.$otp5.$otp6;


		$ret="SELECT * FROM tbluser WHERE code='{$otp}' AND Email=:email";
		$query= $dbh -> prepare($ret);
		$query-> bindParam(':email', $email, PDO::PARAM_STR);
		$query-> execute();

		if($query->rowCount() > 0) {
			$_SESSION["forrec_code"] = $otp;

			header("Location: reset-password.php");

		} else {

			echo "<script>alert('OTP verification not matched');</script>";
		}

	}

	if(isset($_GET['resend_otp']))
	{
		if ($_GET['resend_otp'] == "true")
		{

			$email=$_SESSION['forrec_email'];

			$code=mt_rand(111111,999999);
		
			$con="update tbluser set code=:code where Email=:email";

			$sql = $dbh->prepare($con);
			
			$sql->bindParam(':email', $email, PDO::PARAM_STR);
			
			$sql->bindParam(':code',$code,PDO::PARAM_STR);
			
			$sql->execute();

			echo "<div style='display: none;'>";
                    //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'solairehotel17@gmail.com';                     //SMTP username
                        $mail->Password   = 'bticwmgqcgtohqtv';                               //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        //Recipients
                        $mail->setFrom('solairehotel17@gmail.com' , 'SOLAIRE HOTEL');
                        $mail->addAddress($email);

                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'Password Reset';
						$mail->Body    = 'To Recover your account, please use the following One Time Password (OTP): '.$code.'';

                        $mail->send();
                        echo 'Message has been sent';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }

			$_SESSION["forcrea_email"] = $email;

			echo "<script>
				alert('OTP: Password reset code sent to your email');
				window.location.href='verify.php';
			</script>";
		}
	}

}
elseif (isset($_SESSION['forcrea_email']))
{
	if(isset($_POST['verify_btn']))
	{
		$otp1=$_POST['otp1'];
		$otp2=$_POST['otp2'];
		$otp3=$_POST['otp3'];
		$otp4=$_POST['otp4'];
		$otp5=$_POST['otp5'];
		$otp6=$_POST['otp6'];

		$email=$_SESSION['forcrea_email'];
		$otp=$otp1.$otp2.$otp3.$otp4.$otp5.$otp6;
		
		$ret="SELECT * FROM tbluser WHERE code='{$otp}' AND Email=:email";
		$query= $dbh -> prepare($ret);
		$query-> bindParam(':email', $email, PDO::PARAM_STR);
		$query-> execute();

		if($query->rowCount() > 0) {

			$con="update tbluser set status=1 WHERE code='{$otp}' AND Email=:email";
			$ver = $dbh->prepare($con);
			$ver-> bindParam(':email', $email, PDO::PARAM_STR);
			$ver->execute();

			unset($_SESSION['forcrea_email']);
			session_destroy();

			echo "<script>
			alert('Account verification has been successfully completed.');
			window.location.href='signin.php';
			</script>";

		} else {

			echo "<script>alert('OTP verification not matched');</script>";
		}

	}

	if(isset($_GET['resend_otp']))
	{
		if ($_GET['resend_otp'] == "true")
		{

			$email=$_SESSION['forcrea_email'];

			

			$code=mt_rand(111111,999999);

			$query = "SELECT FullName FROM tbluser WHERE Email = :email";
			$stmt = $dbh->prepare($query);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			$fname = $result['FullName'] ?? 'User'; // Default to 'User' if fname is not found
		
			$con="update tbluser set code=:code where Email=:email";

			$sql = $dbh->prepare($con);
			
			$sql->bindParam(':email', $email, PDO::PARAM_STR);
			
			$sql->bindParam(':code',$code,PDO::PARAM_STR);
			
			$sql->execute();

			echo "<div style='display: none;'>";
                    //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'solairehotel17@gmail.com';                     //SMTP username
                        $mail->Password   = 'bticwmgqcgtohqtv';                               //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        //Recipients
                        $mail->setFrom('solairehotel17@gmail.com', 'SOLAIRE HOTEL');
                        $mail->addAddress($email);

                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'FOR VERIFYING YOUR EMAIL';
						$mail->Body    = "
						<p>Dear <strong>$fname</strong>,</p>
						<p>Thank you for registering with us! To activate your account and complete your registration, please use the following One Time Password (OTP):</p>
						<h2 style='color: #5c5c5c;'>$code</h2>
						<p>If you did not register for an account, please ignore this email.</p>
						<p>Best regards,<br>Solaire Hotel Team</p>
					";

                        $mail->send();
                        echo 'Message has been sent';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }

			$_SESSION["forcrea_email"] = $email;

			echo "<script>
				alert('OTP: Account activation code sent to your email');
				window.location.href='verify.php';
			</script>";
		}
	}
}
else{

	header("Location: index.php");
}

?>

<!DOCTYPE HTML>

<html>

<head>



<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />

<link href="css/otp.css" rel="stylesheet" type="text/css" media="all" />

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

function changeEmail() {
    // Redirect to a page where the user can update their email
    window.location.href = 'forgot-password.php';
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

				<div class="contact-grids">

					<div class="container" style="border-style: solid;">

						<div class="row" align="center" >

							<form method="post" name="chngpwd" onSubmit="return valid();">

								

					<h2 style="color: #a58f7c;">
                        <br>Please type the verification <br /></h2>
                       <p> code sent to<br>
                        <span class="phone"><?php 

						if ($_SESSION['forrec_email'] == NULL)
						{
							echo htmlentities ($_SESSION['forcrea_email']);
						}
						else
						{
							echo htmlentities ($_SESSION['forrec_email']);
						}
						
						?></span>
                    </p>


								<br>    
			      
            <form action="verify.php" method="POST" class="mt-5" autocomplete="off">

              <input name="otp1" type="text" class="otp_field" maxlength=1 required onpaste="false" >
              <input name="otp2" type="text" class="otp_field" maxlength=1 required onpaste="false">
              <input name="otp3" type="text" class="otp_field" maxlength=1 required onpaste="false">
              <input name="otp4" type="text" class="otp_field" maxlength=1 required onpaste="false">
			  <input name="otp5" type="text" class="otp_field" maxlength=1 required onpaste="false">
              <input name="otp6" type="text" class="otp_field" maxlength=1 required onpaste="false">

           <p></p><br>
            <button type="submit" name="verify_btn" class='btn btn-primary btn-block'  style="background-color: #a58f7c; width:100px;font-weight:bold;">Verify</button>
			<br>

			<div class="resend-code text-muted">
                    resend your code again?
                    <span class="btn-resend text-danger"><a href="verify.php?resend_otp=true">resend code</span></a><p></p><br>

                </div>
			</form>

						</div>

						<div class="clearfix"></div>

					</div>

				</div><br>

			</div></div>

		<?php include_once('includes/getintouch.php');?>

			</div>

			<?php include_once('includes/footer.php');?>
			<script src="js/otp.js"></script>  
</html>