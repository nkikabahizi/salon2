<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Kolkata'); // change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());


    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin| Pending Orders</title>
        <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="css/theme.css" rel="stylesheet">
        <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
            rel='stylesheet'>
        <link rel="stylesheet" href="chosen.css">   
        <link rel="stylesheet" href="docsupport/prism.css">
        <link rel="stylesheet" href="chosen.css">

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
                            <?php 
                            $serviceid=$_GET['serviceid'];
                            $selectservice=mysqli_query($conn, "SELECT * FROM services WHERE ServiceId= $serviceid");
                            $service=mysqli_fetch_array($selectservice);
                            
                            ?>

                            <div class="module">
                                <div class="module-head">
                                    <h3>Add products to support <?php echo $service['Name']; ?></h3>
                                </div>
                                <?php if (isset($_GET['del'])) { ?>
                                    <div class="alert alert-error">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>Oh snap!</strong>
                                        <?php echo htmlentities($_SESSION['delmsg']); ?>
                                        <?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
                                    </div>
                                <?php } ?>

                                <br />
                                <div>
                                    <table>
                                        <h1>Tarrif</h1>
                                        <thead>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th></th>
                                            <th>Price</th>
                                            <th>Instock</th>

                                        </thead>
                                        <tbody>

                                            <?php
                                            $salonid = $_SESSION['salonid'];
                                            $query = mysqli_query($conn, "select * FROM products where SalonId = '$salonid' AND Status = 'In Stock'");
                                            $cnt = 1;
                                            while ($row = mysqli_fetch_array($query)) {
                                                $pid = $row['ProductId'];

                                                ?>
                                                <tr>
                                                    <td>

                                                        <img src="productimages/<?php echo htmlentities($pid); ?>/<?php echo htmlentities($row['ExampleProfile']); ?>"
                                                            width="60" height="50">
                                                    </td>
                                                    <td>
                                                        <?php echo $row['Name'] ?>

                                                    </td>
                                                    <td></td>
                                                    <td>
                                                        <?php echo $row['Price']; ?>RWF

                                                    </td>
                                                    <td>
                                                        <div class="module-head">
                                                            <?php echo $row['Quantity']; ?>Pcs
                                                        </div>

                                                    </td>
                                                </tr>
                                    </div>



                                <?php } ?>
                                </form>
                                </table>
                                <form method="POST">
                                    <select data-placeholder="Choose products" class="chosen-select" multiple tabindex="4"
                                        name="products[]">
                                  


                                        <?php
                                        $selectproducts = mysqli_query($conn, "SELECT * FROM products WHERE Status = 'In Stock' ");
                                        while ($row = mysqli_fetch_array($selectproducts)) {
                                            $pid = $row['ProductId'];
                                            ?>
                                            <a>
                                                <option class="form-control" value="<?php echo $pid; ?>"> <?php echo $row['Name']; ?></option>
                                            </a>


                                            <?php
                                        }

                                        ?>

                                    
                                    </select>
                                        <button class='btn btn-success' type='submit' name='save'>Continue</button>
                                </form>
                                <?php 
                                if(isset($_POST['save']))
                                {
                                    echo "<table
                                    <thead>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Unit price</th>
                                        <th>Quantity</th>
                                    </thead>
                                    <tbody>";
                                    

                                    $products=$_POST['products'];
                                    $cnt=0;
                                    $totalproducts=0;
                                    foreach ($products as $products) {
                                        $selectproducts = mysqli_query($conn, "SELECT Name,Quantity,Price,ProductId FROM products WHERE ProductId =$products");
                                        $row = mysqli_fetch_array($selectproducts);
                                        $cnt=$cnt + 1;
                                        $totalproducts = $totalproducts + $row['Price'];
                                        $pid=$row['ProductId'];
                                       
                                        ?>
                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <td><b><?php echo $row['Name']; ?></b></td>
                                            <td><b><?php echo $row['Price']; ?>RWF</b></td>
                                         <form method='POST'>
                                            <td><input type="number" value="1" class="span2 tip" name="quantity[<?php echo $pid; ?>]"></td>

                                        </tr>
                                        

                                    
                                    <?php }
                                    ?>
                                    </table>
                                    <button class='btn btn-primary' type='submit' name='savebill'>Save bill</button>
                                    </form>



                                    <?php 
                                    if(isset($_POST['savebill']))
                                    {
                                        $quantity=$_POST['quantity'];
                                        $servicefee=$_GET['price'];
                                        $serviceid=$_GET['serviceid'];
                                        $salonid=$_SESSION['salonid'];
                                        $save=mysqli_query($conn, "INSERT INTO billing(ServiceId,ServiceFee,TotalProducts,EmployeeId,Description,SalonId) VALUES ('$serviceid', '$servicefee', '$totalproducts', '1', 'hey','$salonid')");
                                        if($save == 1)
                                        {
                                            $_SESSION['msg'] = "Product Inserted Successfully !!";
                                        }
                                        else
                                        {
                                            echo mysqli_error($conn);
                                        }
                                        $billid=$conn->insertid();


                                    }

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