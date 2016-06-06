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
    		<h3>HealthyU: Users</h3>
    	</div>
		<div class="row">
			<p>
				<a href="hu_users_create.php" class="btn btn-success">Create</a>
				<a href="hu_start.html" class="btn btn-primary">Back to Start</a>
			</p>
			<!-- 	 2. body: display table --> 
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
					  <th>Username</th>
					  <th>Full Name</th>
					  <th>Buttons</th>
					</tr>
				</thead>
				<tbody>
				<!-- 3. body (php/mysql): populate table -->
				<?php 
					include 'database.php';
					$pdo = Database::connect();
					$sql = 'SELECT * FROM healthyu_users ORDER BY username ASC';
					foreach ($pdo->query($sql) as $row) {
						echo '<tr>';
						echo '<td>'. $row['username'] . '</td>';
						echo '<td>'. $row['fullname'] . '</td>';
						echo '<td width=250>';
						echo '<a class="btn" href="user_read.php?id='.$row['id'].'">Read</a>';
						echo '&nbsp;';
						echo '<a class="btn btn-success" href="user_update.php?id='.$row['id'].'">Update</a>';
						echo '&nbsp;';
						echo '<a class="btn btn-danger" href="user_delete.php?id='.$row['id'].'">Delete</a>';
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