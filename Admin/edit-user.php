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
		$contacts = $_POST['contacts'];
		$salon = $_POST['salon'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$userid=$_GET['id'];

		$sql = mysqli_query($con, "update users set FullName = '$name',Email = '$email',Contact = '$contacts',Location = '$location',Role = '$role',UserName = '$username',SalonId = '$salon' WHERE UserId = $userid ");
		$_SESSION['msg'] = "User successfuly Updated !!";

	}

	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin| Category</title>
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
									<h3>Category</h3>
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


									<br />

									<form class="form-horizontal row-fluid" name="Category" method="post">
									
		<?php
		$userid = $_GET['id'];
		$user = mysqli_query($con, "SELECT * FROM users,salon WHERE users.SalonId = salon.SalonId AND users.UserId = $userid");
		$row = mysqli_fetch_array($user);
		?>
<div class="control-group">
	<label class="control-label" for="basicinput">Salon Name</label>
	<div class="controls">
	<select type="text" name="salon" class="span8 tip" required>
			<option value="<?php echo $row['SalonId']; ?>><?php echo $row['Name'] ?></option>
		<?php
		$salon = mysqli_query($con, "SELECT * FROM salon ");
		while($num = mysqli_fetch_array($salon)){
		?>
		<option value="<?php echo $num['SalonId']; ?>"><?php  echo $num['Name']; ?></option>
		<?php } ?>
		</select>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="basicinput">User's Full name</label>
	<div class="controls">
		<input type="text" placeholder="Enter employees Name" name="name"
			class="span8 tip" value="<?php echo $row['FullName']; ?>" required>
	</div>
</div>

<div class="control-group">
	<label class="control-label" for="basicinput">Role</label>
	<div class="controls">

		<select type="text" name="role" class="span8 tip" required>
			<option><?php echo $row['Role']; ?></option>
			<option>Manager</option>
			<option>Accountant</option>
			<option>System Admin</option>
		</select>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="basicinput">Location</label>
	<div class="controls">
		<input type="text" placeholder="Enter contacts" name="location"
			class="span8 tip" value="<?php echo $row['Location']; ?>" required>
	</div>
</div>

<div class="control-group">
	<label class="control-label" for="basicinput">Contacts</label>
	<div class="controls">
		<input type="number" placeholder="Enter phone number" name="contacts" class="span8 tip"
		value="<?php echo $row['Contact']; ?>" required>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="basicinput">Email</label>
	<div class="controls">
		<input type="email" placeholder="Enter Email adress" name="email"
			class="span8 tip" value="<?php echo $row['Email']; ?>" required>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="basicinput">Username</label>
	<div class="controls">
		<input type="text" placeholder="Enter Username" name="username"
			class="span8 tip" value="<?php echo $row['UserName']; ?>" required>
	</div>
</div>

<div class="control-group">
	<div class="controls">
		<button type="submit" name="submit" class="btn">Save</button>
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