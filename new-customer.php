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


	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>HDSMS| Complete bill info</title>
		<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link type="text/css" href="css/theme.css" rel="stylesheet">
		<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
		<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
			rel='stylesheet'>
		<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
		<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>

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
											<label class="control-label" for="basicinput">Customer name</label>
											<div class="controls">
												<input type="text" name="customername" placeholder="Enter Product Name"
													class="span8 tip" required>

											</div>
										</div>


										<div class="control-group">
											<label class="control-label" for="basicinput">Phone number</label>
											<div class="controls">
												<input type="number" name="phone" placeholder="Enter Phone number"
													class="span8 tip" required> *for payment(07********)
											</div>
										</div>


										<div class="control-group">
											<div class="controls">
												<button type="submit" name="save" class="btn btn-primary">Save</button>

											</div>
										</div>
									</form>
								</div>
							</div>
							<?php 
                            if(isset($_POST['save']))
                            {
                                $name=$_POST['customername'];
                                $phone=$_POST['phone'];
                                $salonid=$_SESSION['salonid'];
                                $saving=mysqli_query($conn, "INSERT INTO customers(FullName, PhoneNumber, SalonId) VALUES ('$name','$phone','$salonid')");
                                if ($saving == 1) 
                                {
                                    $customerid=$conn -> insert_id;
                                    $billid=$_GET['billid'];
                                    echo "<script>window.location='complete-bill.php?billid=$billid&customerid=$customerid';</script>";
                                }

                            }
                            ?>





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