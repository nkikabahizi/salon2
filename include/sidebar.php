<div class="span3">
	<div class="sidebar">


		<ul class="widget widget-menu unstyled">
			<li>
				<a class="collapsed" data-toggle="collapse" href="#togglePages">
					<i class="menu-icon icon-folder-close"></i>
					<i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>
					Bills Management
				</a>
				<ul id="togglePages" class="collapse unstyled">
					<li>
						<a href="newbill.php">
							<i class="icon-tasks"></i>
							New bill

						</a>
					</li>
					<li>
						<a href="today-bills.php">
							<i class="icon-tasks"></i>
							Today's' bills
							<?php
							$status = '1';
							$today = date('d' ,time());

							$ret = mysqli_query($conn, "SELECT * FROM billing where Status='$status' AND Day = '$today'");
							$num = mysqli_num_rows($ret); { ?><b class="label orange pull-right">
									<?php echo htmlentities($num); ?>
								</b>
							<?php } ?>
						</a>
					</li>
					<li>
						<a href="monthly-bills.php?mon=<?php echo date('m'); ?>">
							<i class="icon-inbox"></i>
							This month bills
							<?php
							$status = '1';
							$mon=date('m');
							$rt = mysqli_query($conn, "SELECT * FROM billing where Status!=0 AND Mon = '$mon' ");
							$num1 = mysqli_num_rows($rt); { ?><b class="label green pull-right">
									<?php echo htmlentities($num1); ?>
								</b>
							<?php } ?>

						</a>
					</li>
				</ul>

			<li>
				<a class="collapsed" data-toggle="collapse" href="#toggleimventory">
					<i class="menu-icon icon-folder-close"></i>
					<i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>
					Imventory Management
				</a>
				<ul id="toggleimventory" class="collapse unstyled">
					<li>
						<a href="manage-products.php">
							<i class="icon-tasks"></i>
							Manage products
						</a>
					</li>
					<li>
						<a href="manage-services.php">
							<i class="icon-tasks"></i>
							Manage services
						</a>
					</li>
					<li>
						<a href="purchase-sales.php">
							<i class="icon-tasks"></i>
							Purchase sales
						</a>
					</li>
				</ul>
			</li>

			<li>
				<a class="collapsed" data-toggle="collapse" href="#togglehr">
					<i class="menu-icon icon-folder-close"></i>
					<i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>
					HR management
				</a>
				<ul id="togglehr" class="collapse unstyled">
					<li>
						<a href="manage-employees.php">
							<i class="icon-tasks"></i>
							Manage employees
						</a>
					</li>
					<li>
						<a href="listcontracts.php?filter=1">
							<i class="icon-tasks"></i>
							Manage contracts
						</a>
					</li>
					<li>
						
						<a href="salaries.php?mon=<?php echo $mon; ?>">
							<i class="icon-tasks"></i>
							Manage salaries
						</a>
					</li>
					<li>
						<a href="loans.php?mon=<?php echo $mon; ?>#loans">
							<i class="icon-tasks"></i>
							Loans and Deductions
						</a>
					</li>
				</ul>
			</li>
			<li>
				<a class="collapsed" data-toggle="collapse" href="#togglecustomers">
					<i class="menu-icon icon-folder-close"></i>
					<i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>
					Customer management
				</a>
				<ul id="togglecustomers" class="collapse unstyled">
					<li>
						<a href="new-customer.php?from=menu">
							<i class="icon-tasks"></i>
							New customer
						</a>
					</li>
					<li>
						<a href="#">
							<i class="icon-tasks"></i>
							Used machine running
						</a>
					</li>
					<li>

					</li>
				</ul>

		</ul>
		<!--/.widget-nav-->

		<ul class="widget widget-menu unstyled">
			<li><a href="change-password.php"><i class="menu-icon icon-tasks"></i>Change password</a></li>

			<li>
				<a href="logout.php">
					<i class="menu-icon icon-signout"></i>
					Logout
				</a>
			</li>
		</ul>

	</div><!--/.sidebar-->
</div><!--/.span3-->