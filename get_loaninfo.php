<?php
include('include/config.php');
if (!empty($_POST["employeeid"])) {
    $id = intval($_POST['employeeid']);
    $query = mysqli_query($conn, "SELECT * FROM loans WHERE EmployeeId=$id");
    ?>

    <?php
    $total = 0;
    while ($row = mysqli_fetch_array($query)) {

        $amount = $row['Amount'];
        $total = $amount + $total;
    }

        ?>
        <label class="control-label" for="basicinput">Current loan</label>
        <div class="controls" id="hisloan">

            <input type='text' value="<?php echo htmlentities($total) . "RWF"; ?>" name="amount" disabled>

        </div>
        <?php
    
}

?>