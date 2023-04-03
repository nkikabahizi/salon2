<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	$pid = intval($_GET['id']); // product id
	$frompage = $_GET['frompage'];
	if (isset($_POST['submit'])) {
		$category = $_POST['category'];
		$productname = $_POST['productName'];
		$productcompany = $_POST['productCompany'];
		$productprice = $_POST['productprice'];
		$productdescription = $_POST['productDescription'];
		$productavailability = $_POST['productAvailability'];
		$currentTime = date('d-m-Y h:i:s A', time());
		$sql = mysqli_query($conn, "update  products set Category='$category',Name='$productname',Manufacture='$productcompany',Price='$productprice',Description='$productdescription',Status='$productavailability', UpdationDates= '$currentTime' WHERE ProductId='$pid' ");
		$_SESSION['msg'] = "Product Updated Successfully !!";
		header("location:$frompage");



	}


	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Edit Product</title>
		<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link type="text/css" href="css/theme.css" rel="stylesheet">
		<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
		<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
			rel='stylesheet'>
		<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
		<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>

		<script>
			function getSubcat(val) {
				$.ajax({
					type: "POST",
					url: "get_subcat.php",
					data: 'cat_id=' + val,
					success: function (data) {
						$("#subcategory").html(data);
					}
				});
			}
			function selectCountry(val) {
				$("#search-box").val(val);
				$("#suggesstion-box").hide();
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
									<h3>Edit product</h3>
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

									<form class="form-horizontal row-fluid" name="insertproduct" method="post"
										enctype="multipart/form-data">

										<?php

										$query = mysqli_query($conn, "select * from products where ProductId='$pid'");
										$cnt = 1;
										while ($row = mysqli_fetch_array($query)) {



											?>


											<div class="control-group">
												<label class="control-label" for="basicinput">Category</label>
												<div class="controls">
													<select name="category" required>
														<option value="<?php echo htmlentities($row['Category']); ?>"><?php echo htmlentities($row['Category']); ?></option>
														<option value="Oils">Oils</option>
														<option value="Champo">Champo</option>
														<option value="Make up">Make ups</option>

													</select>
												</div>
											</div>



											<div class="control-group">
												<label class="control-label" for="basicinput">Product Name</label>
												<div class="controls">
													<input type="text" name="productName" placeholder="Enter Product Name"
														value="<?php echo htmlentities($row['Name']); ?>" class="span8 tip">
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="basicinput">Product Company</label>
												<div class="controls">
													<input type="text" name="productCompany"
														placeholder="Enter Product Comapny Name"
														value="<?php echo htmlentities($row['Manufacture']); ?>"
														class="span8 tip" required>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="basicinput">Price
												</label>
												<div class="controls">
													<input type="text" name="productprice" placeholder="Enter Product Price"
														value="<?php echo htmlentities($row['Price']); ?>" class="span8 tip"
														required>
												</div>
											</div>


											<div class="control-group">
												<label class="control-label" for="basicinput">Product Description</label>
												<div class="controls">
													<textarea name="productDescription" placeholder="Enter Product Description"
														rows="6" class="span8 tip">
						<?php echo htmlentities($row['Description']); ?>
						</textarea>
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="basicinput">Product Availability</label>
												<div class="controls">
													<select name="productAvailability" id="productAvailability"
														class="span8 tip" required>
														<option value="<?php echo htmlentities($row['Status']); ?>">
															<?php echo htmlentities($row['Status']); ?></option>
														<option value="In Stock">In Stock</option>
														<option value="Out of Stock">Out of Stock</option>
													</select>
												</div>
											</div>



											<div class="control-group">
												<label class="control-label" for="basicinput">Product Image1</label>
												<div class="controls">
													<img src="productimages/<?php echo htmlentities($pid); ?>/<?php echo htmlentities($row['ExampleProfile']); ?>"
														width="200" height="100"> <a
														href="update-image.php?id=<?php echo $row['ProductId']; ?>">Change
														Image</a>
												</div>
											</div>




										<?php } ?>
										<div class="control-group">
											<div class="controls">
												<button type="submit" name="submit" class="btn">Update</button>
											</div>
										</div>
									</form>
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