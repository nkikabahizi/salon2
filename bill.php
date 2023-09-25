<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $billid = $_GET['billid'];




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

        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="span2">
                    </div>
                    <?php
                    $selectcustomerinfo = mysqli_query($conn, "SELECT * FROM customers,billing,salon,employees WHERE employees.EmployeeId = billing.EmployeeId AND customers.CustomerId = billing.CustomerId AND billing.BillingId = $billid AND customers.SalonId = salon.SalonId");
                    $info = mysqli_fetch_array($selectcustomerinfo);
                    $serviceid = $info['ServiceId'];


                    ?>


                    <div class="span8">
                        <div class="content">

                            <div class="module">
                                <div class="module-head" style="text-align:center">
                                    <img src="images/image4.jpg" class="nav-avatar" style="height:100px; width:100px;" />
                                    <h3>
                                        <?php echo $info['Name']; ?>
                                    </h3>
                                </div>

                                <div class="module-body" style="text-align:left">
                                    <b>Bill Numbber-----------</b>
                                    <?php echo "HDSMS/" . $info['BillingId']; ?><br><br>
                                    <b>Date of Bill-----------</b>
                                    <?php echo $info['DateBill']; ?><br><br>
                                    <b>Name of Customer-----------</b>
                                    <?php echo $info['fullName']; ?><br><br>
                                  
                                    <b>Name of Employee ----------</b>
                                        <?php echo $info['FullName'] . "  (" . $info['Poste'] . ")"; ?><br>


                                    <br>
                            
                                    <b>Service-----------</b>
                                    <?php $selectservice = mysqli_query($conn, "SELECT * FROM services WHERE ServiceId = $serviceid");
                                    $serv = mysqli_fetch_array($selectservice);
                                    echo $serv['Name']; ?><br><br>
                                   <b>Service Fee:-----------</b>
                                    <?php echo $info['ServiceFee'] . "RWF"; ?><br><br>
                                    <b>Products ----------</b>
                                    <?php $selectbillinfo = mysqli_query($conn, "SELECT * FROM billinginfo WHERE BillingId = $billid");
                                    $totalproducts = 0;
                                    while ($billinfo = mysqli_fetch_array($selectbillinfo)) {
                                        $productid=$billinfo['ProductId'];
                                        $selectproduct=mysqli_query($conn, "SELECT * FROM products WHERE ProductId = $productid ");
                                    while ($products = mysqli_fetch_array($selectproduct)) {
                                        $unitprice=$products['Price'];
                                        echo $products['Name']. "(".$billinfo['Quantity'] .")" ;

                                    }
                                    echo ",";

                                    

                                        $subtotal=$unitprice * $billinfo['Quantity'];
                                        $totalproducts = $subtotal + $totalproducts;
                                        
                                    }
                                    ?>
                                    <br><br>
                                    <b>Price ----------</b>
                                    <?php echo $info['TotalProducts']. "RWF"; ?>
                                  <br><br>
                                    
                            
                                    <b>
                                    Total Bill: <b>-----------------</b>      <?php echo "<b>" . $totalproducts + $info['ServiceFee'] . "RWF</b>"; ?><br><br>
                                        
                                    <b>----------------------------------------------------------------------------------------------</b>

                                    <?php
                                     $userid = $_SESSION['id'];
                                     $selectuserinfo = mysqli_query($conn, "SELECT * FROM users,salon WHERE users.SalonId = salon.SalonId AND users.UserId=$userid");
                                     $info = mysqli_fetch_array($selectuserinfo);

                                    ?>
                                    <br><br>
                                    <p><i>Done at <?php echo $info['Location'] ?> <br>
                                    <?php echo "Operation Manager <b> ".$info['FullName']. "</b> At ". $info['Name']; ?>
                                    <br><br>
                                    Stamp and Signature .................................
                                    <br><br>
                                    
                                    





                                </div>
                            </div><!--/.content-->
                            <script>
                                function printdata() {
                                    document.getElementById('btn').innerHTML = ""
                                    window.print();
                                }
                            </script>
                             <a href="newbill.php" onClick="printdata()"> <button class="btn btn-primary" id="btn"> Print <span class="icon-print"></span></button></a>
                            <a href="newbill.php"> <button class="btn">Home</button></a>

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