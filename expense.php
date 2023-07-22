<?php include('include/config.php'); 
session_start();
?>


<div class="module-head">
    <h3>Manage Expenses</h3>
</div>
<div class="module-body table">

    <form class="form-horizontal row-fluid" method="post" >


        <div class="control-group">
            <label class="control-label" for="basicinput">Title</label>
            <div class="controls">
                <input type="text" name="tittle" placeholder="Enter expense title" class="span8 tip" required>

            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="basicinput">Amount</label>
            <div class="controls">
                <input type="number" name="amount" placeholder="Enter expense amount" class="span8 tip" required>

            </div>
        </div>



        <div class="control-group">
            <label class="control-label" for="basicinput">Description</label>
            <div class="controls">
                <textarea name="description" placeholder="Enter Product Description" rows="6" class="span8 tip">
                                    </textarea>
            </div>
        </div>



        <div class="control-group">
            <div class="controls">
                <button type="submit" name="save" class="btn">Insert</button>
            </div>
        </div>
    </form>
</div>
</div>
<div class="module-head">
    <h3>Current expenses</h3>
</div>
<div class="module-body table"></div>


<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display"
    width="100%">
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
                $selectrent= mysqli_query($conn, "select * from expenses WHERE SalonId = '$salonid' AND Type= 'Expense' ORDER BY ExpenseId DESC");
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
            <?php $cnt = $cnt + 1;
        } ?>

</table>

<?php
if (isset($_POST['save']))
{
    $desc=$_POST['description'];
    $salonid=$_SESSION['salonid'];
    $amount=$_POST['amount'];
    $mon=date('m');
    $salonid=$_SESSION['salonid'];
    $dates=date('d/m/Y');
    $type='Expense';
    $saveexpense=mysqli_query($conn, "INSERT INTO expenses(Description,Amount,Typee,Mon,Dates,SalonId) VALUES ('$desc','$amount','$type','$mon','$dates','$salonid')");
    // if($saveexpense == 1)
    // {
    //     echo "<script>alert(saved);</script>";
    // }
    // else{
    //     echo "<script>alert(Failed);</script>";

    // }

}
?>
</div>
</div>