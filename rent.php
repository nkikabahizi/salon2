<?php include('include/config.php');
@session_start();
?>

<div class="module-head">
    <h3>Manage rent</h3>
</div>
<div class="module-body">
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
            $salonid = $_SESSION['salonid'];
            $selectrent = mysqli_query($conn, "select * from expenses WHERE SalonId = '$salonid' AND Typee= 'Rent' ORDER BY ExpenseId DESC");
            $cnt = 1;
            while ($row = mysqli_fetch_array($selectrent)) {
                $expenseid = $row['ExpenseId'];
                ?>

                <tr>
                    <td>
                        <?php echo $cnt; ?>
                    </td>
                    <td>
                        <?php echo $row['Mon']; ?>
                    </td>
                    <td>
                        <?php echo $row['Amount']; ?>
                    </td>
                    <td>
                        <?php echo $row['Description']; ?>
                    </td>
                    <td>
                        <?php echo $row['Dates']; ?>
                    </td>
                </tr>
            <?PHP }
            $cnt++; ?>

    </table>
</div>

<div class="module-head">
    <h3>New Rent Payment</h3>
</div>
<div class="module-body ">


    <div class="control-group">
        <label class="control-label" for="basicinput">Month</label>
        <div class="controls">
            <?php
            $lastpayment = mysqli_query($conn, "SELECT Mon FROM Expenses ORDER BY ExpenseId DESC");
            while ($last = mysqli_fetch_array($lastpayment)) {
                $mon = $last['Mon'];
            }
            // echo $lastmon;
            $mon = $mon + 1;

            switch ($mon) {
                case '01':
                    $monthname = 'January';
                    break;
                case '02':
                    $monthname = 'February';
                    break;
                case '03':
                    $monthname = 'March';
                    break;
                case '04':
                    $monthname = 'April';
                    break;
                case '05':
                    $monthname = 'May';
                    break;
                case '06':
                    $monthname = 'June';
                    break;
                case '07':
                    $monthname = 'July';
                    break;
                case '08':
                    $monthname = 'August';
                    break;
                case '09':
                    $monthname = 'September';
                    break;
                case '10':
                    $monthname = 'October';
                    break;
                case '11':
                    $monthname = 'November';
                    break;
                case '12':
                    $monthname = 'December';
                    break;
                default:
                    $mon = date('m');
                    break;
            }

            ?>
  

    <form class="form-horizontal row-fluid" method="post" >
    <div class="control-group">

    <select name="month" class="span3 tip" required>
                    <option value="<?php echo $monthname; ?>">
                        <?php echo $monthname; ?>
                    </option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
        </div>

                <div class="control-group">
        <label class="control-label" for="basicinput">Amount</label>
        <div class="controls">
            <input type="number" name="amount" placeholder="Enter Rent amount" class="span8 tip" required>

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
                <button type="submit" name="saverent" class="btn">Insert</button>
            </div>
        </div>
    </form>
   