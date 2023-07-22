<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	if (isset($_POST['submit'])) {
		$name = $_POST['name'];
		$role = $_POST['role'];
		$location = $_POST['location'];
		$id = $_POST['id'];
		$contacts = $_POST['contacts'];
		$description = $_POST['description'];
		$userid = $_SESSION['id'];
		$salonid = $_SESSION['salonid'];
		$sql = mysqli_query($conn, "insert into employees(FullName,Location,Contacts,IdNumber,Poste,Description,UserId,SalonId,Status) values('$name','$location', '$contacts', '$id', '$role', '$description', '$userid', '$salonid', '1')");
		$employeeid = $conn->insert_id;
		$_SESSION['msg'] = "New employee created !!";
		echo "<script>window.location='add-contract.php?employeeid=$employeeid';</script>";

	}

	if (isset($_GET['del'])) {
		$id = $_GET['id'];
		mysqli_query($conn, "UPDATE employees SET Status = 0 WHERE EmployeeId = $id");
		$_SESSION['delmsg'] = "employee deleted !!";
	}

	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>HDSMS| employees</title>
		<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link type="text/css" href="css/theme.css" rel="stylesheet">
		<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
		<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
			rel='stylesheet'>
	</head>

	<body>
		<?php include('include/header.php'); ?>

		<div class="wrapper">
			<div class="container">
				<div class="row">
					<?php include('include/sidebar.php'); ?>
					<div class="span9">
						<div class="content">

							<div class="module">
								<div class="module-head">
									<h3><?php $selectsalon=mysqli_query($conn,"SELECT Name FROM Salon WHERE salonId=$salonid;"); 
                                    while($saloninfo=mysqli_fetch_array($selectsalon)){
                                        echo $saloninfo['Name']." Incident reporting";
                                        
                                    } ?></h3>
								</div>
								<div class="module-body">

									<?php if (isset($_POST['submit'])) { ?>
										<div class="alert alert-success">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Well done!</strong>
											<?php echo htmlentities($_SESSION['msg']); ?>
											<?php echo htmlentities($_SESSION['msg'] = ""); ?>
										</div>
									<?php } ?>


									<?php if (isset($_GET['del'])) {

										?>
										<div class="alert alert-error">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Oh snap!</strong>
											<?php echo htmlentities($_SESSION['delmsg']); ?>
											<?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
										</div>
									<?php } ?>

									<br />

									<form class="form-horizontal row-fluid" name="Category" method="post">										
										<div class="control-group">
											<label class="control-label" for="basicinput">Select Month</label>
											<div class="controls">
												<select name="mon" class="span3 tip" required id="month">
													<option value="">Choose an incidence</option>
													<option value="expense">Expense</option>
													<option value="rent">Rent</option>
												</select>
											</div>
										</div>
									</form>
								</div>
							</div>
							<?php
							if (!empty($_GET['mon'])) {
								$ishidden = "";

							} else {
								$ishidden = "hidden";

							}


							?>


							<div class="module" id="report" >
								
							</div>
                        



						</div><!--/.content-->
					</div><!--/.span9-->
				</div>
			</div><!--/.container-->
		</div><!--/.wrapper-->

		<?php include('include/footer.php'); ?>

		<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
		<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
		<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
		<script src="scripts/datatables/jquery.dataTables.js"></script>
		<script>
			$(document).ready(function () {
				$('.datatable-1').dataTable();
				$('.dataTables_paginate').addClass("btn-group datatable-pagination");
				$('.dataTables_paginate > a').wrapInner('<span />');
				$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
				$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
			});
			// Start Select District
			$(document).ready(function () {
				$('#month').on('change', function () {
					var type = this.value;
					const currentDate = new Date();
					const currentMonth = currentDate.getMonth();
					const mon = currentMonth + 1;
					if(type == 'expense')
                    {
                        $.ajax({
						url: "expense.php",
						type: "POST",
						data: {
							mon:mon,	
							target: 'expense'
						},
						cache: false,
						success: function (result) {
							$("#report").html(result);
						}
					});
                        

                    }
                    if(type == 'rent'){
                        
						$.ajax({
						url: "rent.php",
						type: "POST",
						

						data: {
							mon:mon,							
							target: 'getrent'
						},
						cache: false,
						success: function (result) {
							$("#report").html(result);
						}
					});


                    }
					else
					{
						$.ajax({
						url: "selectreport.php",
						type: "POST",
						

						data: {						
							target: 'select'
						},
						cache: false,
						success: function (result) {
							$("#report").html(result);
						}
					});

						

					}
				});
			});
		</script>

	</body>
<?php } ?>