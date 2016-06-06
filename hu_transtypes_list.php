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
    		<h3>HealthyU: Transaction Types</h3>
    	</div>

		<div class="row">
			<p>
				<a href="hu_transtypes_create.php" class="btn btn-success">Create</a>
				<a href="hu_start.html" class="btn btn-primary">Back to Start</a>
			</p>
			<!-- 	 2. body: display table --> 
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
					  <th>Description</th>
					  <th>Points</th>
					  <th>HealthyU?</th>
					  <th>Strength?</th>
					  <th>Fitness?</th>
					  <th>Buttons</th>
					</tr>
				</thead>
				<tbody>
				<!-- 3. body (php/mysql): populate table -->
				<?php 
					include 'database.php';
					$pdo = Database::connect();
					$sql = 'SELECT * FROM healthyu_transtypes ORDER BY description ASC';
					foreach ($pdo->query($sql) as $row) {
						echo '<tr>';
						echo '<td>'. $row['description'] . '</td>';
						echo '<td>'. $row['points'] . '</td>';
						if ($row['hu_activity']==1) $hu = "yes";
						else $hu = "";
						echo '<td>'. $hu . '</td>';
						if ($row['strength_activity']==1) $strength = "yes";
						else $strength = "";
						echo '<td>'. $strength . '</td>';
						if ($row['fitness_class']==1) $fitness = "yes";
						else $fitness = "";
						echo '<td>'. $fitness . '</td>';
						echo '<td width=250>';
						echo '<a class="btn" href="hu_transtypes_read.php?id='.$row['id'].'">Read</a>';
						echo '&nbsp;';
						echo '<a class="btn btn-success" href="hu_transtypes_update.php?id='.$row['id'].'">Update</a>';
						echo '&nbsp;';
						echo '<a class="btn btn-danger" href="hu_transtypes_delete.php?id='.$row['id'].'">Delete</a>';
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