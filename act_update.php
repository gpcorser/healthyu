<?php 
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: hu_transtypes_list.php");
	}
	
	// if data was entered by the user
	if ( !empty($_POST)) {
	
		// get values
		$description = $_POST['description'];
		$points = $_POST['points'];
		$hu_activity = $_POST['hu_activity'];
		$strength_activity = $_POST['strength_activity'];
		$fitness_class = $_POST['fitness_class'];
		
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
		if ($fitness_class != 0 && $fitness_class != 1) {
			$fitness_classError = 'Please enter 1 if fitness class, 0 otherwise';
			$valid = false;
		} 
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE healthyu_transtypes  set description = ?, points = ?, hu_activity = ?, strength_activity = ?, fitness_class = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($description,$points,$hu_activity,$strength_activity,$fitness_class,$id));
			Database::disconnect();
			header("Location: hu_transtypes_list.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM healthyu_transtypes where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$description = $data['description'];
		$points = $data['points'];
		$hu_activity = $data['hu_activity'];
		$strength_activity = $data['strength_activity'];
		$fitness_class = $data['fitness_class'];
		Database::disconnect();
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
		    	<h3>HealthyU: Update Activity</h3>
		    </div>
			<p>
				<a href="hu_start.html" class="btn btn-primary">Back to Start</a>
			</p>
    		
	    	<form class="form-horizontal" action="hu_transtypes_create.php?id=<?php echo $id?>" method="post">
					  
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
					<button type="submit" class="btn btn-success">Update</button>
					<a class="btn" href="hu_transtypes_list.php">Back</a>
				</div>
			</form>
		</div>
				
    </div> <!-- /container -->
  </body>
</html>