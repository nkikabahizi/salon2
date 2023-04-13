<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {

	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>HDSMS| Loans management</title>
		<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link type="text/css" href="css/theme.css" rel="stylesheet">
		<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
		<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
			rel='stylesheet'>
		<link rel="stylesheet" href="chosen.css">
		<link rel="stylesheet" href="docsupport/prism.css">
		<link rel="stylesheet" href="chosen.css">
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
									<a href="deductions.php?mon=<?php echo $mon; ?>#deductions"> <button class="btn btn-primary">Deductions</button></a>
								</div>
								<h3>Manage loans</h3>
								<div class="module-body">

									<?php if (isset($_POST['submit'])) { ?>
										<div class="alert alert-success">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Loan saved!</strong>
											<?php echo htmlentities($_SESSION['msg']); ?>
											<?php echo htmlentities($_SESSION['msg'] = ""); ?>
										</div>
									<?php } ?>


									<?php if (isset($_POST['del'])) { ?>
										<div class="alert alert-error">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Oh snap!</strong>
											<?php echo htmlentities($_SESSION['delmsg']); ?>
											<?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
										</div>
									<?php } ?>

									<br />

									<form class="form-horizontal row-fluid" method="post">
										<div class="control-group">
											<label class="control-label" for="basicinput">Employee</label>
											<div class="controls">
												<script>
													function getloaninfo(val) {
														$.ajax({
															type: "POST",
															url: "get_loaninfo.php",
															data: 'employeeid=' + val,
															success: function (data) {
																$("#hisloan").html(data);
															}
														});
													}
												</script>

												<select name="employeeid" onChange="getloaninfo(this.value);"
													class="chosen-select span8 tip" multiple tabindex="4" name="employee"
													data-placeholder="Choose employee">
													<?php
													$salonid = $_SESSION['salonid'];
													$selectemployees = mysqli_query($conn, "SELECT * FROM employees WHERE SalonId = $salonid");
													while ($employee = mysqli_fetch_array($selectemployees)) {
														?>
														<option value="<?php echo $employee['EmployeeId']; ?>"><?php echo $employee['FullName']; ?></option>

														<?php
													}
													?>
												</select>
											</div>
										</div>
										<div id="hisloan" class="control-group">


										</div>
										<div id="hisloan" class="control-group">
											<label class="control-label" for="basicinput">New loan</label>
											<div class="controls" id="hisloan">

												<input type='text' name="amount">RWF

											</div>
										</div>
										<div id="hisloan" class="control-group">
											<label class="control-label" for="basicinput">Payment percentage</label>
											<div class="controls" id="hisloan">

												<input type='text' name="percentage">%

											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="basicinput">Description</label>
											<div class="controls">
												<textarea class="span8" name="description" rows="5"></textarea>
											</div>
										</div>

										<div class="control-group">
											<div class="controls">
												<button type="submit" name="submit" class="btn">Create</button>
											</div>
										</div>
									</form>
								</div>
							</div>
							<?php
							if (isset($_POST['submit'])) {
								$amount = $_POST['amount'];
								$employeeid = $_POST['employeeid'];
								$description = $_POST['description'];
								$day = date('d');
								$mon = date('m');
								$year = date('Y');
								$percentage=$_POST['percentage'];
								$saveloan = mysqli_query($conn, "INSERT INTO loans(EmployeeId,Amount,PercentagePayment,Description,Day,Mon,Year) VALUES ('$employeeid', '$amount', '$percentage', '$description', '$day', '$mon', '$year')");

							}
							?>


							<div class="module">
								<div class="module-head">
									<form method='GET' action="loans.php#loans">
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
									Current : <b>
										<?php echo $monthname; ?>
									</b>
								</div>
								<div class="module-body table" id="loans">
									<table cellpadding="0" cellspacing="0" border="0"
										class="datatable-1 table table-bordered table-striped	 display" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>Names</th>
												<th>Amount</th>
												<th>Percentages</th>
												<th>Dates</th>
												<th>Reason</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>

											<?php
											$salonid = $_SESSION['salonid'];
											$mon = $_GET['mon'];
											$totalloans=0;
											$query = mysqli_query($conn, "select * from employees,loans WHERE employees.EmployeeId=loans.EmployeeId AND employees.SalonId = '$salonid' AND loans.Mon = $mon");
											$cnt = 1;
											while ($row = mysqli_fetch_array($query)) {
												?>
												<tr>
													<td>
														<?php echo htmlentities($cnt); ?>
													</td>
													<td>
														<?php echo htmlentities($row['FullName']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['Amount'])."RWF"; ?>
													</td>
													<td>
														<?php echo htmlentities($row['PercentagePayment'])."%"; ?>
													</td>
													<td>
														<?php echo $row['Day'] . "-" . $row['Mon'] . "-" . $row['Year']; ?>
													</td>
													<td>
														<?php echo htmlentities($row['Description']); ?>
													</td>
													<td>
														<a href="#"><i class="icon-edit"></i></a>
														<a href="#"
															onClick="return confirm('You are about to delete loan records which is not going to be rolled back, please comfirm your action')"><i
																class="icon-remove-sign"></i></a>
													</td>
												</tr>
												<?php $cnt = $cnt + 1;
												$totalloans = $totalloans + $row['Amount'];
											} ?>
											<tfoot>
											<tr>
												<td></td>
												<td><b>Total Loans</b></td>
												<td><b><?php echo $totalloans ."RWF"; ?></b></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>

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
		<script src="docsupport/jquery-3.2.1.min.js" type="text/javascript"></script>
		<script src="chosen.jquery.js" type="text/javascript"></script>
		<script src="docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
		<script src="docsupport/init.js" type="text/javascript" charset="utf-8"></script>
	</body>
<?php } ?>