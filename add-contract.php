<?php
session_start();
include('include/config.php');
$employeeid = $_GET['employeeid'];
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $frequency = $_POST['frequency'];
        $starting = $_POST['starting'];
        $ending = $_POST['ending'];
        $percentage = $_POST['percentage'];
        $length = '';
        $employeeid = $_GET['employeeid'];
        $cancel = '';
        $status = 1;
        $sql = mysqli_query($conn, "insert into contracts(Tittle,Length,PaymentFrequency,StartingDate,EndingDates,EmployeeId,JobPercentage,cancelreason,status) values('$title','$length', '$frequency', '$starting', '$ending' , '$employeeid', '$percentage', '$cancel', '$status')");
        $_SESSION['msg'] = "contract Created !!";
    }


    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add contract</title>
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
                                    <h3>New contract </h3>
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

                                    <form class="form-horizontal row-fluid" name="subcategory" method="post">

                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Title</label>
                                            <div class="controls">
                                                <input type="text" placeholder="Enter contract title" name="title"
                                                    class="span8 tip" required>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Payment frequency</label>
                                            <div class="controls">
                                                <select name="frequency" class="span8 tip" required>
                                                    <option value="">Select Methode</option>
                                                    <option value="15">15 days</option>
                                                    <option value="30">30 days</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Job percentage</label>
                                            <div class="controls">
                                                <input type="number" placeholder="Job percentage" name="percentage"
                                                    class="span3 tip" required>%
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Starting date</label>
                                            <div class="controls">
                                                <input type="date" placeholder="Enter SubCategory Name" name="starting"
                                                    class="span8 tip" required>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Ending dates</label>
                                            <div class="controls">
                                                <input type="date" placeholder="Enter SubCategory Name" name="ending"
                                                    class="span8 tip" required>
                                            </div>
                                        </div>



                                        <div class="control-group">
                                            <div class="controls">
                                                <button type="submit" name="submit" class="btn">Create</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php
                            if (isset($_GET['del'])) {
                                $contract = $_GET['id'];
                                if(isset($_POST['delete']))
                                {
                                    $reason=$_POST['reason'];
                                    $delete=mysqli_query($conn,"update contracts set status = 0,cancelreason = '$reason' where ContractId= '$contract'");
                                    if($delete = 1)
                                    {
                                        echo "<script>window.alert('contract deleted');window.location='add-contract.php?employeeid=$employeeid';</script>";
                                    }
                                }

                                echo "
    <div class='module' id='deletereason'>
    <div class='module-head'>
        <h3>Delete contract?</h3>
    </div>
    <form class='form-horizontal row-fluid' method='post'>

    <div class='control-group'>
        <label class='control-label' for='basicinput'>reason</label>
        <div class='controls'>
        <textarea class='span4' name='reason' rows='5'></textarea>
        </div>
        <div class='controls'>
                                                <button  type='submit' name='delete'  class='btn btn-danger span3'>Comfirm</button>
                                            </div>
    </div>
    </form>
    </div>
    ";
                                mysqli_query($con, "delete from subcategory where id = '" . $_GET['id'] . "'");
                                $_SESSION['delmsg'] = "SubCategory deleted !!";
                            }

                            ?>

                            <div class="module">
                                <div class="module-head">
                                    <h3>Current contract</h3>
                                </div>
                                <div class="module-body table">
                                    <table cellpadding="0" cellspacing="0" border="0"
                                        class="datatable-1 table table-bordered table-striped	 display" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Starting</th>
                                                <th>Ending</th>
                                                <th>frequency</th>
                                                <th>JobPercentage</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php

                                            $query = mysqli_query($conn, "select * from contracts WHERE EmployeeId = $employeeid AND status!=0");
                                            $cnt = 1;
                                            while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo htmlentities($cnt); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($row['Tittle']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($row['StartingDate']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($row['EndingDates']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($row['PaymentFrequency']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($row['JobPercentage']); ?>%
                                                    </td>
                                                    <td>
                                                        <a href="edit-contract.php?id=<?php echo $row['ContractId'] ?>"><i
                                                                class="icon-edit"></i></a>
                                                        <a href="add-contract.php?id=<?php echo $row['ContractId'] ?>&del=delete&employeeid=<?php echo $employeeid; ?>#deletereason"
                                                            onClick="return confirm('Are you sure you want to delete contract?')"><i
                                                                class="icon-remove-sign"></i></a>
                                                    </td>
                                                </tr>
                                                <?php $cnt = $cnt + 1;
                                            } ?>

                                    </table>
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