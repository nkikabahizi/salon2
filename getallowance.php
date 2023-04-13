<?php
include('include/config.php');
session_start();
if (!empty($_POST["type"])) {
    $frequency = intval($_POST['type']);
    $salonid = $_SESSION['salonid'];
    $i = 0;
    ?>
    <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display"
        width="100%">
        <!-- <thead>
            <tr>
                <th>#</th>
                <th>Names</th>
                <th>From dates</th>
                <th>Amount</th>
            </tr>
        </thead> -->
        <tbody>
            <?php
            $query = mysqli_query($conn, "SELECT * FROM salaries,employees,contracts WHERE employees.EmployeeId = salaries.EmployeeId AND employees.EmployeeId=contracts.EmployeeId AND employees.SalonId = $salonid AND contracts.PaymentFrequency=$frequency AND salaries.Status!=1");
            while ($salaries = mysqli_fetch_array($query)) {
                $fromdate = $salaries['FromDate'];
                $today = date("Y-m-d");
                $from = new DateTime($fromdate);
                $now = new DateTime($today);
                $interval = $from->diff($now);
                $days = $interval->days;
                $days = $days - 1;
                if ($days >= $frequency) {
                $i = $i + 1;

                    ?>
                    <tr>
                        <td><?php echo htmlentities($i); ?></td>
                        <td><?php echo htmlentities($salaries['FullName']); ?></td>
                        <td><?php echo htmlentities($salaries['FromDate']); ?></td>
                        <td><?php echo htmlentities($salaries['Amount']); ?></td>

                        
                    </tr>
                    <?php

                }
            }
            ?>
    </table>
    <?php
}
?>