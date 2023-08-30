<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {

	if (isset($_POST['submit'])) {
		$category = $_POST['category'];
		$productname = $_POST['name'];
		$productcompany = $_POST['company'];
		$price = $_POST['price'];
		$quantity = $_POST['quantity'];
		$productdescription = $_POST['description'];
		$availability = $_POST['availability'];
		$salonid = $_SESSION['salonid'];
		$productimage = $_FILES["productimage"]["name"];
		$currentTime = date('d-m-Y h:i:s A', time());
		//for getting product id
		$query = mysqli_query($conn, "select max(ProductId) as pid from products");
		$result = mysqli_fetch_array($query);
		$productid = $result['pid'] + 1;
		$dir = "productimages/$productid";
		if (!is_dir($dir)) {
			mkdir("productimages/" . $productid);
		}
		move_uploaded_file($_FILES["productimage"]["tmp_name"], "productimages/$productid/" . $_FILES["productimage"]["name"]);
		$sql = mysqli_query($conn, "insert into products(Name,Category,Manufacture,Price,ExampleProfile,Quantity,Description,SalonId,Status,UpdationDates) values('$productname','$category','$productcompany','$price','$productimage','$quantity','$productdescription','$salonid','$availability','$currentTime')");
		$_SESSION['msg'] = "Product Inserted Successfully !!";
		$_SESSION['msg'] = "Product Inserted Successfully !!";
	}
	if(isset($_GET['del']))
		  {
		          mysqli_query($conn,"delete from products where ProductId = '".$_GET['id']."'");
                  $_SESSION['delmsg']="Product deleted !!";
		  }



	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>HDSMS| manage Product</title>
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
									<h3>Insert Product</h3>
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

										<div class="control-group">
											<label class="control-label" for="basicinput">Category</label>
											<div class="controls">
												<select name="category" class="span8 tip" onChange="getSubcat(this.value);"
													required>
													<option value="">Select Category</option>
													<option value="Oils">Oils</option>
													<option value="Champo">Champo</option>
													<option value="Make up">Make ups</option>


												</select>
											</div>
										</div>


										<div class="control-group">
											<label class="control-label" for="basicinput">quantity</label>
											<div class="controls">
												<input type="number" name="quantity" placeholder="Enter Product Name"
													class="span8 tip" required>

											</div>
										</div>


										<div class="control-group">
											<label class="control-label" for="basicinput">Product Name</label>
											<div class="controls">
												<input type="text" name="name" placeholder="Enter Product Name"
													class="span8 tip" required>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Manufacture company</label>
											<div class="controls">
												<input type="text" name="company" placeholder="Enter Product brand"
													class="span8 tip" required>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Price</label>
											<div class="controls">
												<input type="number" name="price" placeholder="Enter market value"
													class="span8 tip" required>
											</div>
										</div>



										<div class="control-group">
											<label class="control-label" for="basicinput">Product Description</label>
											<div class="controls">
												<textarea name="description" placeholder="Enter Product Description"
													rows="6" class="span8 tip">
									</textarea>
											</div>
										</div>



										<div class="control-group">
											<label class="control-label" for="basicinput">Product Availability</label>
											<div class="controls">
												<select name="availability" id="productAvailability" class="span8 tip"
													required>
													<option value="">Select</option>
													<option value="In Stock">In Stock</option>
													<option value="Out of Stock">Out of Stock</option>
												</select>
											</div>
										</div>



										<div class="control-group">
											<label class="control-label" for="basicinput">Product Image</label>
											<div class="controls">
												<input type="file" name="productimage" id="productimage" value=""
													class="span8 tip" required>
											</div>
										</div>



										<div class="control-group">
											<div class="controls">
												<button type="submit" name="submit" class="btn">Insert</button>
											</div>
										</div>
									</form>
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
												<th>Name</th>
												<th>Category</th>
												<th>Brand</th>
												<th>Unit Price</th>
												<th>Quantity</th>
												<th>Availability</th>
												<th>Image</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>

											<?php
											$salonid = $_SESSION['salonid'];
											$query = mysqli_query($conn, "select * from products WHERE SalonId = '$salonid' ");
											$cnt = 1;
											while ($row = mysqli_fetch_array($query)) {
												$pid = $row['ProductId'];
												?>
												<tr>
													<td>
														<?php echo htmlentities($cnt); ?>
													</td>
													<td>
														<?php echo htmlentities($row['Name']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['Category']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['Manufacture']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['Price'])."RWF"; ?>
													</td>
													<td>
														<?php echo htmlentities($row['Quantity']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['Status']); ?>
													</td>
													
													<td>
														<img src="productimages/<?php echo htmlentities($pid); ?>/<?php echo htmlentities($row['ExampleProfile']); ?>"
															width="200" height="100">

													</td>
													<td>
														<a
															href="edit-products.php?id=<?php echo $row['ProductId'] ?>&frompage=manage-products.php"><i
																class="icon-edit"></i></a>
														<a href="manage-products.php?id=<?php echo $row['ProductId']?>&del=delete"
															onClick="return confirm('Are you sure you want to delete?')"><i
																class="icon-remove-sign"></i></a>
													</td>
												</tr>
												<?php $cnt = $cnt + 1;
											} ?>

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