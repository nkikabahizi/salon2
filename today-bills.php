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
									<h3>Today's bills'</h3>
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

											$day = date('d', time());
											$totalservices = 0;
											$totalbill = 0;
											$totalproducts = 0;
											$query = mysqli_query($conn, "select * FROM billing,customers,employees,services WHERE billing.ServiceId = services.ServiceId AND billing.CustomerId = customers.CustomerId AND billing.EmployeeId=employees.EmployeeId AND billing.Day = $day AND billing.Status!=0  ORDER BY billing.BillingId DESC");
											$cnt = 1;
											while ($row = mysqli_fetch_array($query)) {
												$billid = $row['BillingId'];
												$servicefee = $row['ServiceFee'];

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
															$selectbillinfo = mysqli_query($conn, "SELECT products.Price,products.Name,billinginfo.Quantity,products.ProductId FROM billinginfo,products WHERE products.ProductId=billinginfo.ProductId AND billinginfo.BillingId = '$billid' ");
															$price = 0;
															while ($billinfo = mysqli_fetch_array($selectbillinfo)) {
																$productid = $billinfo['ProductId'];																
																$pricee=$billinfo['Price'] * $billinfo['Quantity'];
																$price = $price + $pricee;
																
																	?>
																	<li>
																		<?php echo $billinfo['Name'] . "(" . $billinfo['Quantity'] . ")"; ?>
																	</li>

																	<?php 
																	}

															?>
														</ul>
													</td>
													<td>
														<?php echo  $subprice= $price + $servicefee; ?>
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
													<td> <a href="bill.php?billid=<?php echo $billid; ?>" title="Update order"
															target="_blank"><i class="icon-eye-open"></i></a>
													</td>
												</tr>

												<?php $cnt = $cnt + 1;
												$totalbill=$subprice + $totalbill;
											} ?>
											<tr>
												<td><b>Total bills</b></td>
												<td></td>
												<td></td>
												<td></td>
												<td>
													<?php echo "<b>" . @$totalbill; ?>
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