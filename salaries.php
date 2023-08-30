<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	date_default_timezone_set('Asia/Kolkata'); // change according timezone
	$currentTime = date('d-m-Y h:i:s A', time());


	if (isset($_POST['submit'])) {
		$name = $_POST['name'];
		$role = $_POST['role'];
		$location = $_POST['location'];
		$id = $_POST['id'];
		$contacts = $_POST['contacts'];
		$description = $_POST['description'];
		$userid = $_SESSION['id'];
		$salonid = $_SESSION['salonid'];
		$sql = mysqli_query($conn, "insert into employees(FullName,Location,Contacts,IdNumber,Poste,Description,UserId,SalonId) values('$name','$location', '$contacts', '$id', '$role', '$description', '$userid', '$salonid')");
		$employeeid = $conn->insert_id;
		$_SESSION['msg'] = "Category Created !!";
		echo "<script>window.location='add-contract.php?employeeid=$employeeid';</script>";

	}

	if (isset($_GET['del'])) {
		mysqli_query($con, "delete from category where id = '" . $_GET['id'] . "'");
		$_SESSION['delmsg'] = "Category deleted !!";
	}

	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>HDSMS| Salaries</title>
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
									<h3>Generate Payroll</h3>
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


									<?php if (isset($_GET['del'])) { ?>
										<div class="alert alert-error">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Oh snap!</strong>
											<?php echo htmlentities($_SESSION['delmsg']); ?>
											<?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
										</div>
									<?php } ?>

									<br />
									<script>
										function getAllowance(val) {
											$.ajax({
												type: "POST",
												url: "getallowance.php",
												data: 'type=' + val,
												success: function (data) {
													$("#allowance").html(data);
												}
											});
										}
									</script>

									<form class="form-horizontal row-fluid" name="Category" method="GET" action="payroll.php">

										<div class="control-group">
											<label class="control-label" for="basicinput">Select Payment frequency</label>
											<div class="controls">
												<select type="text" name="type" class="span8 tip"
													onChange="getAllowance(this.value)" id="type">
													<option>Selecte Frequency</option>
													<option value="1">1 Day Payments</option>
													<option value="15">15 Days Payments</option>
													<option value="30">30 Days Payments</option>
												</select>
											</div>
										</div>
										<div class="control-group" id="allowance">

										</div>




										<div class="control-group">
											<label class="control-label" for="basicinput">Description</label>
											<div class="controls">
												<textarea class="span8" name="description" rows="5"></textarea>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="basicinput">Compute Loans</label>
											<div class="controls">
											<input type="checkbox" name="loans" value="1">*all employees on payroll with loans will pay their percentages

											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="basicinput">Computedeductions</label>
											<div class="controls">
												<input type="checkbox" name="deductions" value="1"> *all employees on payroll with deductions will be deducted
											</div>
										</div>



										<div class="control-group">
											<div class="controls">
												<button type="submit" class="btn">Generate</button>
											</div>
										</div>
									</form>
								</div>
							</div>


							<div class="module" id="salaries">
								<div class="module-head">
								<?php
									$mon = $_GET['mon'];
									switch ($mon) {
										case '1':
											$monthname = 'January';
											break;
										case '2':
											$monthname = 'February';
											break;
										case '3':
											$monthname = 'March';
											break;
										case '4':
											$monthname = 'April';
											break;
										case '5':
											$monthname = 'May';
											break;
										case '6':
											$monthname = 'June';
											break;
										case '7':
											$monthname = 'July';
											break;
										case '8':
											$monthname = 'August';
											break;
										case '9':
											$monthname = 'September';
											break;
										case '10':
											$monthname = 'October';
											break;
										case '11':
											$monthname = 'November';
											break;
										case '12':
											$monthname = 'December';
											break;
										default:
											$mon = date('m');
											break;
									}
									?>

									<h3>Payment History of <?php echo $monthname;?></h3>
									<form method='GET' action="salaries.php#salaries">
										<div>
											<div class="col-md-4">
												<select name="mon" class="span3 tip" required>
													<option value="">Select different month</option>
													<option value="1">January</option>
													<option value="2">February</option>
													<option value="3">March</option>
													<option value="4">April</option>
													<option value="5">May</option>
													<option value="6">June</option>
													<option value="7">July</option>
													<option value="8">August</option>
													<option value="9">September</option>
													<option value="10">October</option>
													<option value="11">November</option>
													<option value="12">December</option>
												</select>
											</div>
											<div class="col-md-4">
												<button type="submit" class="btn btn-primary">Filter<span
														class="icon-filter"> </button>
									</form>
								</div>
									</div>
									</div>
								<div class="module-body table">
									<table cellpadding="0" cellspacing="0" border="0"
										class="datatable-1 table table-bordered table-striped	 display" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>Dates</th>
												<th>Description</th>
												<th>Number of employees</th>
												<th>Total PayOut</th>
												<th>User</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>

											<?php
											$salonid = $_SESSION['salonid'];
											$query = mysqli_query($conn, "select * from payroll,users WHERE payroll.UserId = users.UserId AND users.SalonId = $salonid AND payroll.Month = '$mon' ");
											$cnt = 1;
											while ($row = mysqli_fetch_array($query)) {
												@$totalpayout=$totalpayout + $row['Amount'];
												?>
												<tr>
													<td>
														<?php echo htmlentities($cnt); ?>
													</td>
													<td>
														<?php echo htmlentities($row['Dates']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['Description']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['EmployeesNumber']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['Amount'])." FRW"; ?>
													</td>
													<td>
														<?php echo htmlentities($row['FullName']); ?>
													</td>
													<td>
														<a href="edit-category.php?id=<?php echo $row['PayId'] ?>"><i
																class="icon-eye-open"></i></a>
													</td>
												</tr>
												<?php $cnt = $cnt + 1;
											} ?>
											
										</tbody>
										<tfoot>
										<tr>
											<td></td><td><b>Total Payouts</b></td><td></td><td></td><td><?php echo @$totalpayout ." RWF"; ?></td><td></td><td></td>

											</tr>
										</tfoot>

									</table>
									
								</div>
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
		</script>
	</body>
<?php } ?>