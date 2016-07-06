<?php 
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: hu_transtypes_list.html");
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
			header("Location: hu_transtypes_list.html");
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

    <div class="container">
    
    	<div class="span10 offset1">
    		<div class="row">
		    	<h3>HealthyU: Update Transaction Type</h3>
		    </div>
			<p>
				<a href="hu_start.html" class="btn btn-primary">Back to Start</a>
			</p>
    		
	    	<form class="form-horizontal" action="hu_transtypes_update.php?id=<?php echo $id?>" method="post">
					  
				<div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
					<label class="control-label">description</label>
					<div class="controls">
						<input name="description" type="text"  placeholder="description" value="<?php echo !empty($description)?$description:'';?>" required>
					</div>
				</div>	
				
				<div class="control-group <?php echo !empty($pointsError)?'error':'';?>">
					<label class="control-label">points</label>
					<div class="controls">
						<input name="points" type="text"  placeholder="points" value="<?php echo !empty($points)?$points:'';?>" required>
					</div>
				</div>
			  
				<div class="control-group <?php echo !empty($hu_activityError)?'error':'';?>">
					<label class="control-label">hu_activity</label>
					<div class="controls">
						<input name="hu_activity" type="number" placeholder="hu_activity" value="<?php echo !empty($hu_activity)?$hu_activity:'';?>" min="0" max="1">
					</div>
				</div>
				
				<div class="control-group <?php echo !empty($strength_activityError)?'error':'';?>">
					<label class="control-label">strength_activity</label>
					<div class="controls">
						<input name="strength_activity" type="number" placeholder="strength_activity" value="<?php echo !empty($strength_activity)?$strength_activity:'';?>" min="0" max="1">
					</div>
				</div>		
				<div class="control-group <?php echo !empty($fitness_classError)?'error':'';?>">
					<label class="control-label">fitness_class</label>
					<div class="controls">
						<input name="fitness_class" type="number" placeholder="fitness_class" value="<?php echo !empty($fitness_class)?$fitness_class:'';?>" min="0" max="1">
					</div>
				</div>		
				
				<div class="form-actions">
					<button type="submit" class="btn btn-success">Update</button>
					<a class="btn" href="hu_transtypes_list.html">Back</a>
				</div>
			</form>
		</div>
				
    </div> <!-- /container -->