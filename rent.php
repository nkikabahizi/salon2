
<div class="module" id="report" <?php echo @$ishidden; ?>>
								<div class="module-head">
									<h3>Review</h3>
								</div>
								<div class="module-body table">
									<table cellpadding="0" cellspacing="0" border="0"
										class="datatable-1 table table-bordered table-striped	 display" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>Deductions</th>
												<th>Loans</th>
												<th>Salary</th>
											</tr>
										</thead>
										<tbody>

											<?php
											$salonid = $_SESSION['salonid'];
											$employeeid = $_GET['id'];
											$query = mysqli_query($conn, "select * from salaries WHERE EmployeeId = '$employeeid' AND Status != 0");
											$cnt = 1;
											while ($row = mysqli_fetch_array($query)) {
												?>
												<tr>
													<td>
														<?php echo htmlentities($cnt); ?>
													</td>
													<td>
														<?php $selectdeductions = mysqli_query($conn, "select * from deductions WHERE EmployeeId = '$employeeid' AND Mon= '$mon' ");
														$totaldeductions=0;
														while($deductions = mysqli_fetch_array($selectdeductions))
														{
															$totaldeductions=$totaldeductions + $deductions['Amount'];
														}

														echo $totaldeductions; ?>
													</td>
													<td>
													<?php $selectloans = mysqli_query($conn, "select * from loans WHERE EmployeeId = '$employeeid' AND Mon= '$mon' ");
														$totalloans=0;
														while($loans = mysqli_fetch_array($selectloans))
														{
															$totalloans=$totalloans + $loans['Amount'];
														}

														echo $totalloans; ?>
													</td> 
													<td>
														<?php echo $row['Amount']; ?>
													</td>
													
												</tr>
												<?php $cnt = $cnt + 1;
											} ?>

									</table>
								</div>
							</div>