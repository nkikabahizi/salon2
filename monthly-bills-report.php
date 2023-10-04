<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $employeeid = $_GET['employeeid'];
    $mon=$_GET['month'];
    $totalproductss=0;
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
                                         Repport of <?php echo date('m/Y', time()); ?>
                                    </h3>
                                </div>
                                <div class="module-body" style="text-align:left">
                                <b> <h3 style="text-align:center;"> <?php
                                     $userid = $_SESSION['id'];
                                     $selectuserinfo = mysqli_query($conn, "SELECT * FROM users,salon WHERE users.SalonId = salon.SalonId AND users.UserId=$userid");
                                     $info = mysqli_fetch_array($selectuserinfo);

                                    ?></h3></b><br><br><br>

                                <b>Dates</b>--------------<?php echo date('d-m-Y h:i:s A', time()); ?><br><br>
                                <b>User</b>--------------<?php echo $info['FullName']; ?>

                                <br><brr><br>
                                <div class="module-body table">
                                <table cellpadding="0" cellspacing="0" border="0"
										class="table table-bordered table-striped	 display" width="100%">
								<thead>
									<tr>
										<th>#</th>
										<th width="50">Customer</th>
										<th>Service</th>
										<th>Consumables</th>
										<th>Total bill</th>
										<th>Employee</th>
										
										<th>Dates</th>
										



									</tr>
								</thead>

								<tbody>
									<?php

									$mon = $_GET['month'];
									$total = 0;
                                    $totalservicess = 0;
									$salonid=$_SESSION['salonid'];
									$query = mysqli_query($conn, "SELECT * FROM billing,customers,employees,services WHERE billing.ServiceId = services.ServiceId AND billing.CustomerId = customers.CustomerId AND billing.EmployeeId=employees.EmployeeId AND billing.Mon = $mon AND billing.Status!=0 AND billing.SalonId = $salonid  ORDER BY billing.BillingId DESC");
									$cnt = 1;
									while ($row = mysqli_fetch_array($query)) {
										$billid = $row['BillingId'];
										$servicefee = $row['ServiceFee'];
                                        $totalservicess =$totalservicess+$servicefee;

										?>
										<tr>
											<td>
												<?php echo htmlentities($cnt); ?>
											</td>
											<td>
												<?php echo htmlentities($row['fullName']); ?>
											</td>
											<td>
												<?php echo $row['Name']; ?>
											</td>
											<td>
												<ul>

													<?php
													$selectbillinfo = mysqli_query($conn, "SELECT products.Price,products.Name,billinginfo.Quantity,products.ProductId FROM billinginfo,products WHERE products.ProductId=billinginfo.ProductId AND billinginfo.BillingId = '$billid' ");
													$price = 0;
													while ($billinfo = mysqli_fetch_array($selectbillinfo)) {
														$productid = $billinfo['ProductId'];
														$pricee = $billinfo['Price'] * $billinfo['Quantity'];
														$price = $price + $pricee;

														?>
														<li>
															<?php echo $billinfo['Name'] . "(" . $billinfo['Quantity'] . ")"; ?>

														</li>

														<?php
													}

													?>
												</ul>
											</td>
											<td>
											<?php echo  $subprice= $price + $servicefee; ?>

											</td>
											<td>
												<?php echo htmlentities($row['FullName']); ?>
											</td>
											
											<td>
												<?php echo $row['DateBill']; ?>
											</td>
											
										</tr>

										<?php $cnt = $cnt + 1;
												@$totalbill=$subprice + $totalbill;
											?>
                                            <?php $cnt = $cnt + 1;
												$totalproductss=$totalproductss+$price;
											} ?>
									<tr>
                                        <td></td>
										<td><b>Total bills</b></td>
										
										
										<td>
												<?php echo "<b>" . $totalservicess. 'FRW'; ?>
												</td>
												<td>
												<?php echo "<b>" . $totalproductss. 'FRW'; ?>
												</td>
                                        <td>
											<?php echo "<b>" . @$totalbill. 'FRW'; ?>
										</td>
										<td></td>
										<td></td>
										
									</tr>
								</tbody>
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