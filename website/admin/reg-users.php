<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include '../PHPMailer/src/Exception.php';
include '../PHPMailer/src/PHPMailer.php';
include '../PHPMailer/src/SMTP.php';

session_start();

error_reporting(0);

include('includes/dbconnection.php');

if (strlen($_SESSION['hbmsaid']==0)) {

  header('location:logout.php');

  } else{

	if (isset($_GET['deleteid']))
	{
		$eid = $_GET['deleteid'];
		
		$sql = "delete from tbluser where ID=:eid";
		$query = $dbh->prepare($sql);
		$query->bindParam(':eid', $eid, PDO::PARAM_STR);
        $query->execute();

		echo '<script>alert("User has been deleted.")</script>';

        echo "<script>window.location.href ='reg-users.php'</script>";

	}

	if (isset($_GET['resend']))
	{
		$code=md5(rand());
		$email = $_GET['resend'];
		$con="update tbluser set code=:code where Email=:email";

		$resend = $dbh->prepare($con);

		$resend->bindParam(':email', $eid, PDO::PARAM_STR);

		$resend->bindParam(':code',$code,PDO::PARAM_STR);

		$resend->execute();

		echo "<div style='display: none;'>";
		//Create an instance; passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
			//Server settings
			$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
			$mail->isSMTP();                                            //Send using SMTP
			$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
			$mail->Username   = 'hoteldygrandebookings@gmail.com';                     //SMTP username
			$mail->Password   = 'qocelxigcsjegykm';                               //SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
			$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
		
			//Recipients
			$mail->setFrom('hoteldygrandebookings@gmail.com');
			$mail->addAddress($email);
		
			//Content
			$mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Account Activation';
            $mail->Body    = 'Here is the activation verification link <b><a href="http://localhost/hoteldygrande/signin.php?verification='.$code.'">http://localhost/hoteldygrande/signin.php?verification='.$code.'</a></b>';
		
			$mail->send();
			echo 'Message has been sent';
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}

		echo "<script>
		alert('Verification link sent.');
		window.location.href='reg-users.php';
		</script>";
	}



?>

<!DOCTYPE HTML>

<html>

<head>

<title>Hotel Dy Grande | Reg Users</title>



<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Custom CSS -->

<link href="css/style.css" rel='stylesheet' type='text/css' />

<!-- Graph CSS -->

<link href="css/font-awesome.css" rel="stylesheet"> 

<!-- jQuery -->

<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>

<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

<!-- lined-icons -->

<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />

<script src="js/simpleCart.min.js"> </script>

<script src="js/amcharts.js"></script>	

<script src="js/serial.js"></script>	

<script src="js/light.js"></script>	

<!-- //lined-icons -->

<script src="js/jquery-1.10.2.min.js"></script>

   <!--pie-chart--->

<script src="js/pie-chart.js" type="text/javascript"></script>

 <script type="text/javascript">



        $(document).ready(function () {

            $('#demo-pie-1').pieChart({

                barColor: '#3bb2d0',

                trackColor: '#eee',

                lineCap: 'round',

                lineWidth: 8,

                onStep: function (from, to, percent) {

                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');

                }

            });



            $('#demo-pie-2').pieChart({

                barColor: '#fbb03b',

                trackColor: '#eee',

                lineCap: 'butt',

                lineWidth: 8,

                onStep: function (from, to, percent) {

                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');

                }

            });



            $('#demo-pie-3').pieChart({

                barColor: '#ed6498',

                trackColor: '#eee',

                lineCap: 'square',

                lineWidth: 8,

                onStep: function (from, to, percent) {

                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');

                }

            });



           

        });



    </script>

</head> 

<body>

   <div class="page-container">

   <!--/content-inner-->

	<div class="left-content">

	   <div class="inner-content">

		<!-- header-starts -->

			<?php include_once('includes/header.php');?>

				

				<!--content-->

			<div class="content">

