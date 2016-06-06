<?php 
// session_start();

// if not loggedin redirect to act_list.php
// if ($_SESSION['loggedin'] == false) header("Location: act_list.php");

	require 'database.php';

	// if values were passed, validate and insert
	if ( !empty($_POST)) {
			
		// get values
		$description = $_POST['description'];
		$points = $_POST['points'];
		$hu_activity = $_POST['hu_activity'];
		$strength_activity = $_POST['strength_activity'];
		
		// validate input
		$descriptionError = null;
		$pointsError = null;
		$hu_activityError = null;
		$strength_activityError = null;
		
		$valid = true;
		if (empty($description)) {
			$descriptionError = 'Please enter description';
			$valid = false;
		}
		if (empty($points)) {
			$pointsError = 'Please enter points';
			$valid = false;
		}
		if ($hu_activity != 0 && $hu_activity != 1) {
			$hu_activityError = 'Please enter 1 if HealthyU activity, 0 otherwise';
			$valid = false;
		} 
		if ($strength_activity != 0 && $strength_activity != 1) {
			$strength_activityError = 'Please enter 1 if strength activity, 0 otherwise';
			$valid = false;
		} 

		// insert record
		if ($valid) 
		{
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO healthyu_activity (description, points, hu_activity, strength_activity) values(?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($description, $points, $hu_activity, $strength_activity));
			Database::disconnect();
			header("Location: act_list.php");
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
				<h3>HealthyU: Create New Activity</h3>
			</div>
			
			<p>
				<a href="start.html" class="btn btn-primary">Back to Start</a>
			</p>
	
			<form class="form-horizontal" action="act_create.php" method="post" enctype="multipart/form-data">

				<div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
					<label class="control-label">description</label>
					<div class="controls">
						<input name="description" type="text"  placeholder="description" value="<?php echo !empty($description)?$description:'';?>">
						<?php if (!empty($descriptionError)): ?>
							<span class="help-inline"><?php echo $descriptionError;?></span>
						<?php endif; ?>
					</div>
				</div>	
				
				<div class="control-group <?php echo !empty($pointsError)?'error':'';?>">
					<label class="control-label">points</label>
					<div class="controls">
						<input name="points" type="text"  placeholder="points" value="<?php echo !empty($points)?$points:'';?>">
						<?php if (!empty($pointsError)): ?>
							<span class="help-inline"><?php echo $pointsError;?></span>
						<?php endif; ?>
					</div>
				</div>
			  
				<div class="control-group <?php echo !empty($hu_activityError)?'error':'';?>">
					<label class="control-label">hu_activity</label>
					<div class="controls">
						<input name="hu_activity" type="text" placeholder="hu_activity" value="<?php echo !empty($hu_activity)?$hu_activity:'';?>">
						<?php if (!empty($hu_activityError)): ?>
							<span class="help-inline"><?php echo $hu_activityError;?></span>
						<?php endif;?>
					</div>
				</div>
				
				<div class="control-group <?php echo !empty($strength_activityError)?'error':'';?>">
					<label class="control-label">strength_activity</label>
					<div class="controls">
						<input name="strength_activity" type="text" placeholder="strength_activity" value="<?php echo !empty($strength_activity)?$strength_activity:'';?>">
						<?php if (!empty($strength_activityError)): ?>
							<span class="help-inline"><?php echo $strength_activityError;?></span>
						<?php endif;?>
					</div>
				</div>		
			  
				<div class="form-actions">
					<button type="submit" class="btn btn-success">Create</button>
					<a class="btn" href="act_list.php">Back</a>
				</div>
				
			</form>
			
		</div> <!-- span10 offset1 -->
    </div> <!-- container -->
</body>
</html>