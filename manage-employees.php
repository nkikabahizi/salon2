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
		$id = $_POST['id'];
		$contacts = $_POST['contacts'];
		$description = $_POST['description'];
		$userid = $_SESSION['id'];
		$salonid = $_SESSION['salonid'];
		$sql = mysqli_query($conn, "insert into employees(FullName,Location,Contacts,IdNumber,Poste,Description,UserId,SalonId,Status) values('$name','$location', '$contacts', '$id', '$role', '$description', '$userid', '$salonid', '1')");
		$employeeid = $conn->insert_id;
		$_SESSION['msg'] = "New employee created !!";
		echo "<script>window.location='add-contract.php?employeeid=$employeeid';</script>";

	}

	if (isset($_GET['del'])) {
		$id = $_GET['id'];
		mysqli_query($conn, "UPDATE employees SET Status = 0 WHERE EmployeeId = $id");
		$_SESSION['delmsg'] = "employee deleted !!";
	}

	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>HDSMS| employees</title>
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
									<h3>New employee</h3>
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

									<form class="form-horizontal row-fluid" name="Category" method="post" id="FORM">

										<div class="control-group">
											<label class="control-label" for="basicinput">Salon Name</label>
											<div class="controls">
												<?php
												$salonid = $_SESSION['salonid'];
												$salon = mysqli_query($conn, "SELECT Name FROM salon WHERE SalonId='$salonid'");
												$num = mysqli_fetch_array($salon);
												?>
												<input type="text" placeholder="Enter category Name" name="category"
													class="span8 tip" disabled value="<?php echo $num['Name']; ?>">
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="basicinput">Employee's Name</label>
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
													<option>Hair dresser</option>
													<option>Nail dresser</option>
													<option>Make up specialist </option>
												</select>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Id Number</label>
											<div class="controls">
												<input type="number" id="idnumber" placeholder="Enter ID" name="id" class="span8 tip" required>
												<span id="erro" style="color: red;"></span>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="basicinput">Phone number</label>
											<div class="controls">
											<input type="number" id="contacts" placeholder="Enter phone number" name="contacts" class="span8 tip" required>
                                             <span id="error" style="color: red;"></span>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="basicinput">Location</label>
											<div class="controls">
												<input type="text" placeholder="Enter adress" name="location"
													class="span8 tip" required>
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


							<div class="module">
								<div class="module-head">
									<h3>Manage Employees</h3>
								</div>
								<div class="module-body table">
									<table cellpadding="0" cellspacing="0" border="0"
										class="datatable-1 table table-bordered table-striped	 display" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>ID</th>
												<th>Names</th>
												<th>Location</th>
												<th>Contacts</th>
												<th>Role</th>
												<th>Registered on</th>
												<th>Repports</th>
												<th class="span1">Action </th>
											</tr>
										</thead>
										<tbody>

											<?php
											$salonid = $_SESSION['salonid'];
											$query = mysqli_query($conn, "select * from employees WHERE SalonId = '$salonid' AND Status != 0");
											$cnt = 1;
											while ($row = mysqli_fetch_array($query)) {
												?>
												<tr>
													<td>
														<?php echo htmlentities($cnt); ?>
													</td>
													<td>
														<?php echo htmlentities($row['IdNumber']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['FullName']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['Location']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['Contacts']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['Poste']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['CreationDates']); ?>
													</td>
													<td><a href="toemployee.php?id=<?php echo $row['EmployeeId'] ?>"><button class="btn btn-primary">
														<i
																class="icon-file"> </i>Report</button></a>
													</td>
													<td>

														<a href="edit-employee.php?id=<?php echo $row['EmployeeId'] ?>"><i
																class="icon-edit"></i></a>
														<a href="manage-employees.php?id=<?php echo $row['EmployeeId'] ?>&del=delete"
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
		 <script>
            document.getElementById("FORM").addEventListener("submit",function(event){
                var phoneInput = document.getElementById("contacts");
                var idnumberInput = document.getElementById("idnumber");
				var erroSpan = document.getElementById("erro");
                var errorSpan = document.getElementById("error");
        
                if(phoneInput.value.length !==10){
                    errorSpan.textContent ="phone number must be exactly 10 digits.";
                    event.preventDefault();
                }
                else {
                    errorSpan.textContent= "";
                }
				if(idnumberInput.value.length !==16){
                    erroSpan.textContent ="ID Number must be exactly 16 digits.";
                    event.preventDefault();
                }
                else {
                    erroSpan.textContent= "";
                }
            });
        </script>
	</body>
<?php } ?>