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
		$contacts = $_POST['contacts'];
		$salon = $_POST['salon'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$pass =$_POST['password'];
		$password = md5($pass);

		$sql = mysqli_query($con, "insert into users(FullName,Email,Contact,Location,Role,UserName,Password,SalonId,Status) values('$name','$email', '$contacts', '$location', '$role', '$username', '$password', '$salon', '1')");
		$employeeid = $con->insert_id;
		$_SESSION['msg'] = "New user created !!";

	}

	if (isset($_GET['del'])) {
		$userid = $_GET['id'];
		$deletemployee = mysqli_query($con, "UPDATE users SET Status = '0' WHERE UserId = $userid");
		$_SESSION['msg'] = "user Deleted !!";


	}

	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>HDSMS| Admin</title>
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
					<div class="span12">
						<div class="content">

							<div class="module">
								<div class="module-head">
									<h3>New User</h3>
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


									<?php if (isset($_GET['del'])) {

										?>
										<div class="alert alert-error">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Oh snap!</strong>
											<?php echo htmlentities($_SESSION['delmsg']); ?>
											<?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
										</div>
									<?php } ?>

									<br />

									<form class="form-horizontal row-fluid" name="Users" method="post">

										<div class="control-group">
											<label class="control-label" for="basicinput">Salon Name</label>
											<div class="controls">
											<select type="text" name="salon" class="span8 tip" required>
													<option>Selecte Salon</option>
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
													class="span8 tip" required>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Role</label>
											<div class="controls">

												<select type="text" name="role" class="span8 tip" required>
													<option>Selecte role</option>
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
													class="span8 tip" required>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Contacts</label>
											<div class="controls">
												<input type="text" minlength="10" maxlength="13" placeholder="Enter phone number" name="contacts" class="span8 tip"
													required>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="basicinput">Email</label>
											<div class="controls">
												<input type="email" placeholder="Enter Email adress" name="email"
													class="span8 tip" required>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="basicinput">Username</label>
											<div class="controls">
												<input type="text" placeholder="Enter Username" name="username"
													class="span8 tip" required>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="basicinput">Password</label>
											<div class="controls">
												<input type="password" placeholder="Enter password here" name="password"class="span8 tip" required>
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


							<div class="module">
								<div class="module-head">
									<h3>Manage Users</h3>
								</div>
								<div class="module-body table">
									<table cellpadding="0" cellspacing="0" border="0"
										class="datatable-1 table table-bordered table-striped	 display" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>Salon</th>
												<th>Names</th>
												<th>Location</th>
												<th>Contacts</th>
												<th>Role</th>
												<th>Registered on</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>

											<?php
											$query = mysqli_query($con, "select * from users,salon WHERE salon.SalonId = users.SalonId AND users.Status != 0");
											$cnt = 1;
											while ($row = mysqli_fetch_array($query)) {
												?>
												<tr>
													<td>
														<?php echo htmlentities($cnt); ?>
													</td>
													<td>
														<?php echo htmlentities($row['Name']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['FullName']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['Location']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['Contact']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['Role']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['CreationDates']); ?>
													</td>
													<td>
														<a href="edit-user.php?id=<?php echo $row['UserId'] ?>"><i
																class="icon-edit"></i></a>
														<a href="manage-users.php?id=<?php echo $row['UserId'] ?>&del=delete"
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