<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $employeeid = $_GET['employeeid'];
    $mon=$_GET['month'];
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
        	$query = mysqli_query($conn, "select * from employees WHERE EmployeeId = '$employeeid' ");
            $cnt = 1;
            while ($row = mysqli_fetch_array($query)) {
                $names=$row['FullName'];
            }
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
                                        <?php echo $names; ?>
                                    </h3>
                                    <h3>
                                        <?php echo $salonname; ?>
                                    </h3>
                                    <h3>
                                         Repport of <?php echo $_GET['month']."/2023"; ?>
                                    </h3>
                                </div>
        <div class="module-body table">
									<table cellpadding="0" cellspacing="0" border="0"
										class="table table-bordered table-striped	 display" width="100%">
										<thead>
											<tr>
												<th>#</th>
                                                <th>Date</th>
												<th>Deductions</th>
												<th>Loans</th>
												<th>Salary</th>
												<th>Salary payment Status</th>
											</tr>
										</thead>
										<tbody>

											<?php
											$salonid = $_SESSION['salonid'];
											$employeeid = $_GET['employeeid'];
											$mon=$_GET['month'];
											$query = mysqli_query($conn, "select * from salaries WHERE EmployeeId = '$employeeid' AND Mon = '$mon' ");
											$cnt = 1;
											while ($row = mysqli_fetch_array($query)) {
												$paymentstatus=$row['Status'];
                                                @$totalsup=$totalsup + $row['Amount'];
                                                @$totalpayout=$totalsup-$totaldeductions-$totalloans
												?>
												<tr>
													<td>
														<?php echo htmlentities($cnt); ?>
													</td>
                                                    <td>
														<?php echo $row['FromDate']; ?>
													</td>
													<td>
														<?php $selectdeductions = mysqli_query($conn, "select * from deductions WHERE EmployeeId = '$employeeid' AND Mon= '$mon' ");
														$totaldeductions=0;
														while($deductions = mysqli_fetch_array($selectdeductions))
														{
															$totaldeductions=$totaldeductions + $deductions['Amount'];
														}

														echo $totaldeductions; ?>
													</td>
													<td>
													<?php $selectloans = mysqli_query($conn, "select * from loans WHERE EmployeeId = '$employeeid' AND Mon= '$mon' ");
														$totalloans=0;
														while($loans = mysqli_fetch_array($selectloans))
														{
															$totalloans=$totalloans + $loans['Amount'];
														}

														echo $totalloans; ?>
													</td>
													<td>
														<?php echo $row['Amount']; ?>
													</td>
													<td>
														<?php 
														if($paymentstatus != 1)
														{
															?>
															<img src="images/offblue.png"> Not Yet paid
															<?php
														}
														elseif($paymentstatus == 1)
														{
															?>
															<img src="images/onblue.png"> Paid

															<?php
														}
														?>
														
													</td>
													
												</tr>
												<?php $cnt = $cnt + 1;
											}
											$employeeid=$_GET['employeeid'];
											$mon=$_GET['month'];
											 ?>
                                             <tfoot>
										     <tr>
											  <td></td><td><b>Total Payouts</b></td><td><?php echo @$totaldeductions ." RWF"; ?></td></td><td><?php echo @$totalloans ." RWF"; ?></td></td><td><?php echo @$totalpayout ." RWF"; ?></td><td></td>

											  </tr>
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