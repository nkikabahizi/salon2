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


							<div class="module" id="report" <?php echo @$ishidden; ?>>
								<div class="module-head">
									<h3>Review</h3>
								</div>
								<div class="module-body table">
									<table cellpadding="0" cellspacing="0" border="0"
										class="datatable-1 table table-bordered table-striped	 display" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>Deductions</th>
												<th>Loans</th>
												<th>Salary</th>
											</tr>
										</thead>
										<tbody>

											<?php
											$salonid = $_SESSION['salonid'];
											$employeeid = $_GET['id'];
											$query = mysqli_query($conn, "select * from salaries WHERE EmployeeId = '$employeeid' AND Status != 0");
											$cnt = 1;
											while ($row = mysqli_fetch_array($query)) {
												?>
												<tr>
													<td>
														<?php echo htmlentities($cnt); ?>
													</td>
													<td>
														<?php $selectdeductions = mysqli_query($conn, "select * from deductions WHERE EmployeeId = '$employeeid' AND Mon= '$mon' ");
														$totaldeductions=0;
														while($deductions = mysqli_fetch_array($selectdeductions))
														{
															$totaldeductions=$totaldeductions + $deductions['Amount'];
														}

														echo $totaldeductions; ?>
													</td>
													<td>
													<?php $selectloans = mysqli_query($conn, "select * from loans WHERE EmployeeId = '$employeeid' AND Mon= '$mon' ");
														$totalloans=0;
														while($loans = mysqli_fetch_array($selectloans))
														{
															$totalloans=$totalloans + $loans['Amount'];
														}

														echo $totalloans; ?>
													</td>
													<td>
														<?php echo $row['Amount']; ?>
													</td>
													
												</tr>
												<?php $cnt = $cnt + 1;
											} ?>

									</table>
								</div>
							</div>
                            /////



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
					if(type == 'expense')
                    {
                        $.ajax({
						url: "include/helper.php",
						type: "POST",
						data: {
							cell_id: cell_id,
							target: 'get_village'
						},
						cache: false,
						success: function (result) {
							$("#select_village").html(result);
						}
					});
                        

                    }
                    else{
                        alert('Rent');


                    }
				});
			});
		</script>

	</body>
<?php } ?>