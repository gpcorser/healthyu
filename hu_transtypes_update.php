<?php 
	require 'database.php';
	
    $id = null;
	if (!empty($_GET['id'])) { 
        $id = $_REQUEST['id']; 
    }
	
	// if data was entered by the user
	if (isset($_POST['update'])) {
		// get values
        $id = $_POST['id'];
		$description = $_POST['description'];
		$points = $_POST['points'];
		$hu_activity = $_POST['hu_activity'];
		$strength_activity = $_POST['strength_activity'];
		$fitness_class = $_POST['fitness_class'];
				
		$valid = true;
		if (empty($description)) { $valid = false; }
		if (empty($points)) { $valid = false; }
		if ($hu_activity != 0 && $hu_activity != 1) { $valid = false; } 
		if ($strength_activity != 0 && $strength_activity != 1) { $valid = false; } 
		if ($fitness_class != 0 && $fitness_class != 1) { $valid = false; } 
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE healthyu_transtypes  set description = ?, points = ?, hu_activity = ?, strength_activity = ?, fitness_class = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($description,$points,$hu_activity,$strength_activity,$fitness_class,$id));
			Database::disconnect();
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

    		<div class="row">
		    	<h3>HealthyU: Update Transaction Type</h3>
		    </div>
            
			<p><a href="hu_start.html" class="btn btn-primary">Back to Start</a></p>
			  
            <div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
                <label class="control-label">description</label>
                <div class="controls">
                    <input id="description" type="text"  placeholder="description" value="<?php echo !empty($description)?$description:'';?>" required>
                </div>
            </div>	
            
            <div class="control-group <?php echo !empty($pointsError)?'error':'';?>">
                <label class="control-label">points</label>
                <div class="controls">
                    <input id="points" type="text"  placeholder="points" value="<?php echo !empty($points)?$points:'';?>" required>
                </div>
            </div>
          
            <div class="control-group <?php echo !empty($hu_activityError)?'error':'';?>">
                <label class="control-label">hu_activity</label>
                <div class="controls">
                    <input id="hu_activity" type="number" placeholder="hu_activity" value="<?php echo !empty($hu_activity)?$hu_activity:'';?>" min="0" max="1">
                </div>
            </div>
            
            <div class="control-group <?php echo !empty($strength_activityError)?'error':'';?>">
                <label class="control-label">strength_activity</label>
                <div class="controls">
                    <input id="strength_activity" type="number" placeholder="strength_activity" value="<?php echo !empty($strength_activity)?$strength_activity:'';?>" min="0" max="1">
                </div>
            </div>		
            <div class="control-group <?php echo !empty($fitness_classError)?'error':'';?>">
                <label class="control-label">fitness_class</label>
                <div class="controls">
                    <input id="fitness_class" type="number" placeholder="fitness_class" value="<?php echo !empty($fitness_class)?$fitness_class:'';?>" min="0" max="1">
                </div>
            </div>