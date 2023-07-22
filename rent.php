<?php include('include/config.php'); 
session_start();
?>

    <div class="module-head">
        <h3>Manage rent</h3>
    </div>
    <div class="module-body table">
        <table cellpadding="0" cellspacing="0" border="0"
            class="datatable-1 table table-bordered table-striped	 display" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Month</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Dates</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $salonid=$_SESSION['salonid'];
                $selectrent= mysqli_query($conn, "select * from expenses WHERE SalonId = '$salonid' AND Type= 'Rent' ORDER BY ExpenseId DESC");
                $cnt = 1;
                while ($row = mysqli_fetch_array($selectrent)) {
                    $expenseid = $row['ExpenseId'];
                    ?>
                ?>
                <tr>
                    <td><?php echo $cnt; ?></td>
                    <td><?php echo $row['Mon']; ?></td>
                    <td><?php echo $row['Amount']; ?></td>
                    <td><?php echo $row['Description']; ?></td>
                    <td><?php echo $row['Dates']; ?></td>





                </tr>
                <?PHP } $cnt++;  ?>               

        </table>
    </div>
