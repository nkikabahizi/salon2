<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {


    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HDSMS| Income</title>
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
        <?php include('include/header.php'); ?>

        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <?php include('include/sidebar.php'); ?>
                    <div class="span9">
                        <div class="content">

                            <div class="module">
                                <div class="module-head">
                                    <form method='GET' action="income.php">
                                        <div>
                                            <div class="col-md-4">
                                                <select name="mon" class="span3 tip" required>
                                                    <option value="">Select different month</option>
                                                    <option value="1">January</option>
                                                    <option value="2">February</option>
                                                    <option value="3">March</option>
                                                    <option value="4">April</option>
                                                    <option value="5">May</option>
                                                    <option value="6">June</option>
                                                    <option value="7">July</option>
                                                    <option value="8">August</option>
                                                    <option value="9">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">December</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-primary">Filter<span
                                                        class="icon-filter"> </button>
                                    </form>
                                    <?php
                                    $mon = $_GET['mon'];
                                    switch ($mon) {
                                        case '1':
                                            $monthname = 'January';
                                            break;
                                        case '2':
                                            $monthname = 'February';
                                            break;
                                        case '3':
                                            $monthname = 'March';
                                            break;
                                        case '4':
                                            $monthname = 'April';
                                            break;
                                        case '5':
                                            $monthname = 'May';
                                            break;
                                        case '6':
                                            $monthname = 'June';
                                            break;
                                        case '7':
                                            $monthname = 'July';
                                            break;
                                        case '8':
                                            $monthname = 'August';
                                            break;
                                        case '9':
                                            $monthname = 'September';
                                            break;
                                        case '10':
                                            $monthname = 'October';
                                            break;
                                        case '11':
                                            $monthname = 'November';
                                            break;
                                        case '12':
                                            $monthname = 'December';
                                            break;



                                        default:
                                            $mon = date('m');
                                            break;
                                    }
                                    ?>
                                    Current : <b>
                                        <?php echo $monthname; ?>
                                    </b>
                                </div>
                            </div>

                        </div>

                        <div class="module-body table">
                            <?php if (isset($_GET['del'])) { ?>
                                <div class="alert alert-error">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Oh snap!</strong>
                                    <?php echo htmlentities($_SESSION['delmsg']); ?>
                                    <?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
                                </div>
                            <?php } ?>

                            <br />
                            <!--detailed service icome !-->
                            <div class="container">
                                <div class="span2">
                                    <div class="well">
                                        <div class="square square-sm"
                                            style="background:skyblue; height:50px; border-radius:12px;margin-top:-12px">
                                            ...Hair Dressers</div>
                                        <center>
                                            <div style="font-weight:bold">
                                                <h5>
                                                    <?php 
                                                    $totalhair=0;
                                                    $query = mysqli_query($conn, "SELECT * FROM billing,employees WHERE billing.EmployeeId=employees.EmployeeId AND billing.Mon = $mon AND billing.Status!=0 AND billing.SalonId = $salonid AND employees.Poste= 'Hair dresser' ORDER BY billing.BillingId DESC");
                                                    $cnt = 1;
                                                    while ($row = mysqli_fetch_array($query)) {
                                                        $billid = $row['BillingId'];
                                                        $totalhair=$totalhair + $row['ServiceFee'];
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
                                                <?php 
                                                    $totalnair=0;
                                                    $query = mysqli_query($conn, "SELECT * FROM billing,employees WHERE billing.EmployeeId=employees.EmployeeId AND billing.Mon = $mon AND billing.Status!=0 AND billing.SalonId = $salonid AND employees.Poste= 'Nail dresser' ORDER BY billing.BillingId DESC");
                                                    $cnt = 1;
                                                    while ($row = mysqli_fetch_array($query)) {
                                                        $billid = $row['BillingId'];
                                                       $totalnair=$totalnair + $row['ServiceFee'];
                                                    }

                                                    
                                                    echo $totalnair;
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
                                                <?php 
                                                    $totalmakeup=0;
                                                    $query = mysqli_query($conn, "SELECT * FROM billing,employees WHERE billing.EmployeeId=employees.EmployeeId AND billing.Mon = $mon AND billing.Status!=0 AND billing.SalonId = $salonid AND employees.Poste= 'Make up specialist' ORDER BY billing.BillingId DESC");
                                                    $cnt = 1;
                                                    while ($row = mysqli_fetch_array($query)) {
                                                        $billid = $row['BillingId'];
                                                       $totalmakeup=$totalmakeup + $row['ServiceFee'];
                                                    }

                                                    
                                                    echo $totalmakeup;
                                                    ?>
                                                </h5>
                                            </div>
                                        </center>
                                    </div>
                                </div>
                            </div>


                            <table cellpadding="0" cellspacing="0" border="0"
                                class="datatable-1 table table-bordered table-striped	 display table-responsive">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Employer Names</th>
                                        <th>Recruited dates</th>
                                        <th>Service</th>
                                        <th>Income</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $mon = $_GET['mon'];
                                    $total = 0;
                                    $subtotal = 0;
                                    $salonid = $_SESSION['salonid'];
                                    $query1 = mysqli_query($conn, "SELECT * FROM employees WHERE SalonId = $salonid AND status!=0");

                                    $cnt = 1;

                                    while ($row = mysqli_fetch_array($query1)) {
                                        $employeeid = $row['EmployeeId'];
                                        ?>







                                        <tr>
                                            <td>
                                                <?php echo htmlentities($cnt); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($row['FullName']); ?>
                                            </td>
                                            <td>
                                                <?php echo $row['CreationDates']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['Poste']; ?>
                                            </td>
                                            <td>
                                                <ul>
                                                    <?php
                                                      $subtotal = 0;
                                                      $salonid = $_SESSION['salonid'];
                                                    $query = mysqli_query($conn, "SELECT * FROM billing WHERE EmployeeId=$employeeid AND billing.Mon = $mon AND billing.Status!=0 AND billing.SalonId = $salonid  ORDER BY BillingId DESC");
                                                    while ($billinfo = mysqli_fetch_array($query)) {
                                                        $subtotal = $subtotal + $billinfo['ServiceFee'];
                                                        

                                                    }
                                                    $total = $total + $subtotal
                                                        ?>


                                                    <?php echo $subtotal; ?>
                                                </ul>
                                            </td>


                                        </tr>

                                        <?php $cnt = $cnt + 1;
                                        @$totalbill = $subprice + $totalbill;
                                    } ?>
                                    <tr>
                                        <td><b>Total bills</b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <?php echo "<b>" . @$total ?>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="income-report.php?employeeid=<?php echo $employeeid; ?>&month=<?php echo $mon; ?>" target="_blank"> <button class="btn btn-primary" title="print report"><span class="icon-print"></span></button></a>
						
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