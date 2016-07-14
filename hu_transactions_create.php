<?php 
	require 'database.php';
	
	// if values were passed, validate and insert
	if (isset($_POST['insert'])) {
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

		$valid = true;
		if (empty($user_id) || empty($transtype_id)) {
			$valid = false;
		} 

		// insert record
		if ($valid) 
		{
			if(empty($trans_hu_activity)) $trans_hu_activity = 0;
			if(empty($trans_strength_activity)) $trans_strength_activity = 0;
			if(empty($trans_fitness_class)) $trans_fitness_class = 0;
			
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO healthyu_transactions ";
			$sql .= "(user_id, transtype_id, trans_date, trans_points, minutes, trans_exercise_points, trans_hu_activity, trans_strength_activity, trans_fitness_class) ";
			$sql .= "values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($user_id,$transtype_id,$trans_date,$trans_points,$minutes,$trans_exercise_points,$trans_hu_activity, $trans_strength_activity, $trans_fitness_class));
			Database::disconnect();
		}
	}
?>
    
			<div class="row">
				<h3>HealthyU: Create Transaction</h3>
			</div>
			
            <p><a href="hu_start.html" class="btn btn-primary">Back to Start</a></p>
        
            <div class="control-group">
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
          
            <div class="control-group">
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
            
            <div class="control-group">
                <label class="control-label">trans_date</label>
                <div class="controls">
                    <input id="trans_date" name="trans_date" type="date"  placeholder="date" value="" required>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">minutes</label>
                <div class="controls">
                    <input name="minutes" type="number"  placeholder="minutes" value="" id="minutes" onkeyup="calcExercisePoints()" min="0" required>
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