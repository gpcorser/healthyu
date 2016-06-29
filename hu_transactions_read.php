<?php 
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: hu_transactions_list.php");
	}
	
	// if data was entered by the user
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
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE healthyu_transactions set user_id = ?, transtype_id = ?, trans_date = ?, trans_points = ?, minutes = ?, trans_exercise_points = ?, trans_hu_activity = ?, trans_strength_activity = ?, trans_fitness_class = ?  WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($user_id,$transtype_id,$trans_date,$trans_points,$minutes, $trans_exercise_points, $trans_hu_activity, $trans_strength_activity, $trans_fitness_class, $id));
			Database::disconnect();
			header("Location: hu_transactions_list.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM healthyu_transactions where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$user_id = $data['user_id'];
		$transtype_id = $data['transtype_id'];
		$trans_date = $data['trans_date'];
		$trans_points = $data['trans_points'];
		$trans_exercise_points = $data['trans_exercise_points'];
		$trans_hu_activity = $data['trans_hu_activity'];
		$trans_strength_activity = $data['trans_strength_activity'];
		$trans_fitness_class = $data['trans_fitness_class'];
		$minutes = $data['minutes'];
		Database::disconnect();
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

<body onload="calcExercisePoints();">
    <div class="container">
    
    	<div class="span10 offset1">
    		<div class="row">
		    	<h3>HealthyU: Read Transaction</h3>
		    </div>
			<p>
				<a href="hu_start.html" class="btn btn-primary">Back to Start</a>
			</p>
    		
	    	<form class="form-horizontal" action="hu_transactions_update.php?id=<?php echo $id?>" method="post">
					
				<div class="control-group <?php echo !empty($user_idError)?'error':'';?>">
					<label class="control-label">user_id</label>
					<div class="controls">
						<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM healthyu_users ORDER BY username ASC';
							echo "<select class='form-control' name='user_id' id='user_id'>";
							foreach ($pdo->query($sql) as $row) {
								$selected = "";
								if ($row['id'] == $user_id) $selected = "selected";
								echo "<option value='" . $row['id'] . " '". $selected. "> " . 
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
								$selected = "";
								if ($row['id'] == $transtype_id) $selected = "selected";
								$hu = "";
								$strength = "";
								$fitness = "";
								if($row['hu_activity']==1) $hu = ", hu_activity";
								if($row['strength_activity']==1) $strength = ", strength";
								if($row['fitness_class']==1) $fitness = ", fitness";
								echo "<option value='" . $row['id'] . " '". $selected. "> " . 
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
						<input id="trans_date" name="trans_date" type="date"  placeholder="date" value="<?php echo !empty($trans_date)?$trans_date:'';?>" readonly>
						<?php if (!empty($trans_dateError)): ?>
							<span class="help-inline"><?php echo $trans_dateError;?></span>
						<?php endif;?>
					</div>
				</div>
				

				<div class="control-group <?php echo !empty($minutesError)?'error':'';?>">
					<label class="control-label">minutes</label>
					<div class="controls">
						<input name="minutes" type="text"  placeholder="minutes" value="<?php echo !empty($minutes)?$minutes:'';?>" id="minutes" onkeyup="calcExercisePoints()" readonly>
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
						<input type="checkbox" name="trans_hu_activity" id="trans_hu_activity" value="1" onclick="trans_hu_activity_click();calcExercisePoints();" <?php echo !empty($trans_hu_activity)?'checked':'';?> readonly>
					</div>
				</div>
				
				<!-- checkbox: trans_strength_activity -->
				<div class="control-group">
					<label class="control-label">trans_strength_activity</label>
					<div class="controls">
						<input type="checkbox" name="trans_strength_activity" id="trans_strength_activity" value="1" onclick="trans_strength_activity_click();calcExercisePoints();" <?php echo !empty($trans_strength_activity)?'checked':'';?> readonly>
					</div>
				</div>
				
				<!-- checkbox: trans_fitness_class -->
				<div class="control-group">
					<label class="control-label">trans_fitness_class</label>
					<div class="controls">
						<input type="checkbox" name="trans_fitness_class" id="trans_fitness_class" value="1" onclick="trans_fitness_class_click();calcExercisePoints();" <?php echo !empty($trans_fitness_class)?'checked':'';?> readonly>
					</div>
				</div>
				
				<div class="form-actions">
					<a class="btn" href="hu_transactions_list.php">Back</a>
				</div>
				
			</form>
			
		</div> <!-- end: span 10 offset -->
				
    </div> <!-- end: container -->
  </body>
</html>