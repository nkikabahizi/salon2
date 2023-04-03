<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	date_default_timezone_set('Asia/Kolkata'); // change according timezone
	$currentTime = date('d-m-Y h:i:s A', time());
	if (isset($_POST['continue'])) {
		$quantity = $_POST['quantity'];
		$description = $_POST['description'];
		$salonid = $_SESSION['salonid'];
		foreach ($quantity as $product => $qty) {
			$keep = mysqli_query($conn, "SELECT Quantity,Price FROM products WHERE ProductId = '$product'");
			$currentquantity = mysqli_fetch_array($keep);
			$cqty = $currentquantity['Quantity'];
			$price = $currentquantity['Price'];
			$newq = $cqty + $qty;
			$keep = mysqli_query($conn, "insert into purchases(ProductId,Quantity,UnitPrice,Description,SalonId) values('$product','$qty', '$price', '$description', '$salonid')");
			$change = mysqli_query($conn, "update products SET Quantity = '$newq' WHERE ProductId = '$product'");
			if ($keep == 1) {
				header('location:purchase-sales.php');
			} else {
				echo mysqli_error($conn);
			}
		}
	}



	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>HDSMS| Purchase sales</title>
		<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link type="text/css" href="css/theme.css" rel="stylesheet">
		<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
		<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
			rel='stylesheet'>
		<link rel="stylesheet" href="chosen.css">
		<link rel="stylesheet" href="docsupport/prism.css">
		<link rel="stylesheet" href="chosen.css">

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
									<h3>Purchase new products</h3>
								</div>
								<?php if (isset($_GET['del'])) { ?>
									<div class="alert alert-error">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Oh snap!</strong>
										<?php echo htmlentities($_SESSION['delmsg']); ?>
										<?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
									</div>
								<?php } ?>

								<br />
								<div>

									<form method="POST">
										<select data-placeholder="Choose products" class="chosen-select" multiple
											tabindex="4" name="products[]">

											<?php
											$selectproducts = mysqli_query($conn, "SELECT * FROM products WHERE Status = 'In Stock' ");
											while ($row = mysqli_fetch_array($selectproducts)) {
												$pid = $row['ProductId'];
												?>
												<a>
													<option class="form-control" value="<?php echo $pid; ?>"> <?php echo $row['Name']; ?></option>
												</a>


												<?php
											}

											?>


										</select>
										<button class='btn btn-success' type='submit' name="save">Continue</button>
									</form>
									<form method="POST">
										<?php
										if (isset($_POST['save'])) {
											echo "<table
                                    <thead>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Unit price</th>
                                        <th>Quantity</th>
                                    </thead>
                                    <tbody>";

											$products = $_POST['products'];
											$cnt = 0;
											$list = [];
											foreach ($products as $products) {
												array_push($list, $products);
												$selectproducts = mysqli_query($conn, "SELECT Name,Quantity,Price,ProductId FROM products WHERE ProductId =$products");
												$row = mysqli_fetch_array($selectproducts);
												$cnt = $cnt + 1;


												?>
												<tr>
													<td>
														<?php echo $cnt; ?>



													</td>
													<td><b>
															<?php echo $row['Name']; ?>
														</b></td>
													<td><b>
															<a href="edit-products.php?id=<?php echo $row['ProductId']; ?>&frompage=purchase-sales.php"
																onClick="return confirm('you are going to change market value of the product ?')"><?php echo $row['Price']; ?></a>
														</b></td>
													<td><input type="number" value="1" class="span1 tip"
															name="quantity[<?php echo $row['ProductId'] . "," . $row['Price']; ?>]">
													</td>

												</tr>



											<?php }
											?>
											</table>
											<textarea name="description" placeholder="Enter Product Description" rows="2"
												class="span3 tip"></textarea>


											<button class='btn btn-primary' type='submit' name='continue'>Store</button>

										</form>

										<?php

										}
										?>
								</div>
							</div>
							<div class="module">
								<div class="module-head">
									<h3>Products</h3>
								</div>
								<div class="module-body table">
									<table cellpadding="0" cellspacing="0" border="0"
										class="datatable-1 table table-bordered table-striped	 display" width="100%">
										<thead>
											<tr>

												<th>#</th>
												<th>Product</th>
												<th>Unit price</th>
												<th>Quantity</th>
												<th>Description</th>
												<th>Purchase Dates</th>
											</tr>
										</thead>
										<tbody>

											<?php
											$salonid = $_SESSION['salonid'];
											$query = mysqli_query($conn, "select purchases.Quantity,products.Name,Purchases.Description,purchases.UnitPrice,purchases.PurchaseId,purchases.PurchaseDates FROM purchases,products where products.ProductId=purchases.ProductId AND  purchases.SalonId = '$salonid' ORDER BY purchases.PurchaseId ");
											$cnt = 1;
											$total=0;
											while ($row = mysqli_fetch_array($query)) {
												$pid = $row['PurchaseId'];
												$total=$row['UnitPrice'] + $total;
												?>
												<tr>
													<td>
														<?php echo htmlentities($cnt); ?>
													</td>
													<td>
														<?php echo htmlentities($row['Name']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['UnitPrice']) . "RWF"; ?>
													</td>
													<td>
														<?php echo htmlentities($row['Quantity']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['Description']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['PurchaseDates']); ?>
													</td>

												</tr>
												<?php $cnt = $cnt + 1;
											} ?>										
										</tbody>
									</table>
									<div class="module-head">
									<h3>Total sales purchase______________ <?php echo $total." RWF"; ?></h3>
								</div>
								</div>
							</div>



						</div><!--/.content-->
					</div><!--/.span9-->
				</div>
			</div><!--/.container-->
		</div><!--/.wrapper-->

		<?php include('include/footer.php'); ?>		
		<script src="docsupport/jquery-3.2.1.min.js" type="text/javascript"></script>
		<script src="chosen.jquery.js" type="text/javascript"></script>
		<script src="docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
		<script src="docsupport/init.js" type="text/javascript" charset="utf-8"></script>
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