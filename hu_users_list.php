    <div class="container">
    	<div class="row">
    		<h3>HealthyU: Users</h3>
    	</div>
		<div class="row">
			<p>
				<a href="hu_users_create.html" class="btn btn-success">Create</a>
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
				<!-- 3. body: populate table -->
				<tbody id="tbody">
<?php 
    include 'database.php';
	$pdo = Database::connect();
    $sql = 'SELECT * FROM healthyu_users ORDER BY username ASC';
    foreach ($pdo->query($sql) as $row) {
        echo '<tr>';
        echo '<td>'. $row['username'] . '</td>';
        echo '<td>'. $row['fullname'] . '</td>';
        echo '<td width=250>';
        echo '<a class="btn" href="hu_users_read.html?id='.$row['id'].'">Read</a>';
        echo '&nbsp;';
        echo '<a class="btn btn-success" href="hu_users_update.html?id='.$row['id'].'">Update</a>';
        echo '&nbsp;';
        echo '<a class="btn btn-danger" href="hu_users_delete.html?id='.$row['id'].'">Delete</a>';
        echo '</td>';
        echo '</tr>';
    }
    Database::disconnect();
?>                    
				</tbody>
			</table>
    	</div>
    </div> <!-- /container -->	