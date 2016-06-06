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
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE healthyu_transactions set user_id = ?, transtype_id = ?, trans_date = ?, trans_points = ?, minutes = ?  WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($user_id,$transtype_id,$trans_date,$trans_points,$minutes, $id));
			Database::disconnect();
			header("Location: hu_transactions_list.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// do not select * because we do not want the server to SEND password
		$sql = "SELECT * FROM healthyu_transactions where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$user_id = $data['user_id'];
		$transtype_id = $data['transtype_id'];
		$trans_date = $data['trans_date'];
		$trans_points = $data['trans_points'];
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

<body onload="calcPoints();">
    <div class="container">
    
    	<div class="span10 offset1">
    		<div class="row">
		    	<h3>HealthyU: Update Transaction</h3>
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
				
				<!-- script below is used only for create, not for update -->
				<script>
					function calcDate() {
						var today = new Date();
						var dd = today.getDate();
						if (dd < 10) dd = "0" + dd;
						var mm = 1 + today.getMonth();
						if (mm < 10) mm = "0" + mm;
						var yyyy = today.getFullYear();
						document.getElementById("trans_date").value = yyyy + "-" + mm + "-" + dd;
					}
				</script>
			  
				<div class="control-group <?php echo !empty($trans_dateError)?'error':'';?>">
					<label class="control-label">trans_date</label>
					<div class="controls">
						<input id="trans_date" name="trans_date" type="date"  placeholder="date" value="<?php echo !empty($trans_date)?$trans_date:'';?>">
						<?php if (!empty($trans_dateError)): ?>
							<span class="help-inline"><?php echo $trans_dateError;?></span>
						<?php endif;?>
					</div>
				</div>
				
				<!-- this script is called two times, onload, and when minutes are typed into input field-->
				<script>
					function calcPoints() {
						document.getElementById("trans_points").value 
							= Math.floor(document.getElementById("minutes").value / 30) * 5;
					}
				</script>
				
				<div class="control-group <?php echo !empty($minutesError)?'error':'';?>">
					<label class="control-label">minutes</label>
					<div class="controls">
						<input name="minutes" type="text"  placeholder="minutes" value="<?php echo !empty($minutes)?$minutes:'';?>" id="minutes" onkeyup="calcPoints()">
						<?php if (!empty($minutesError)): ?>
							<span class="help-inline"><?php echo $minutesError;?></span>
						<?php endif;?>
					</div>
				</div>	
				
				<div class="control-group">
					<label class="control-label">trans_points</label>
					<div class="controls">
						<input type="text" name="trans_points" id="trans_points" value="0" readonly>
					</div>
				</div>

				
				<div class="form-actions">
					<button type="submit" class="btn btn-success">Update</button>
					<a class="btn" href="hu_transactions_list.php">Back</a>
				</div>
				
			</form>
			
		</div> <!-- end: span 10 offset -->
				
    </div> <!-- end: container -->
  </body>
</html>