<div class="women_main">

	<!-- start content -->

	<div class="grids">

					<div class="progressbar-heading grids-heading">

						<h2>Register Users</h2>

					</div>

					<div class="panel panel-widget forms-panel">

						<div class="forms">

							<div class="form-grids widget-shadow" data-example-id="basic-forms"> 

								<div class="form-title">

									<h4>Register Users </h4>

								</div>

								<div class="form-body">

									

									     <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">

                                <thead>

                                    <tr>

                                        <th class="text-center">S.No</th>

                                        <th>Name</th>

                                        <th class="d-none d-sm-table-cell">Mobile Number</th>

                                        <th class="d-none d-sm-table-cell">Email</th>

										<th class="d-none d-sm-table-cell">Status</th>

                                        <th class="d-none d-sm-table-cell">Reg Date</th>

                                        <th class="text-center" >Action</th>

                                       </tr>

                                </thead>

                                <tbody>

                                    <?php

                                    if (isset($_GET['pageno'])) {

            $pageno = $_GET['pageno'];

        } else {

            $pageno = 1;

        }

        // Formula for pagination

        $no_of_records_per_page = 6;

        $offset = ($pageno-1) * $no_of_records_per_page;

       $ret = "SELECT ID FROM tbluser";

$query1 = $dbh -> prepare($ret);

$query1->execute();

$results1=$query1->fetchAll(PDO::FETCH_OBJ);

$total_rows=$query1->rowCount();

$total_pages = ceil($total_rows / $no_of_records_per_page);



$sql="SELECT * from tbluser LIMIT $offset, $no_of_records_per_page";

$query = $dbh -> prepare($sql);

$query->execute();

$results=$query->fetchAll(PDO::FETCH_OBJ);

if ($pageno == 1) {
	$cnt=1;
}
elseif ($pageno == 2) {
	$cnt=7;
}
else{
	$cnt=13;
}

if($query->rowCount() > 0)

{

foreach($results as $row)

{               ?>

                                    <tr>

                                        <td class="text-center"><?php echo htmlentities($cnt);?></td>

                                        <td class="font-w600"><?php  echo htmlentities($row->FullName);?></td>

                                        <td class="d-none d-sm-table-cell"><?php  echo htmlentities($row->MobileNumber);?></td>

                                        <td class="d-none d-sm-table-cell"><?php  echo htmlentities($row->Email);?></td>

                                        <td class="d-none d-sm-table-cell"><?php  if ($row->status == 1){
											echo htmlentities("verfied");
										} else {
											echo htmlentities("pending");
										}
											?></td>

                                        <td class="d-none d-sm-table-cell">

                                            <span class="badge badge-primary"><?php  echo htmlentities($row->RegDate);?></span>

                                        </td>

										<td class="d-none d-sm-table-cell" align="center">
										
											<a href='reg-users.php?deleteid=<?php  echo htmlentities($row->ID);?>'>
    										<button type="submit" class="btn btn-danger" name="delete" onclick="return confirm('Delete this user?')">Delete</button>
											</a></td>

                                    </tr>

                                    <?php $cnt=$cnt+1;}} ?> 

                                

                                

                                  

                                </tbody>

                            </table>

<div align="left">

    <ul class="pagination" >

        <li><a href="?pageno=1"><strong>First></strong></a></li>

        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">

            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"><strong style="padding-left: 10px">Prev></strong></a>

        </li>

        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">

            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>"><strong style="padding-left: 10px">Next></strong></a>

        </li>

        <li><a href="?pageno=<?php echo $total_pages; ?>"><strong style="padding-left: 10px">Last</strong></a></li>

    </ul>

</div>

								</div>

							</div>

						</div>

					</div>

			

	

				</div>



	<!-- end content -->

	

<?php include_once('includes/footer.php');?>

</div>



</div>

			<!--content-->

		</div>

</div>

				<!--//content-inner-->

			<!--/sidebar-menu-->

			<?php include_once('includes/sidebar.php');?>

							  <div class="clearfix"></div>		

							</div>

							<script>

							var toggle = true;

										

							$(".sidebar-icon").click(function() {                

							  if (toggle)

							  {

								$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");

								$("#menu span").css({"position":"absolute"});

							  }

							  else

							  {

								$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");

								setTimeout(function() {

								  $("#menu span").css({"position":"relative"});

								}, 400);

							  }

											

											toggle = !toggle;

										});

							</script>

<!--js -->

<script src="js/jquery.nicescroll.js"></script>

<script src="js/scripts.js"></script>

<!-- Bootstrap Core JavaScript -->

   <script src="js/bootstrap.min.js"></script>

   <!-- /Bootstrap Core JavaScript -->

   <!-- real-time -->

