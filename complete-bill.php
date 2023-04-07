<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    if (isset($_POST['submit'])) {
        $category = $_POST['category'];
        $productname = $_POST['name'];
        $productcompany = $_POST['company'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $productdescription = $_POST['description'];
        $availability = $_POST['availability'];
        $salonid = $_SESSION['salonid'];
        $productimage = $_FILES["productimage"]["name"];
        $currentTime = date('d-m-Y h:i:s A', time());
        //for getting product id
        $query = mysqli_query($conn, "select max(ProductId) as pid from products");
        $result = mysqli_fetch_array($query);
        $productid = $result['pid'] + 1;
        $dir = "productimages/$productid";
        if (!is_dir($dir)) {
            mkdir("productimages/" . $productid);
        }
        move_uploaded_file($_FILES["productimage"]["tmp_name"], "productimages/$productid/" . $_FILES["productimage"]["name"]);
        $sql = mysqli_query($conn, "insert into products(Name,Category,Manufacture,Price,ExampleProfile,Quantity,Description,SalonId,Status,UpdationDates) values('$productname','$category','$productcompany','$price','$productimage','$quantity','$productdescription','$salonid','$availability','$currentTime')");
        $_SESSION['msg'] = "Product Inserted Successfully !!";
        $_SESSION['msg'] = "Product Inserted Successfully !!";

    }


    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HDSMS| Complete bill info</title>
        <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="css/theme.css" rel="stylesheet">
        <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
            rel='stylesheet'>
        <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
        <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>

        <link rel="stylesheet" href="chosen.css">
        <link rel="stylesheet" href="docsupport/prism.css">
        <link rel="stylesheet" href="chosen.css">

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
                                    <h3>Insert Product</h3>
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


                                    <?php if (isset($_GET['del'])) { ?>
                                        <div class="alert alert-error">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>Oh snap!</strong>
                                            <?php echo htmlentities($_SESSION['delmsg']); ?>
                                            <?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
                                        </div>
                                    <?php } ?>

                                    <br />

                                    <form class="form-horizontal row-fluid" method="POST">

                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Employee</label>
                                            <div class="controls">
                                                <select name="employeeid" class="span8 tip" required>
                                                    <option value="">Select Employee</option>
                                                    <?php
                                                    $salonid = $_SESSION['salonid'];
                                                    $selectemployees = mysqli_query($conn, "SELECT FullName,EmployeeId FROM employees WHERE SalonId = $salonid");
                                                    while ($emp = mysqli_fetch_array($selectemployees)) {
                                                        ?>
                                                        <option value="<?php echo $emp['EmployeeId']; ?>"><?php echo $emp['FullName']; ?></option>

                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Description</label>
                                            <div class="controls">
                                                <textarea name="description" placeholder="Anything to describe ?" rows="6"
                                                    class="span8 tip">
                                                                                                            </textarea>
                                            </div>
                                        </div>
                                        <div class="module-head">
                                            <h3>Payment info</h3>
                                        </div>




                                        <?php

                                        $billid = $_GET['billid'];
                                        $totalbill = 0;
                                        $subtotal = 0;
                                        $total = 0;
                                        $selectbill = mysqli_query($conn, "SELECT * FROM billing WHERE BillingId = $billid");
                                        $bill = mysqli_fetch_array($selectbill);
                                        $totalbill = $totalbill + $bill['ServiceFee'];
                                        $selectbillinfo = mysqli_query($conn, "SELECT products.Price,billinginfo.Quantity,billinginfo.BillinginfoId FROM billinginfo,products WHERE billinginfo.ProductId=products.ProductId AND BillingId = $billid");
                                        while ($billinfo = mysqli_fetch_array($selectbillinfo)) {
                                            $unitprice = $billinfo['Price'];
                                            $subtotal = $unitprice * $billinfo['Quantity'];
                                            $totalbill = $subtotal + $totalbill;
                                        }
                                        ?>
                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Total bill</label>
                                            <div class="controls">
                                                <input type="number" name="totalbill" placeholder="Total bill"
                                                    class="span8 tip" value="<?php echo $totalbill; ?>" required disabled>

                                            </div>
                                        </div>
                                        <?php


                                        if (!isset($_GET['customerid'])) {
                                            ?>
                                            <div class="control-group">
                                                <label class="control-label" for="basicinput">Customer name</label>
                                                <div class="controls">
                                                    <script>
                                                        function getcustomerinfo(val) {
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "get_customerinfo.php",
                                                                data: 'customerid=' + val,
                                                                success: function (data) {
                                                                    $("#hisphone").html(data);
                                                                }
                                                            });
                                                        }
                                                    </script>
                                                    <select name="customerid" onChange="getcustomerinfo(this.value);"
                                                        class="chosen-select span8 tip" multiple tabindex="4" name="products[]"
                                                        data-placeholder="Choose Customer">
                                                        <?php
                                                        $salonid = $_SESSION['salonid'];
                                                        $selectcustomers = mysqli_query($conn, "SELECT FullName,CustomerId FROM customers WHERE SalonId = $salonid");
                                                        while ($customer = mysqli_fetch_array($selectcustomers)) {
                                                            ?>
                                                            <option value="<?php echo $customer['CustomerId']; ?>"><?php echo $customer['FullName']; ?></option>

                                                            <?php
                                                        }
                                                        ?>
                                                    </select>*new here? <a
                                                        href='new-customer.php?billid=<?php echo $billid ?>'><button
                                                            type="button" class='btn btn-primary'>New</button></a>

                                                </div>
                                            </div>


                                            <div class="control-group" id="hisphone">
                                            </div>


                                            <?php
                                        } else {
                                            $customerid = $_GET['customerid'];
                                            $selectcustomer = mysqli_query($conn, "SELECT fullName,PhoneNumber,CustomerId FROM customers WHERE CustomerId = $customerid");
                                            $cust = mysqli_fetch_array($selectcustomer);
                                            ?>
                                            <div class="control-group">
                                                <label class="control-label" for="basicinput">Customer</label>
                                                <div class="controls">
                                                    <input type="text" name="customername" placeholder="Enter Product Name"
                                                        class="span8 tip" value="<?php echo $cust['FullName'] ?>" required
                                                        disabled>

                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="basicinput">Phone number</label>
                                                <div class="controls">
                                                <input type="text" name="customerid" class="span8 tip"
                                                        value="<?php echo $customerid ?>">

                                                    <input type="text" name="phone" class="span8 tip"
                                                        value="<?php echo $cust['PhoneNumber'] ?>" required>
                                                </div>
                                            </div>



                                            <?php

                                        }
                                        ?>
                                        <div class="control-group">
                                            <div class="controls">
                                                <button type="submit" name="savepayment" class="btn">Save payment</button>
                                                <button type="submit" name="paynow" class="btn btn-primary">Pay Now</button>
                                                *MoMo

                                            </div>
                                        </div>
                                    </form>
                                    <?php 
                                    if(isset($_POST['savepayment']))
                                    {
                                        $employeeid=$_POST['employeeid'];
                                        $description=$_POST['description'];
                                        $customerid=$_POST['customerid'];
                                        $phone=$_POST['phone'];
                                        $billid=$_GET['billid'];
                                        $updatebill=mysqli_query($conn,"UPDATE billing SET EmployeeId='$employeeid' , CustomerId='$customerid', Description= '$description' WHERE BillingId='$billid'");
                                        $selectcontract=mysqli_query($conn, "SELECT JobPercentage FROM contracts WHERE EmployeeId = $employeeid");
                                        $contract=mysqli_fetch_array($selectcontract);
                                        $jobpercentage=$contract['JobPercentage'];
                                        $selectfee=mysqli_query($conn,"SELECT ServiceFee from billing WHERE BillingId = $billid");
                                        $fees=mysqli_fetch_array($selectfee);
                                        $fee=$fees['ServiceFee'];
                                        $subpercentage=$fee * $jobpercentage;
                                        $percentage=$subpercentage / 100;

                                        $savesalary=mysqli_query($conn, "INSERT INTO salaries(EmployeeId, Amount, Status) VALUES ('$employeeid', '$percentage', '0')");
                                        
                                    }
                                    ?>
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
        <script src="docsupport/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="chosen.jquery.js" type="text/javascript"></script>
        <script src="docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
        <script src="docsupport/init.js" type="text/javascript" charset="utf-8"></script>
    </body>
<?php } ?>