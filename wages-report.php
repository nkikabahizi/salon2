<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $employeeid = $_GET['employeeid'];
    $mon=$_GET['month'];
    date_default_timezone_set('Asia/Kolkata'); // change according timezone
	$currentTime = date('d-m-Y h:i:s A', time());
	$mon = $_GET['month'];
	$hairdresser = mysqli_query($conn, "SELECT Amount,Month FROM payroll,employees WHERE payroll.EmployeesNumber = employees.EmployeeId AND payroll.Month = '$mon' AND employees.Poste = 'Hair dresser' ");
	$naildresser = mysqli_query($conn, "SELECT Amount,Month FROM payroll,employees WHERE payroll.EmployeesNumber = employees.EmployeeId AND payroll.Month = '$mon' AND employees.Poste = 'Nail dresser' ");
	$makeup = mysqli_query($conn, "SELECT Amount,Month FROM payroll,employees WHERE payroll.EmployeesNumber = employees.EmployeeId AND payroll.Month = '$mon' AND employees.Poste = 'Make up specialist' ");
	$cnt = 1;
	$totalhair = 0;
	$totalmakeup = 0;
	$totalnail = 0;
	$totalsalaries = $totalhair + $totalmakeup + $totalnail;

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
        <?php
            $salonid=$_SESSION['salonid'];
            $query = mysqli_query($conn, "select * FROM salon WHERE SalonId= '$salonid' ");
            $cnt = 1;
            while ($row = mysqli_fetch_array($query)) {
                $salonname=$row['Name'];
            }

        ?>

        <center><div class="wrapper" style="background:white; width:700px">
        <div class="module-head" style="text-align:center">
                                    <img src="images/image4.jpg" class="nav-avatar" style="height:100px; width:100px;" />
                                    
                                    <h3>
                                        <?php echo $salonname; ?>
                                    </h3>
                                    <h3>
                                         Repport of <?php echo $_GET['month']."/2023"; ?>
                                    </h3>
                                </div>
                               
                                <div class="control-group" id="allowance">

</div>
<!-- <div class="container">
    <div class="span2">
        <div class="well">
            <div class="square square-sm"
                style="background:skyblue; height:50px; border-radius:12px;margin-top:-12px">
                ...Hair Dressers</div>
            <center>
                <div style="font-weight:bold">
                    <h5>
                        <?php while ($row1 = mysqli_fetch_array($hairdresser)) {
                            @$totalhair = $totalhair + $row1['Amount'];
                        }
                        echo $totalhair;
                        ?>
                    </h5>
                </div>
            </center>
        </div>
    </div>
    <div class="span2">
        <div class="well">
            <div class="square square-sm"
                style="background:skyblue; height:50px; border-radius:12px;margin-top:-12px">
                ...Nail Dresser</div>
            <center>
                <div style="font-weight:bold">
                    <h5>
                        <?php while ($row2 = mysqli_fetch_array($naildresser)) {
                            @$totalnail = $totalnail + $row2['Amount'];
                        }
                        echo $totalnail;
                        ?>
                    </h5>
                </div>
            </center>
        </div>
    </div>
    
    <div class="span2">
        <div class="well">
            <div class="square square-sm"
                style="background:skyblue; height:50px; border-radius:12px;margin-top:-12px">
                ...Makeup Specialist</div>
            <center>
                <div style="font-weight:bold">
                    <h5>
                        <?php while ($row3 = mysqli_fetch_array($naildresser)) {
                            @$totalmakeup = $totalnail + $row3['Amount'];
                        }
                        echo $totalmakeup;
                        ?>
                    </h5>
                </div>
            </center>
        </div>
    </div>
    
</div>

<div class="control-group">
    <div class="controls">
        <b>
            <h4>Total salaries : ......
                <?php echo $totalsalaries = $totalhair + $totalmakeup + $totalnail ?>RWF
            </h4>
        </b>
    </div>
</div>
</form> -->

<table cellpadding="0" cellspacing="0" border="0"
										class="table table-bordered table-striped	 display" width="100%">
								<thead>
									<tr>
										<th>Month</th>
										<th>Purchases</th>
										<th>Income</th>
										<th>Salaries & wages</th>
										<th>Expense & Rent</th>
										<th>Net Income</th>
									
									</tr>
								</thead>
								<tbody>

									<?php
									$salonid = $_SESSION['salonid'];
									$selectpurchase = mysqli_query($conn, "select UnitPrice,Quantity from purchases WHERE Mon = '$mon' AND Salonid = '$salonid' ");
									$cnt = 1;
									$totalpurchase = 0;
									while ($row = mysqli_fetch_array($selectpurchase)) {
										$subtotal = $row['UnitPrice'] * $row['Quantity'];
										@$totalpurchase = $totalpurchase + $subtotal;
									}

									 $selectexpenses = mysqli_query($conn, "select * FROM expenses WHERE Mon = '$mon' AND SalonId = $salonid");
											$cnt = 1;
											$totalexpense = 0;
											while ($row = mysqli_fetch_array($selectexpenses)) {
												$subtotall = $row['Amount'] + $row['Amount'];
												@$totalexpense = $totalexpense + $subtotall;
											}
											
											

									 
									$selectbilling = mysqli_query($conn, "select ServiceFee,TotalProducts from billing WHERE Mon = '$mon' AND Salonid = '$salonid' AND billing.Status != 0");
									$cnt = 1;
									$totalbilling = 0;
									while ($row = mysqli_fetch_array($selectbilling)) {
										$subtotal = $row['ServiceFee'] + $row['TotalProducts'];
										@$totalbilling = $totalbilling + $subtotal;
									}
									?>
									<tr>

										<td>
											<?php echo $mon; ?>
										</td>
										<td>
											<?php echo $totalpurchase; ?>
										</td>
										<td>
											<?php echo $totalbilling . "RWF"; ?>
										</td>
										<td>
											<?php echo $totalsalaries . " RWF"; ?>
										</td>
										<td>
										<?php echo $totalexpense . " RWF"; ?>
											
										</td>
										<td>
											<?php echo $netincome = $totalbilling - $totalpurchase - $totalsalaries - $totalexpense. "RWF"; ?>
										</td>
										
									</tr>

								</tbody>
								<tfoot>

								</tfoot>

							</table>
                                    <?php
                                     $userid = $_SESSION['id'];
                                     $selectuserinfo = mysqli_query($conn, "SELECT * FROM users,salon WHERE users.SalonId = salon.SalonId AND users.UserId=$userid");
                                     $info = mysqli_fetch_array($selectuserinfo);

                                    ?>
                                    <br><br>
                                    <p><i>Done at <?php echo $info['Location'] ?> <br>
                                    <?php echo "Operation Manager <b> ".$info['FullName']. "</b> At ". $info['Name']; ?>
                                    <br><br><br>
                                    Stamp and Signature .................................
                                    <br><br><br><br>
                                    

                            <script>
                                function printdata() {
                                    document.getElementById('btn').innerHTML = ""
                                    window.print();
                                }
                            </script>
                            
                           
                        </div><!--/.span9-->
                    </div>
                </div><!--/.container-->
            </div><!--/.wrapper-->


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