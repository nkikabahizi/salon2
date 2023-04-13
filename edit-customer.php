<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

  
        $_SESSION['msg'] = "Customer edited Successfully !!";

    


    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HDSMS| Manage cutomers</title>
        <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="css/theme.css" rel="stylesheet">
        <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
            rel='stylesheet'>
        <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
        <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>

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
                                    <h3>Edit customer</h3>
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
                                    <?php 
                                    $customerid=$_GET['id'];
                                    $selectcustomer=mysqli_query($conn, "SELECT * FROM customers WHERE CustomerId= $customerid");
                                    $thiscustomer=mysqli_fetch_array($selectcustomer);
                                    ?>

                                    <form class="form-horizontal row-fluid" name="insertproduct" method="post"
                                        enctype="multipart/form-data">
                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Customer name</label>
                                            <div class="controls">
                                                <input type="text" name="customername" placeholder="Enter Product Name"
                                                    class="span8 tip" value="<?php echo $thiscustomer['fullName'];  ?>" required>

                                            </div>
                                        </div>


                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Phone number</label>
                                            <div class="controls">
                                                <input type="number" name="phone" placeholder="Enter Phone number"
                                                    class="span8 tip" value="<?php echo $thiscustomer['PhoneNumber'];  ?>" required> *for payment(07********)
                                            </div>
                                        </div>


                                        <div class="control-group">
                                            <div class="controls">
                                                <button type="submit" name="submit" class="btn btn-primary">Save</button>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php
                            if (isset($_POST['submit'])) {
                                $name = $_POST['customername'];
                                $phone = $_POST['phone'];
                                $salonid = $_SESSION['salonid'];
                                $saving = mysqli_query($conn, "UPDATE customers SET fullName = '$name', PhoneNumber = '$phone' WHERE CustomerId = $customerid ");
                               

                            }
                            ?>
                        






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