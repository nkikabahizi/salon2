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
        <title>HDSMS|Purchase Sales Report</title>
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
                                        <?php echo $salonname; ?>
                                    </h3>
                                    <h3>
                                         Repport of Purchase Sales
                                    </h3>
                                </div>
                                <div class="module-body" style="text-align:left">
                                <b> <h3 style="text-align:center;"> <?php
                                     $userid = $_SESSION['id'];
                                     $selectuserinfo = mysqli_query($conn, "SELECT * FROM users,salon WHERE users.SalonId = salon.SalonId AND users.UserId=$userid");
                                     $info = mysqli_fetch_array($selectuserinfo);

                                    ?></h3></b><br><br><br>

                                <b>Dates</b>--------------<?php echo date('d-m-Y'); ?><br><br>
                                <b>User</b>--------------<?php echo $info['FullName']; ?>

                                <br><brr><br>
                                <div class="module-body table">
                                <table cellpadding="0" cellspacing="0" border="0"
										class="table table-bordered table-striped	 display" width="100%">
										<thead>
											<tr>

												<th>No</th>
												<th>Product</th>
												<th>Unit price</th>
												<th>Quantity</th>
												<th>Total</th>
												
												<th>Purchase Dates</th>
											</tr>
										</thead>
										<tbody>

											<?php
											$salonid = $_SESSION['salonid'];
											$salonid = $_SESSION['salonid'];
											$query = mysqli_query($conn, "SELECT purchases.Quantity,products.Name,Purchases.Description,purchases.UnitPrice,purchases.PurchaseId,purchases.PurchaseDates FROM purchases,products where products.ProductId=purchases.ProductId AND  purchases.salonId = $salonid AND products.salonId = $salonid ORDER BY purchases.PurchaseId ");
											$cnt = 1;
											$total=0;
											while ($row = mysqli_fetch_array($query)) {
												$pid = $row['PurchaseId'];
												$subtotal = $row['UnitPrice'] * $row['Quantity'];
										        @$totalpurchase = $totalpurchase + $subtotal;
                                                @$total += $row['Quantity'];

												
												?>
												<tr>
													<td>
														<?php echo htmlentities($cnt); ?>
													</td>
													<td>
														<?php echo htmlentities($row['Name']); ?>
													</td>
													<td>
														<?php echo htmlentities($row['UnitPrice']) . " RWF"; ?>
													</td>
													<td>
														<?php echo htmlentities($row['Quantity']) . " QT"; ?>
													</td>
													<td>
														<?php echo $subtotal; ?>
													</td>
													
													<td>
														<?php echo htmlentities($row['PurchaseDates']); ?>
													</td>

												</tr>
												<?php $cnt = $cnt + 1;
											} ?>										
										</tbody>
										<tfoot>
										<tr>
											<td></td><td><b>Total sales purchase</b></td><td></td><td><?php echo @$total ." QT"; ?></td><td><?php echo @$totalpurchase ." RWF"; ?></td><td></td>

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
                                    </i></p>
                                    
                                 
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