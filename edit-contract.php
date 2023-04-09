<?php
session_start();
include('include/config.php');
$contractid = $_GET['id'];
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $frequency = $_POST['frequency'];
        $starting = $_POST['starting'];
        $ending = $_POST['ending'];
        $percentage = $_POST['percentage'];
        $cancel = '';
        $status = 1;
        //calculating days interval
        $from = new DateTime($starting);
        $to = new DateTime($ending);
        $interval = $from->diff($to);
        $num_days = $interval->days;

        $sql = mysqli_query($conn, "UPDATE contracts set Tittle= '$title',Length = '$num_days',PaymentFrequency = '$frequency', StartingDate = '$starting',EndingDates = '$ending' ,JobPercentage = '$percentage' WHERE ContractId = '$contractid' ");
        $_SESSION['msg'] = "contract info Changed succesfully !!";
        if(!$sql)
        {
            echo mysqli_error($conn);
        }
    }


    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit contract</title>
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
                                    <h3>Edit contract </h3>
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
                                            <?php echo htmlentities($_SESSION['delmsg'] = ""); 
                                           
                                            ?>
                                        </div>
                                    <?php } ?>

                                    <br />
                                    <?php 
                                     $selectcontract=mysqli_query($conn,"SELECT * FROM contracts WHERE ContractId = $contractid");
                                     $current=mysqli_fetch_array($selectcontract);
                                    ?>

                                    <form class="form-horizontal row-fluid" method="post">

                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Title</label>
                                            <div class="controls">
                                                <input type="text" placeholder="Enter contract title" name="title"
                                                    class="span8 tip" value="<?php echo $current['Tittle']; ?>" required>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Payment frequency</label>
                                            <div class="controls">
                                                <select name="frequency" class="span8 tip" required>
                                                    <option value="<?php echo $current['PaymentFrequency']?>"><?php echo $current['PaymentFrequency']."days"?></option>
                                                    <option value="15">15 days</option>
                                                    <option value="30">30 days</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Job percentage</label>
                                            <div class="controls">
                                                <input type="number" placeholder="Job percentage" name="percentage" value="<?php echo $current['JobPercentage']?>"
                                                    class="span3 tip" required>%
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Starting date</label>
                                            <div class="controls">
                                                <input type="date" placeholder="Enter SubCategory Name" name="starting"
                                                    class="span8 tip" required> * <?php echo $current['StartingDate']?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Ending dates</label>
                                            <div class="controls">
                                                <input type="date" placeholder="Enter SubCategory Name" name="ending"
                                                    class="span8 tip" required>* <?php echo $current['EndingDates']?>
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
    </body>
<?php } ?>