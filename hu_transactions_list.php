<!DOCTYPE html>
<html lang="en">
<!-- 1. head: include bootstrap files -->
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    	<div class="row">
    		<h3>HealthyU: Transactions</h3>
			<p><strong>Transactions</strong> include any and all events that might affect the calculation of HealthyU rewards, 
			including all transaction types (transtypes): exercise minutes, HealthyU activities, fitness classes, etc.</p>
    	</div>
		<div class="row">
			<p>
				<a href="hu_transactions_create.php" class="btn btn-success">Create</a>
				<a href="hu_start.html" class="btn btn-primary">Back to Start</a>
			</p>
			<!-- 	 2. body: display table --> 
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
					  <th>User</th>
					  <th>TransType</th>
					  <th>Date</th>
					  <th>Points</th>
					  <th>Minutes</th>
					  <th>Buttons</th>
					</tr>
				</thead>
				<tbody>
				<!-- 3. body (php/mysql): populate table -->
				<?php 
					include 'database.php';
					$pdo = Database::connect();
					$sql = 'SELECT * FROM healthyu_transactions AS HU1 '; 
					$sql .= 'INNER JOIN healthyu_users AS HU2 ';
					$sql .= 'ON HU1.user_id = HU2.id ' ;
					$sql .= 'INNER JOIN healthyu_transtypes AS HU3 ';
					$sql .= 'ON HU1.transtype_id = HU3.id ' ;
					$sql .= 'ORDER BY HU2.username ASC, HU1.trans_date DESC';
					foreach ($pdo->query($sql) as $row) {
						echo '<tr>';
						echo '<td>'. $row['username'] . '</td>';
						echo '<td>'. $row['description'] . '</td>';
						echo '<td>'. $row['trans_date'] . '</td>';
						echo '<td>'. $row['trans_points'] . '</td>';
						echo '<td>'. $row['minutes'] . '</td>';
						echo '<td width=250>';
						echo '<a class="btn" href="hu_transactions_read.php?id='.$row[0].'">Read</a>';
						echo '&nbsp;';
						echo '<a class="btn btn-success" href="hu_transactions_update.php?id='.$row[0].'">Update</a>';
						echo '&nbsp;';
						echo '<a class="btn btn-danger" href="hu_transactions_delete.php?id='.$row[0].'">Delete</a>';
						echo '</td>';
						echo '</tr>';
					}
					Database::disconnect();
				?>
				</tbody>
			</table>
    	</div>
    </div> <!-- /container -->
</body>
</html>