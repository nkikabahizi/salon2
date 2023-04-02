<?php
session_start();
include('include/config.php');
// if(isset($_GET['filter']) == 'terminated')
// {
//     $statuss=0;
// }
// else
// {
//   $statuss=1;
// }
$statuss = $_GET['filter'];
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) {
        $category = $_POST['category'];
        $subcat = $_POST['subcategory'];
        $sql = mysqli_query($con, "insert into subcategory(categoryid,subcategory) values('$category','$subcat')");
        $_SESSION['msg'] = "SubCategory Created !!";

    }

    if (isset($_GET['del'])) {
        mysqli_query($con, "delete from subcategory where id = '" . $_GET['id'] . "'");
        $_SESSION['delmsg'] = "SubCategory deleted !!";
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage contracts</title>
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
                                    <form method='GET' action="listcontracts.php">
                                        <div>
                                            <div class="col-md-4">
                                                <select name="filter" class="span3 tip" required>
                                                    <option value="1">Active</option>
                                                    <option value="0">Terminated</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary">Filter<span class="icon-filter"> </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="module-body table">
                                    <table cellpadding="0" cellspacing="0" border="0"
                                        class="datatable-1 table table-bordered table-striped	 display" width="100%">
                                        <div class="module-head">  <container><?php if($statuss == 1){echo "<b>active contracts</b>";} elseif($statuss == 0){echo "<b>Terminated contracts</b>";} ?></div>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Employee</th>
                                                <th>Tittle</th>
                                                <th>Length</th>
                                                <th>Payment frequency</th>
                                                <th>Starting date</th>
                                                <th>Ending date</th>
                                                <th>Job Percentage</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php $query = mysqli_query($conn, "select * from contracts,employees WHERE contracts.EmployeeId = employees.EmployeeId AND contracts.status = $statuss");
                                            $cnt = 1;
                                            while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo htmlentities($cnt); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($row['FullName']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($row['Tittle']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($row['Length']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($row['PaymentFrequency']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($row['StartingDate']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($row['EndingDates']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($row['JobPercentage'])."%"; ?>
                                                    </td>
                                                    <td>
                                                        <a href="edit-subcategory.php?id=<?php echo $row['ContractId'] ?>"><i
                                                                class="icon-edit"></i></a>
                                                        <a href="subcategory.php?id=<?php echo $row['ContractId'] ?>&del=delete"
                                                            onClick="return confirm('Are you sure you want to delete?')"><i
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