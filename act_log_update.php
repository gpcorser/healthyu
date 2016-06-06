<?php 
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: act_log_list.php");
	}
	
	// if data was entered by the user
	if ( !empty($_POST)) {
	
		// get values
		$user_id = $_POST['user_id'];
		$act_id = $_POST['act_id'];
		$act_date = $_POST['act_date'];
		$minutes = $_POST['minutes'];

		// validate input
		$user_idError = null;
		$act_idError = null;
		$act_dateError = null;
		$minutesError = null;
		
		$valid = true;
		if (empty($user_id)) {
			$user_idError = 'Please enter user_id';
			$valid = false;
		}
		if (empty($act_id)) {
			$act_idError = 'Please enter act_id';
			$valid = false;
		}
		
		//if($act_date != 0) $act_date = 1;
		/*
		if (empty($act_date)) {
			$act_dateError = 'Please enter act_date';
			$valid = false;
		}
		*/
		
		if ($minutes < 0) {
			$minutesError = 'Please enter minutes (>=0)';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE healthyu_activity_log  set user_id = ?, act_id = ?, act_date = ?, minutes = ?  WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($user_id,$act_id,$act_date, $minutes, $id));
			Database::disconnect();
			header("Location: act_log_list.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// do not select * because we do not want the server to SEND password
		$sql = "SELECT * FROM healthyu_activity_log where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$user_id = $data['user_id'];
		$act_id = $data['act_id'];
		$act_date = $data['act_date'];
		$minutes =  $data['minutes'];
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
		    	<h3>HealthyU: Update an Activity Log Entry</h3>
		    </div>
			<p>
				<a href="start.html" class="btn btn-primary">Back to Start</a>
			</p>
    		
	    	<form class="form-horizontal" action="act_log_update.php?id=<?php echo $id?>" method="post">
					  
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
			  
				<div class="control-group <?php echo !empty($act_idError)?'error':'';?>">
					<label class="control-label">act_id</label>
					<div class="controls">
						<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM healthyu_activity ORDER BY description ASC';
							echo "<select class='form-control' name='act_id' id='act_id'>";
							foreach ($pdo->query($sql) as $row) {
								$hu = "";
								$strength = "";
								if($row['hu_activity']==1) $hu = ", hu";
								if($row['strength_activity']==1) $strength = ", strength";
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
			  
				<div class="control-group <?php echo !empty($act_dateError)?'error':'';?>">
					<label class="control-label">act_date</label>
					<div class="controls">
						<input name="act_date" type="date"  placeholder="date" value="<?php echo !empty($act_date)?$act_date:'';?>">
						<?php if (!empty($act_dateError)): ?>
							<span class="help-inline"><?php echo $act_dateError;?></span>
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


				<div class="form-actions">
					<button type="submit" class="btn btn-success">Update</button>
					<a class="btn" href="act_log_list.php">Back</a>
				</div>
			</form>
		</div>
				
    </div> <!-- /container -->
  </body>
</html>