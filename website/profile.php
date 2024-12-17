<?php

session_start();

error_reporting(0);

include('includes/dbconnection.php');

if (strlen($_SESSION['hbmsuid']==0)) {

  header('location:logout.php');

  } else{

    if(isset($_POST['submit']))

  {

    $uid=$_SESSION['hbmsuid'];

    $AName=$_POST['fname'];

  	$mobno=$_POST['mobno'];

  $sql="update tbluser set FullName=:name,MobileNumber=:mobilenumber where ID=:uid";

     $query = $dbh->prepare($sql);

     $query->bindParam(':name',$AName,PDO::PARAM_STR);

     $query->bindParam(':mobilenumber',$mobno,PDO::PARAM_STR);

     $query->bindParam(':uid',$uid,PDO::PARAM_STR);

	$query->execute();


	if (isset($_FILES['pp']['name']) AND !empty($_FILES['pp']['name'])) {

		$img_name = $_FILES['pp']['name'];
		$tmp_name = $_FILES['pp']['tmp_name'];
		$error = $_FILES['pp']['error'];
    
		if($error === 0){
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_to_lc = strtolower($img_ex);

            $allowed_exs = array('jpg', 'jpeg', 'png');
            if(in_array($img_ex_to_lc, $allowed_exs)){
               $new_img_name = uniqid($uname, true).'.'.$img_ex_to_lc;
               $img_upload_path = 'images/avatar/'.$new_img_name;

			   move_uploaded_file($tmp_name, $img_upload_path);
               // update the Database
			   $sql2="update tbluser set avatar=:avatar where ID=:uid";
	
			   $query2 = $dbh->prepare($sql2);
			   $query2->bindParam(':uid',$uid,PDO::PARAM_STR);
			   $query2->bindParam(':avatar',$new_img_name,PDO::PARAM_STR);
			   $query2->execute();
            }else {
               $em = "You can't upload files of this type";
               header("Location: ../edit.php?error=$em&$data");
               exit;
            }
         }else {
            $em = "unknown error occurred!";
            header("Location: ../edit.php?error=$em&$data");
            exit;
         }

	}

	echo '<script>alert("Profile has been updated")</script>';


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

		

			<div class="content">

				<div class="contact">

				<div class="container">

					

					<h2 style="color: #a58f7c;">My Profile</h2>
					<p style="color: white;">you edit your details here.</p><br>

					
<center>
				<div class="contact-grids">

					

						<div >

							<form method="post" enctype="multipart/form-data">

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

<div style="position:absolute;border-style: solid;">
<h4 style="color: #a58f7c; margin-top:20px;">My Picture</h4>
<div style="margin-right:20px;">
<?php
	if ($row->avatar == NULL) {
		echo "<img src='images/img.jpg' width='200' height='200' />";
	}
	else {
		echo "<img src='images/avatar/" . $row->avatar ."' width='200' height='200' />";
	}

	?></div></div>

								<h5 style="color:white;">Full Name</h5>

								<input style="width:300px;" type="text" value="<?php  echo $row->FullName;?>" name="fname" required="true" class="form-control">
<br>
								<h5 style="color:white;">Mobile Number</h5>

								<input style="width:300px;"type="text" name="mobno" class="form-control" required="true" maxlength="11" pattern="[0-9]+" value="<?php  echo $row->MobileNumber;?>">	<br>

								<h5 style="color:white;">Email Address</h5>

								<input style="width:300px;"type="email" class="form-control" value="<?php  echo $row->Email;?>" name="email" required="true" readonly='true'><br>

								<h5 style="color:white;">Profile Picture</h5>

								<input style="width:300px;"type="file" name="pp" accept="image/png, image/gif, image/jpeg" class="form-control"><br>

								<h5 style="color:white;">Registration Date</h5>

								<input style="width:300px;"type="text" value="<?php  echo $row->RegDate;?>" class="form-control" name="password" readonly="true"><br>

								<?php $cnt=$cnt+1;}} ?>

								
								 
								 <input style="background-color: #a58f7c; width:100px;font-weight:bold;" type="submit" value="Update" name="submit">

						 	 </form>



						</div>

						

							

						</div>

						<div class="clearfix"></div>

					</div>

				</div>

			
</center>
		<?php include_once('includes/getintouch.php');?>

			</div>

			<?php include_once('includes/footer.php');?>

</html><?php }  ?>

