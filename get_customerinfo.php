<?php
include('include/config.php');
if (!empty($_POST["customerid"])) {
    $id = intval($_POST['customerid']);
    $query = mysqli_query($conn, "SELECT * FROM customers WHERE CustomerId=$id");
    ?>

    <?php
    while ($row = mysqli_fetch_array($query)) {
        ?>

        <label class="control-label" for="basicinput">Phone number</label>
        <div class="controls" id="hisphone">
            
            <input type='text' value="<?php echo htmlentities($row['PhoneNumber']); ?>" name="phone">

        </div>


        <?php
    }
}
?>