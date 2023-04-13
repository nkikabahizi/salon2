<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $frequency = $_GET['type'];
    $description = $_GET['description'];




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
                    <div class="span1">
                    </div>
                    <?php
                    $userid = $_SESSION['id'];
                    $selectuserinfo = mysqli_query($conn, "SELECT * FROM users,salon WHERE users.SalonId = salon.SalonId AND users.UserId=$userid");
                    $info = mysqli_fetch_array($selectuserinfo);

                    ?>


                    <div class="span10">
                        <div class="content">

                            <div class="module">
                                <div class="module-head" style="text-align:center">
                                    <img src="images/image4.jpg" class="nav-avatar" style="height:100px; width:100px;" />
                                    <h3>
                                        <?php echo $info['Name']; ?>
                                    </h3>
                                </div>

                                <div class="module-body" style="text-align:left">
                                <b> <h3 style="text-align:center;"><?php echo $_GET['type']. " DAYS PAYMENT SALARIES"; ?></h3></b><br><br><br>

                                <b>Dates</b>--------------<?php echo date('d-m-Y'); ?><br><br>
                                <b>User</b>--------------<?php echo $info['FullName']; ?>

                                <br><brr><br>

                                    <table cellpadding="0" cellspacing="0" border="0"
                                        class=" table table-bordered table-striped	 display" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>National Id</th>
                                                <th>Names</th>
                                                <th>Location</th>
                                                <th>Role</th>
                                                <th>Contact</th>
                                                <th>Salary</th>
                                                <th>Deductions</th>
                                                <th>Loan</th>
                                                <th>Payout</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            <?php
                                            $salonid=$_SESSION['salonid'];
                                            $total = 0;
                                            $query = mysqli_query($conn, "SELECT * FROM salaries,employees,contracts WHERE employees.EmployeeId = salaries.EmployeeId AND employees.EmployeeId=contracts.EmployeeId AND employees.SalonId = $salonid AND contracts.PaymentFrequency=$frequency AND salaries.Status!=1");
                                            while ($salaries = mysqli_fetch_array($query)) {
                                                $fromdate = $salaries['FromDate'];
                                                $today = date("Y-m-d");
                                                $from = new DateTime($fromdate);
                                                $now = new DateTime($today);
                                                $interval = $from->diff($now);
                                                $days = $interval->days;
                                                $days = $days - 1;
                                                @$loans=$_GET['loans'];
                                                @$deductions=$_GET['deductions'];
                                                $employeeid=$salaries['EmployeeId'];
                                                $salary=$salaries['Amount'];
                                                $deduction =0;
                                                $perc = 0;
                                                //compute deductions and salaries
                                                if($loans == 1)
                                                {
                                                    $selectloan=mysqli_query($conn, "SELECT * FROM loans WHERE EmployeeId = $employeeid ORDER BY LoanId DESC");
                                                    $found=mysqli_fetch_array($selectloan);
                                                    if(!empty($found))
                                                    {
                                                        $amount=$found['Amount'];
                                                        $percentage=$found['PercentagePayment'];
                                                        $sub=$amount * $percentage;
                                                        $perc=$sub / 100;
                                                        $salary = $salary - $perc;
                                                        if($salary < 0)
                                                        {
                                                            $salary = 0;
                                                        }
                                                        
                                                    }
                                                    else
                                                    {
                                                        $perc = 0;
                                                    }
                                                }
                                                if($deductions == 1)
                                                {
                                                    $selectdeductions=mysqli_query($conn, "SELECT * FROM deductions WHERE EmployeeId = $employeeid ORDER BY DeductionId DESC");
                                                    $found=mysqli_fetch_array($selectdeductions);
                                                    if(!empty($found))
                                                    {
                                                        $amount=$found['Amount'];
                                                        $salary = $salary - $amount;   
                                                        $deduction= $amount;   
                                                        if($salary < 0)
                                                        {
                                                            $salary = 0;
                                                        }                                                  

                                                    }
                                                    else
                                                    {
                                                        $deduction = 0;
                                                    }                                                   

                                                }
                                                
                                                if ($days >= $frequency) {
                                                    @$i = $i + 1;
                                                    $total = $total + $salary;

                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo htmlentities($i); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlentities($salaries['IdNumber']); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlentities($salaries['FullName']); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlentities($salaries['Location']); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlentities($salaries['Poste']); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlentities($salaries['Contacts']); ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                            
                                                            echo $salaries['Amount']; ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                            
                                                            echo htmlentities($deduction); ?>
                                                        </td>
                                                        <td><?php echo htmlentities($perc); ?> </td>

                                                        <td><?php echo htmlentities($salary); ?> </td>

                                                        
                                                        


                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td></td><td><b>Total Payout</b></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><?php echo "<b>". $total ." RWF</b>"; ?></td>
                                        </tr>
                                    </table>
                                    <br><br>
                                    <p><i>Done at <?php echo $info['Location'] ?> <br>
                                    <?php echo "Operation Manager <b> ".$info['FullName']. "</b> At ". $info['Name']; ?>
                                    <br><br><br>
                                    Stamp and Signature .................................
                                    <br><br><br><br>


                                    </i></p>
                                </div>
                            </div><!--/.content-->
                            <script>
                                function printdata() {
                                    document.getElementById('btn').innerHTML = ""
                                    window.print();
                                }
                            </script>
                            <form method="POST">
                            <a href="salaries.php" onClick="printdata()"> <button class="btn btn-primary" id="btn" type="submit" name="save"> Print
                                    <span class="icon-print"></span></button></a>
                            <a href="salaries.php"> <button type="button" class="btn">Home</button></a></form>
                            <?php
                            if(isset($_POST['save']))
                            {
                                // echo "<script>alert('Printed');</script>";
                                $query = mysqli_query($conn, "SELECT * FROM salaries,employees,contracts WHERE employees.EmployeeId = salaries.EmployeeId AND employees.EmployeeId=contracts.EmployeeId AND employees.SalonId = $salonid AND contracts.PaymentFrequency=$frequency AND salaries.Status!=1");
                                $totalsalaries= 0;
                                while ($salaries = mysqli_fetch_array($query)) {
                                    $fromdate = $salaries['FromDate'];
                                    $today = date("Y-m-d");
                                    $from = new DateTime($fromdate);
                                    $now = new DateTime($today);
                                    $interval = $from->diff($now);
                                    $days = $interval->days;
                                    $days = $days - 1;
                                    $description=$_GET['description'];
                                    $sid=$salaries['SalaryId'];
                                    $employeeid = $salaries['EmployeeId'];
                                    $mon=date('m');
                                    if ($days >= $frequency) {
                                        @$x = $x + 1;
                                        $totalsalaries = $totalsalaries + $salaries['Amount'];
                                        $updatesalaries=mysqli_query($conn, "UPDATE salaries SET Status = '1' WHERE SalaryId = $sid");
                                        
                                    }
                                

                                 //compute deductions and salaries
                                 if($loans == 1)
                                 {
                                     $selectloan=mysqli_query($conn, "SELECT * FROM loans WHERE EmployeeId = $employeeid ORDER BY LoanId DESC");
                                     $found=mysqli_fetch_array($selectloan);
                                     if(!empty($found))
                                     {
                                         $amount=$found['Amount'];
                                         $loanid=$found['LoanId'];
                                         $percentage=$found['PercentagePayment'];
                                         $sub=$amount * $percentage;
                                         $perc=$sub / 100;
                                         $salary = $salary - $perc;
                                         $remainingloan=$amount - $perc;
                                         $updateloans=mysqli_query($conn, "UPDATE loans SET Amount = '$remainingloan' WHERE LoanId = $loanid ");
                                         
                                     }
                                 }
                                 if($deductions == 1)
                                 {
                                     $selectdeductions=mysqli_query($conn, "SELECT * FROM deductions WHERE EmployeeId = $employeeid ORDER BY DeductionId DESC");
                                     $found=mysqli_fetch_array($selectdeductions);
                                     if(!empty($found))
                                     {
                                         $amount=$found['Amount'];
                                         $deductionid=$found['DeductionId'];
                                         $salary = $salary - $amount;   
                                         $deduction= $amount;
                                         $remainigdeduction=$amount - $deduction;  
                                         $updatedeductions=mysqli_query($conn, "UPDATE deductions SET Amount = '$remainigdeduction' WHERE DeductionId = $deductionid ");

                                     }                                                                                    

                                 }
                                }
                                 
                                $savepayroll=mysqli_query($conn, "INSERT INTO payroll(Description, Dates,Amount,EmployeesNumber,UserId,Month) VALUES ('$description', '$today', '$totalsalaries', '$x' ,'$userid', '$mon') ");
                                if($savepayroll == 1)
                                echo "<script> window.location='salaries.php?mon=$mon';</script>";
                                   

                            }
                            ?>

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
<?php }
 ?>