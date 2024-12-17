<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');


if (isset($_GET['verification'])) {

	$ret="SELECT * FROM tbluser WHERE code='{$_GET['verification']}' AND status=0";
	$query= $dbh -> prepare($ret);
	$query-> execute();

	if($query->rowCount() > 0) {

		$con="update tbluser set status=1 where code='{$_GET['verification']}'";
		$ver = $dbh->prepare($con);
		$ver->execute();
		
		echo "<script>alert('Account verification has been successfully completed.');</script>";
		
	} else {
		header("Location: index.php");
	}
}


if(isset($_POST['login'])) 
  {
    $email=$_POST['email'];
    $password=md5($_POST['password']);
    $sql ="SELECT ID,status FROM tbluser WHERE Email=:email and Password=:password";
    $query=$dbh->prepare($sql);
    $query->bindParam(':email',$email,PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
{

	
foreach ($results as $result) {
$id=$result->ID;
$status=$result->status;
}


if ($status != 1) {
    unset($_SESSION['forrec_email']);
    $_SESSION["forcrea_email"] = $email;
	$_SESSION['hbmsuid'] = $id;
    $_SESSION['login'] = $_POST['email'];

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
                    <button id='continueBtn' style='background-color: #007bff; color: white; padding: 10px 20px; margin: 10px; border: none; border-radius: 5px; cursor: pointer;'>No, Continue</button>
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
    $_SESSION['hbmsuid'] = $id;
    $_SESSION['login'] = $_POST['email'];
    echo "<script type='text/javascript'> document.location ='index.php'; </script>";
}




} else{
echo "<script>alert('Invalid Details');</script>";
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
<body>
		<!--header-->

			<?php include_once('includes/header.php');?>

<!--header-->
		<!--about-->
		<br>
			
				<div class="contact">
				<div class="container"style="border-style: solid;">
					
				<center><br>
					<h1><a style="color: #a58f7c;">Login Form</a></h1>
          <a style="color: gray;"href="signup.php">not a member yet? click me to register!</a><br>
				<div class="contact-grids">
				
						<div >
							<form method="post">
								<br>
								<h5>Email Address</h5>
								<input style="width:300px;"type="email" class="form-control" value="" name="email" required="true">
								<br><h5>Password</h5>
								<input style="width:300px;"type="password" value="" class="form-control" name="password" required="true">
								
								<a href="forgot-password.php"style="color: #a58f7c;">Forgot your password?</a>
								<br/><br>
								 <input style="background-color: #a58f7c; width:100px;font-weight:bold;" type="submit" value="LOGIN" name="login">
						 	 </form>

						</div>
						<div class="clearfix"></div>
					</div><br>
				</div>
		
</center>
		<?php include_once('includes/getintouch.php');?>
			</div>
			<?php include_once('includes/footer.php');?>
</html>
