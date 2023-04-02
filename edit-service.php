<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $sid = intval($_GET['id']); // product id
    if (isset($_POST['submit'])) {
        $category = $_POST['category'];

        $category = $_POST['category'];
        $servicename = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $availability = $_POST['availability'];
        $salonid = $_SESSION['salonid'];
        $sql = mysqli_query($conn, "update  services set Category='$category',Name='$servicename',Price='$price',Description='$description',Status='$availability'");
        $_SESSION['msg'] = "service Updated Successfully !!";

    }


    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Service</title>
        <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="css/theme.css" rel="stylesheet">
        <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
            rel='stylesheet'>
        <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
        <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>

        <script>
            function getSubcat(val) {
                $.ajax({
                    type: "POST",
                    url: "get_subcat.php",
                    data: 'cat_id=' + val,
                    success: function (data) {
                        $("#subcategory").html(data);
                    }
                });
            }
            function selectCountry(val) {
                $("#search-box").val(val);
                $("#suggesstion-box").hide();
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
                                    <h3>Edit product</h3>
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

                                    <form class="form-horizontal row-fluid" name="insert services" method="post"
                                        enctype="multipart/form-data">

                                        <?php

                                        $query = mysqli_query($conn, "select * from services where ServiceId='$sid'");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($query)) {
                                            $cid=$row['ServiceId'];
                                            ?>


                                            <div class="control-group">
                                                <label class="control-label" for="basicinput">Category</label>
                                                <div class="controls">
                                                    <select name="category" required>
                                                        <option value="<?php echo htmlentities($row['Category']); ?>"><?php echo htmlentities($row['Category']); ?></option>
                                                        <option value="">Select Category</option>
													<option value="Hair Dressing">Hair Dressing</option>
													<option value="Nail dressing">Nail dressing</option>
													<option value="Make up">Make up</option>
													<option value="Face Massage">Face Massage</option>

                                                    </select>
                                                </div>
                                            </div>



                                            <div class="control-group">
                                                <label class="control-label" for="basicinput">Service Name</label>
                                                <div class="controls">
                                                    <input type="text" name="name" placeholder="Enter service Name"
                                                        value="<?php echo htmlentities($row['Name']); ?>" class="span8 tip">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="basicinput">Price</label>
                                                <div class="controls">
                                                    <input type="text" name="price"
                                                        placeholder="Enter Product Comapny Name"
                                                        value="<?php echo htmlentities($row['Price']); ?>"
                                                        class="span8 tip" required>
                                                </div>
                                            </div>


                                            <div class="control-group">
                                                <label class="control-label" for="basicinput">Service Description</label>
                                                <div class="controls">
                                                    <textarea name="description" placeholder="Enter service Description"
                                                        rows="6" class="span8 tip">
                        <?php echo htmlentities($row['Description']); ?>
                        </textarea>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="basicinput">Product Availability</label>
                                                <div class="controls">
                                                    <select name="availability" id="productAvailability"
                                                        class="span8 tip" required>
                                                        <option value="<?php echo htmlentities($row['Status']); ?>">
                                                            <?php echo htmlentities($row['Status']); ?></option>
                                                            <option value="In Stock">Available</option>
													<option value="Out of Stock">Out of service</option>
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="control-group">
                                                <label class="control-label" for="basicinput">Service image</label>
                                                <div class="controls">
                                                    <img src="serviceimage/<?php echo htmlentities($cid); ?>/<?php echo htmlentities($row['ExampleProfile']); ?>"
                                                        width="200" height="100"> <a
                                                        href="update-service-image.php?id=<?php echo $row['ServiceId']; ?>">Change
                                                        Image</a>
                                                </div>
                                            </div>




                                        <?php } ?>
                                        <div class="control-group">
                                            <div class="controls">
                                                <button type="submit" name="submit" class="btn">Update</button>
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