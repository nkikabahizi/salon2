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
		$id = $_POST['id'];
		$contacts = $_POST['contacts'];
		$description = $_POST['description'];
        $employeeid=$_GET['id'];
		$sql = mysqli_query($conn, "UPDATE employees set FullName = '$name',Location = '$location',Contacts = '$contacts',IdNumber = '$id',Poste = '$role',Description = '$description' ");
		
		$_SESSION['msg'] = "Information updated !!";

	}

	if (isset($_GET['del'])) {
		$employeeid = $_GET['id'];
		$deletemployee = mysqli_query($conn, "DELETE FROM employees WHERE EmployeeId = $employeeid");
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

										
												<?php
												$employeeid = $_GET['id'];
												$employees = mysqli_query($conn, "SELECT * FROM employees WHERE EmployeeId='$employeeid'");
												$row = mysqli_fetch_array($employees);
												?>
												
										<div class="control-group">
											<label class="control-label" for="basicinput">Employee's Name</label>
											<div class="controls">
												<input type="text" placeholder="Enter employees Name" name="name"
													class="span8 tip" value="<?php echo $row['FullName']; ?>" required>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Role</label>
											<div class="controls">

												<select type="text" name="role" class="span8 tip" required>
													<option><?php echo $row['Poste'] ?></option>
													<option>Hair dresser</option>
													<option>Nail dresser</option>
													<option>Make up specialist </option>
												</select>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Id Number</label>
											<div class="controls">
												<input type="number" id="idnumber" placeholder="Enter ID" name="id" value="<?php echo $row['IdNumber']; ?>" class="span8 tip"required>
													<span id="erro" style="color: red;"></span>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="basicinput">Phone number</label>
											<div class="controls">
												<input type="number" id="contacts" placeholder="Enter contacts" name="contacts"  value="<?php echo $row['Contacts']; ?>"class="span8 tip" required>
												<span id="error" style="color: red;"></span>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="basicinput">Location</label>
											<div class="controls">
												<input type="text" placeholder="Enter adress" name="location"  value="<?php echo $row['Location']; ?>"
													class="span8 tip" required>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Description</label>
											<div class="controls">
												<textarea class="span8" name="description" rows="5" style="text-align:left">
                                                <?php echo $row['Description']; ?>
                                                </textarea>
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