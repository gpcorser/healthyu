<?php 
	require 'database.php';

	// if values were passed, validate and insert
	if ( !empty($_POST)) {
			
		// get values
		$user_id = $_POST['user_id'];
		$transtype_id = $_POST['transtype_id'];
		$trans_date = $_POST['trans_date'];
		$trans_points = $_POST['trans_points'];
		$minutes = $_POST['minutes'];

		// validate input
		$user_idError = null;
		$transtype_idError = null;
		$trans_dateError = null;
		$trans_pointsError = null;
		$minutesError = null;
		
		$valid = true;
		if (empty($user_id)) {
			$user_idError = 'Please enter user_id';
			$valid = false;
		}
		if (empty($transtype_id)) {
			$transtype_idError = 'Please enter transtype_id';
			$valid = false;
		} 

		// insert record
		if ($valid) 
		{
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO healthyu_transactions ";
			$sql .= "(user_id, transtype_id, trans_date, trans_points, minutes) ";
			$sql .= "values(?, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($user_id,$transtype_id,$trans_date,$trans_points,$minutes));
			Database::disconnect();
			header("Location: hu_transactions_list.php");
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
		<div class="span10 offset1">
			<div class="row">
				<h3>HealthyU: Create Transaction</h3>
			</div>
			<p>
				<a href="hu_start.html" class="btn btn-primary">Back to Start</a>
			</p>
	
			<form class="form-horizontal" action="hu_transactions_create.php" method="post" enctype="multipart/form-data">
			
				<div class="control-group <?php echo !empty($user_idError)?'error':'';?>">
					<label class="control-label">user_id</label>
					<div class="controls">
						<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM healthyu_users ORDER BY username ASC';
							echo "<select class='form-control' name='user_id' id='user_id'>";
							foreach ($pdo->query($sql) as $row) {
								echo "<option value='" . $row['id'] . " '> " . 
								    trim($row['username']) . " (" . 
									trim($row['fullname']) . ") " .
									"</option>";
							}
							echo "</select>";
							Database::disconnect();
						?>
					</div>
				</div>
			  
				<div class="control-group <?php echo !empty($transtype_idError)?'error':'';?>">
					<label class="control-label">transtype_id</label>
					<div class="controls">
						<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM healthyu_transtypes ORDER BY description ASC';
							echo "<select class='form-control' name='transtype_id' id='transtype_id'>";
							foreach ($pdo->query($sql) as $row) {
								$hu = "";
								$strength = "";
								$fitness = "";
								if($row['hu_activity']==1) $hu = ", hu_activity";
								if($row['strength_activity']==1) $strength = ", strength";
								if($row['fitness_class']==1) $fitness = ", fitness";
								echo "<option value='" . $row['id'] . " '> " . 
								    trim($row['description']) . " (" . 
									trim($row['points']) . trim($hu) . trim($strength) . ") " .
									"</option>";
							}
							echo "</select>";
							Database::disconnect();
						?>
					</div>
				</div>
			  
				<div class="control-group <?php echo !empty($trans_dateError)?'error':'';?>">
					<label class="control-label">trans_date</label>
					<div class="controls">
						<input name="trans_date" type="date"  placeholder="date" value="<?php echo !empty($trans_date)?$trans_date:'';?>">
						<?php if (!empty($trans_dateError)): ?>
							<span class="help-inline"><?php echo $trans_dateError;?></span>
						<?php endif;?>
					</div>
				</div>
				
				<div class="control-group <?php echo !empty($minutesError)?'error':'';?>">
					<label class="control-label">minutes</label>
					<div class="controls">
						<input name="minutes" type="text"  placeholder="minutes" value="<?php echo !empty($minutes)?$minutes:'';?>">
						<?php if (!empty($minutesError)): ?>
							<span class="help-inline"><?php echo $minutesError;?></span>
						<?php endif;?>
					</div>
				</div>	
				
				<div class="form-actions">
					<button type="submit" class="btn btn-success">Create</button>
					<a class="btn" href="act_log_list.php">Back</a>
				</div>
				
			</form>
			
		</div> <!-- span10 offset1 -->
    </div> <!-- container -->
</body>
</html>