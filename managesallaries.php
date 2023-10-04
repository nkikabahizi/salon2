<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	date_default_timezone_set('Africa/Kigali'); // change according timezone
	$currentTime = date('d-m-Y h:i:s A', time());
	$mon = $_GET['mon'];
	$salonid = $_SESSION['salonid'];
	$hairdresser = mysqli_query($conn, "SELECT Amount,Mon FROM salaries,employees WHERE salaries.EmployeeId = employees.EmployeeId AND salaries.Status!=0 AND employees.SalonId = $salonid AND salaries.Mon = '$mon' AND employees.Poste = 'Hair dresser' ");
	$naildresser = mysqli_query($conn, "SELECT Amount,Mon FROM salaries,employees WHERE salaries.EmployeeId = employees.EmployeeId AND salaries.Status!=0 AND employees.SalonId = $salonid AND salaries.Mon = '$mon' AND employees.Poste = 'Nail dresser' ");
	$makeup = mysqli_query($conn, "SELECT Amount,Mon FROM salaries,employees WHERE salaries.EmployeeId = employees.EmployeeId AND salaries.Status!=0 AND employees.SalonId = $salonid AND salaries.Mon = '$mon' AND employees.Poste = 'Make up specialist' ");
	$cnt = 1;
	$totalhair = 0;
	$totalmakeup = 0;
	$totalnail = 0;
	$totalsalaries = $totalhair + $totalmakeup + $totalnail;




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
									<h3>Salaries Overview</h3>
								</div>
								<div class="module-body">
									<div class="jumbotron">
										<h1 class="display-3">Salaries Detailed repport</h1>
										<p class="lead">You can keep track of the previous payrolls and analyse the
											Logistics of your salon</p>
										<hr class="my-2">
										<p class="lead">

										</p>

									</div>

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

									<form class="form-horizontal row-fluid" method="GET" action="managesallaries.php">

										<div class="control-group">
											<label class="control-label" for="basicinput">Filter Month</label>
											<div class="controls row">
												<select name="mon" class="span3 tip" required>
													<option value="<?php echo $_GET['mon']; ?>"><?php echo $monthname; ?>
													</option>
													<option value="01">January</option>
													<option value="02">February</option>
													<option value="03">March</option>
													<option value="04">April</option>
													<option value="05">May</option>
													<option value="06">June</option>
													<option value="07">July</option>
													<option value="08">August</option>
													<option value="09">September</option>
													<option value="10">October</option>
													<option value="11">November</option>
													<option value="12">December</option>
												</select>
												<button type="submit" class="btn btn-info"><span
														class="icon-arrow-right"></span></button>
											</div>

										</div>
									</form>

								</div>
								<div class="control-group" id="allowance">

								</div>
								<div class="container">
									<div class="span2">
										<div class="well">
											<div class="square square-sm"
												style="background:skyblue; height:50px; border-radius:12px;margin-top:-12px">
												...Hair Dressers</div>
											<center>
												<div style="font-weight:bold">
													<h5>
														<?php while ($row1 = mysqli_fetch_array($hairdresser)) {
															@$totalhair = $totalhair + $row1['Amount'];
														}
														echo $totalhair;
														?>
													</h5>
												</div>
											</center>
										</div>
									</div>
									<div class="span2">
										<div class="well">
											<div class="square square-sm"
												style="background:skyblue; height:50px; border-radius:12px;margin-top:-12px">
												...Nail Dresser</div>
											<center>
												<div style="font-weight:bold">
													<h5>
														<?php while ($row2 = mysqli_fetch_array($naildresser)) {
															@$totalnail = $totalnail + $row2['Amount'];
														}
														echo $totalnail;
														?>
													</h5>
												</div>
											</center>
										</div>
									</div>
								
									<div class="span2">
										<div class="well">
											<div class="square square-sm"
												style="background:skyblue; height:50px; border-radius:12px;margin-top:-12px">
												...Makeup Specialist</div>
											<center>
												<div style="font-weight:bold">
													<h5>
														<?php while ($row3 = mysqli_fetch_array($makeup)) {
															@$totalmakeup = $totalmakeup + $row3['Amount'];
														}
														echo $totalmakeup;
														?>
													</h5>
												</div>
											</center>
										</div>
									</div>

								</div>

								<div class="control-group">
									<div class="controls">
										<b>
											<h4>Total salaries : ......
												<?php echo $totalsalaries = $totalhair + $totalmakeup + $totalnail ?>RWF
											</h4>
										</b>
									</div>
								</div>
								</form>
							</div>
						</div>


						<div class="module" id="incomestatement">
							<div class="module-head">
								Income Statement in
								<?php echo $monthname; ?>
							</div>

						</div>
						<div class="module-body table">
							<table cellpadding="0" cellspacing="0" border="0"
								class="datatable-1 table table-bordered table-striped	 display" width="100%">
								<thead>
									<tr>
										<th>Month</th>
										<th>Purchases</th>
										<th>Income</th>
										<th>Salaries & wages</th>
										<th>Expense & Rent</th>
										<th>Net Income</th>
									
									</tr>
								</thead>
								<tbody>

									<?php
									$salonid = $_SESSION['salonid'];
									$selectpurchase = mysqli_query($conn, "select UnitPrice,Quantity from purchases WHERE Mon = '$mon' AND Salonid = '$salonid' ");
									$cnt = 1;
									$totalpurchase = 0;
									while ($row = mysqli_fetch_array($selectpurchase)) {
										$subtotal = $row['UnitPrice'] * $row['Quantity'];
										@$totalpurchase = $totalpurchase + $subtotal;
									}

									 $selectexpenses = mysqli_query($conn, "select * FROM expenses WHERE Mon = '$mon' AND SalonId = $salonid");
											$cnt = 1;
											$totalexpense = 0;
											while ($row = mysqli_fetch_array($selectexpenses)) {
												$subtotall = $row['Amount'];
												@$totalexpense = $totalexpense + $subtotall;
											}
											
											

									 
									$selectbilling = mysqli_query($conn, "select ServiceFee,TotalProducts from billing WHERE Mon = '$mon' AND Salonid = '$salonid' AND billing.Status != 0");
									$cnt = 1;
									$totalbilling = 0;
									while ($row = mysqli_fetch_array($selectbilling)) {
										$subtotal = $row['ServiceFee'] + $row['TotalProducts'];
										@$totalbilling = $totalbilling + $subtotal;
									}
									?>
									<tr>

										<td>
											<?php echo $monthname; ?>
										</td>
										<td>
											<?php echo $totalpurchase; ?>
										</td>
										<td>
											<?php echo $totalbilling . "RWF"; ?>
										</td>
										<td>
											<?php echo $totalsalaries . " RWF"; ?>
										</td>
										<td>
										<?php echo $totalexpense . " RWF"; ?>
											
										</td>
										<td>
											<?php echo $netincome = $totalbilling - $totalpurchase - $totalsalaries - $totalexpense. "RWF"; ?>
										</td>
										
									</tr>

								</tbody>
								<tfoot>

								</tfoot>

							</table>
							<a href="wages-report.php?employeeid=<?php echo $employeeid; ?>&month=<?php echo $mon; ?>" target="_blank"> <button class="btn btn-primary" title="print report"><span class="icon-print"></span></button></a>
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