<script language="javascript" type="text/javascript" src="js/jquery.flot.js"></script>

	<script type="text/javascript">



	$(function() {



		// We use an inline data source in the example, usually data would

		// be fetched from a server



		var data = [],

			totalPoints = 300;



		function getRandomData() {



			if (data.length > 0)

				data = data.slice(1);



			// Do a random walk



			while (data.length < totalPoints) {



				var prev = data.length > 0 ? data[data.length - 1] : 50,

					y = prev + Math.random() * 10 - 5;



				if (y < 0) {

					y = 0;

				} else if (y > 100) {

					y = 100;

				}



				data.push(y);

			}



			// Zip the generated y values with the x values



			var res = [];

			for (var i = 0; i < data.length; ++i) {

				res.push([i, data[i]])

			}



			return res;

		}



		// Set up the control widget



		var updateInterval = 30;

		$("#updateInterval").val(updateInterval).change(function () {

			var v = $(this).val();

			if (v && !isNaN(+v)) {

				updateInterval = +v;

				if (updateInterval < 1) {

					updateInterval = 1;

				} else if (updateInterval > 2000) {

					updateInterval = 2000;

				}

				$(this).val("" + updateInterval);

			}

		});



		var plot = $.plot("#placeholder", [ getRandomData() ], {

			series: {

				shadowSize: 0	// Drawing is faster without shadows

			},

			yaxis: {

				min: 0,

				max: 100

			},

			xaxis: {

				show: false

			}

		});



		function update() {



			plot.setData([getRandomData()]);



			// Since the axes don't change, we don't need to call plot.setupGrid()



			plot.draw();

			setTimeout(update, updateInterval);

		}



		update();



		// Add the Flot version string to the footer



		$("#footer").prepend("Flot " + $.plot.version + " &ndash; ");

	});



	</script>

<!-- /real-time -->

<script src="js/jquery.fn.gantt.js"></script>

    <script>



		$(function() {



			"use strict";



			$(".gantt").gantt({

				source: [{

					name: "Sprint 0",

					desc: "Analysis",

					values: [{

						from: "/Date(1320192000000)/",

						to: "/Date(1322401600000)/",

						label: "Requirement Gathering", 

						customClass: "ganttRed"

					}]

				},{

					name: " ",

					desc: "Scoping",

					values: [{

						from: "/Date(1322611200000)/",

						to: "/Date(1323302400000)/",

						label: "Scoping", 

						customClass: "ganttRed"

					}]

				},{

					name: "Sprint 1",

					desc: "Development",

					values: [{

						from: "/Date(1323802400000)/",

						to: "/Date(1325685200000)/",

						label: "Development", 

						customClass: "ganttGreen"

					}]

				},{

					name: " ",

					desc: "Showcasing",

					values: [{

						from: "/Date(1325685200000)/",

						to: "/Date(1325695200000)/",

						label: "Showcasing", 

						customClass: "ganttBlue"

					}]

				},{

					name: "Sprint 2",

					desc: "Development",

					values: [{

						from: "/Date(1326785200000)/",

						to: "/Date(1325785200000)/",

						label: "Development", 

						customClass: "ganttGreen"

					}]

				},{

					name: " ",

					desc: "Showcasing",

					values: [{

						from: "/Date(1328785200000)/",

						to: "/Date(1328905200000)/",

						label: "Showcasing", 

						customClass: "ganttBlue"

					}]

				},{

					name: "Release Stage",

					desc: "Training",

					values: [{

						from: "/Date(1330011200000)/",

						to: "/Date(1336611200000)/",

						label: "Training", 

						customClass: "ganttOrange"

					}]

				},{

					name: " ",

					desc: "Deployment",

					values: [{

						from: "/Date(1336611200000)/",

						to: "/Date(1338711200000)/",

						label: "Deployment", 

						customClass: "ganttOrange"

					}]

				},{

					name: " ",

					desc: "Warranty Period",

					values: [{

						from: "/Date(1336611200000)/",

						to: "/Date(1349711200000)/",

						label: "Warranty Period", 

						customClass: "ganttOrange"

					}]

				}],

				navigate: "scroll",

				scale: "weeks",

				maxScale: "months",

				minScale: "days",

				itemsPerPage: 10,

				onItemClick: function(data) {

					alert("Item clicked - show some details");

				},

				onAddClick: function(dt, rowId) {

					alert("Empty space clicked - add an item!");

				},

				onRender: function() {

					if (window.console && typeof console.log === "function") {

						console.log("chart rendered");

					}

				}

			});



			$(".gantt").popover({

				selector: ".bar",

				title: "I'm a popover",

				content: "And I'm the content of said popover.",

				trigger: "hover"

			});



			prettyPrint();



		});



    </script>

		   <script src="js/menu_jquery.js"></script>



		   <script src="js/pages/be_tables_datatables.js"></script>

</body>

</html><?php }  ?>