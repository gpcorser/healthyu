<?php 
	require 'database.php';
	
	// if values were passed, validate and insert
	if ( !empty($_POST)) {
			
		// get values
		$user_id = $_POST['user_id'];
		$transtype_id = $_POST['transtype_id'];
		$trans_date = $_POST['trans_date'];
		$trans_points = $_POST['trans_points'];
		$trans_exercise_points = $_POST['trans_exercise_points'];
		$trans_hu_activity = $_POST['trans_hu_activity'];
		$trans_strength_activity = $_POST['trans_strength_activity'];
		$trans_fitness_class = $_POST['trans_fitness_class'];
		$minutes = $_POST['minutes'];

		// validate input
		$user_idError = null;
		$transtype_idError = null;
		$trans_dateError = null;
		$trans_pointsError = null;
		$trans_exercise_pointsError = null; 
		$trans_hu_activityError = null; 
		$trans_strength_activityError = null; 
		$trans_fitness_classError = null; 
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
			$sql .= "(user_id, transtype_id, trans_date, trans_points, minutes, trans_exercise_points, trans_hu_activity, trans_strength_activity, trans_fitness_class) ";
			$sql .= "values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($user_id,$transtype_id,$trans_date,$trans_points,$minutes,$trans_exercise_points,$trans_hu_activity, $trans_strength_activity, $trans_fitness_class));
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
	<script src="hu_transactions.js"></script>
</head>

<body onload="calcDate();">
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
								$hu_str = "";
								$strength_str = "";
								$fitness_str = "";
								$points_str = "";
								$selected_str = "";
								if($row['hu_activity']==1) $hu_str = ", hu_activity";
								if($row['strength_activity']==1) $strength_str = ", strength";
								if($row['fitness_class']==1) $fitness_str = ", fitness";
								if($row['points']>0) $points_str = trim($row['points']);
								else $points_str = "Enter minutes";
								# if($row['id']==13) $selected_str = " selected";
								if($row['description']=="Exercise") $selected_str = " selected";
								echo "<option value='" . $row['id'] . "' " . $selected_str . "> " . 
								    trim($row['description']) . " (" . 
									trim($points_str) . trim($hu_str) . trim($strength_str) . ") " .
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
						<input id="trans_date" name="trans_date" type="date"  placeholder="date" value="<?php echo !empty($trans_date)?$trans_date:'';?>">
						<?php if (!empty($trans_dateError)): ?>
							<span class="help-inline"><?php echo $trans_dateError;?></span>
						<?php endif;?>
					</div>
				</div>
				
				<div class="control-group <?php echo !empty($minutesError)?'error':'';?>">
					<label class="control-label">minutes</label>
					<div class="controls">
						<input name="minutes" type="text"  placeholder="minutes" value="<?php echo !empty($minutes)?$minutes:'';?>" id="minutes" onkeyup="calcExercisePoints()">
						<?php if (!empty($minutesError)): ?>
							<span class="help-inline"><?php echo $minutesError;?></span>
						<?php endif;?>
					</div>
				</div>	
				
				<div class="control-group">
					<label class="control-label">trans_exercise_points</label>
					<div class="controls">
						<input type="text" name="trans_exercise_points" id="trans_exercise_points" value="0" readonly>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">trans_points</label>
					<div class="controls">
						<input type="text" name="trans_points" id="trans_points" value="0" readonly>
					</div>
				</div>
				
				<!-- checkbox: trans_hu_activity -->
				<div class="control-group">
					<label class="control-label">trans_hu_activity</label>
					<div class="controls">
						<input type="checkbox" name="trans_hu_activity" id="trans_hu_activity" value="1" onclick="trans_hu_activity_click();calcExercisePoints();">
					</div>
				</div>
				
				<!-- checkbox: trans_strength_activity -->
				<div class="control-group">
					<label class="control-label">trans_strength_activity</label>
					<div class="controls">
						<input type="checkbox" name="trans_strength_activity" id="trans_strength_activity" value="1" onclick="trans_strength_activity_click();calcExercisePoints();">
					</div>
				</div>
				
				<!-- checkbox: trans_fitness_class -->
				<div class="control-group">
					<label class="control-label">trans_fitness_class</label>
					<div class="controls">
						<input type="checkbox" name="trans_fitness_class" id="trans_fitness_class" value="1" onclick="trans_fitness_class_click();calcExercisePoints();">
					</div>
				</div>

				<div class="form-actions">
					<button type="submit" class="btn btn-success">Create</button>
					<a class="btn" href="hu_transactions_list.php">Back</a>
				</div>
				
			</form>
			
		</div> <!-- end: span10 offset1 -->
    </div> <!-- end: container -->
</body>
</html>