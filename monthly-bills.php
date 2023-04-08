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
		<title>HDSMS| Today's bills'</title>
		<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link type="text/css" href="css/theme.css" rel="stylesheet">
		<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
		<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
			rel='stylesheet'>
		<script language="javascript" type="text/javascript">
			var popUpWin = 0;
			function popUpWindow(URLStr, left, top, width, height) {
				if (popUpWin) {
					if (!popUpWin.closed) popUpWin.close();
				}
				popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + 600 + ',height=' + 600 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
			}

		</script>
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
									<form method='GET' action="monthly-bills.php">
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
							</div>

						</div>

						<div class="module-body table">
							<?php if (isset($_GET['del'])) { ?>
								<div class="alert alert-error">
									<button type="button" class="close" data-dismiss="alert">×</button>
									<strong>Oh snap!</strong>
									<?php echo htmlentities($_SESSION['delmsg']); ?>
									<?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
								</div>
							<?php } ?>

							<br />


							<table cellpadding="0" cellspacing="0" border="0"
								class="datatable-1 table table-bordered table-striped	 display table-responsive">
								<thead>
									<tr>
										<th>#</th>
										<th width="50">Customer</th>
										<th>Service</th>
										<th>Consumables</th>
										<th>Total bill</th>
										<th>Employee</th>
										<th>Descriptions </th>
										<th>Dates</th>
										<th>Action</th>



									</tr>
								</thead>

								<tbody>
									<?php

									$mon = $_GET['mon'];
									$total = 0;
									$query = mysqli_query($conn, "select * FROM billing,customers,employees,services WHERE billing.CustomerId = customers.CustomerId AND billing.EmployeeId=employees.EmployeeId AND billing.ServiceId = services.ServiceId AND billing.Mon = $mon ORDER BY billing.BillingId DESC");
									$cnt = 1;
									while ($row = mysqli_fetch_array($query)) {
										$billid = $row['BillingId'];

										?>
										<tr>
											<td>
												<?php echo htmlentities($cnt); ?>
											</td>
											<td>
												<?php echo htmlentities($row['fullName']); ?>
											</td>
											<td>
												<?php echo $row['Name']; ?>
											</td>
											<td>
												<ul>

													<?php
													$totalbill = 0;
													$selectproducts = mysqli_query($conn, "SELECT * FROM products,billinginfo WHERE billinginfo.ProductId=products.ProductId AND billinginfo.BillingId = '$billid' ");
													while ($pro = mysqli_fetch_array($selectproducts)) {
														$subtotal = $pro['Quantity'] * $pro['Price'];
														$totalbill = $subtotal + $totalbill;
														?>
														<li>
															<?php echo $pro['Name'] . "(" . $pro['Quantity'] . ")"; ?>
														</li>

														<?php
													}

													?>
												</ul>
											</td>
											<td>
												<?php echo $totalbill; ?>
											</td>
											<td>
												<?php echo htmlentities($row['FullName']); ?>
											</td>
											<td>
												<?php echo $row['Description']; ?>
											</td>
											<td>
												<?php echo $row['DateBill']; ?>
											</td>
											<td> <a href="updateorder.php?oid=<?php echo $billid; ?>" title="Update order"
													target="_blank"><i class="icon-eye-open"></i></a>
											</td>
										</tr>

										<?php $cnt = $cnt + 1;
										$total = $totalbill + $total;
									} ?>
									<tr>
										<td><b>Total bills</b></td>
										<td></td>
										<td></td>
										<td></td>
										<td>
											<?php echo "<b>" . $total ?>
										</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</tbody>
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