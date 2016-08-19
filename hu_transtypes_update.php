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

<h3>HealthyU: Update Transaction Type</h3>
<p><a href="hu_start.html" class="btn btn-primary">Back to Start</a></p>
<div class="control-group">
    <label class="control-label">description</label>
    <div class="controls">
        <input id="description" type="text"  placeholder="description" value="<?php echo !empty($description)?$description:'';?>" required>
    </div>
</div>
<div class="control-group">
    <label class="control-label">points</label>
    <div class="controls">
        <input id="points" type="text"  placeholder="points" value="<?php echo !empty($points)?$points:'';?>" required>
    </div>
</div>
<div class="control-group">
    <label class="control-label">hu_activity</label>
    <div class="controls">
        <input type="checkbox" name="hu_activity" id="hu_activity" <?php echo !empty($hu_activity)?'checked':'';?> >
    </div>
</div>
<div class="control-group">
    <label class="control-label">strength_activity</label>
    <div class="controls">
        <input type="checkbox" name="strength_activity" id="strength_activity" <?php echo !empty($strength_activity)?'checked':'';?> >
    </div>
</div>
<div class="control-group">
    <label class="control-label">fitness_class</label>
    <div class="controls">
        <input type="checkbox" name="fitness_class" id="fitness_class" <?php echo !empty($fitness_class)?'checked':'';?> >
    </div>
</div>