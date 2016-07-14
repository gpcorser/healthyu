<?php 
	require 'database.php';

	// if values were passed, validate and insert
	if (isset($_POST['insert'])) {
		// get values
		$description = $_POST['description'];
		$points = $_POST['points'];
		$hu_activity = $_POST['hu_activity'];
		$strength_activity = $_POST['strength_activity'];
		$fitness_class = $_POST['fitness_class'];
		echo $_POST;
		$valid = true;
		if (empty($description)) { $valid = false; } 
		if ($hu_activity != 0 && $hu_activity != 1) { $valid = false; } 
		if ($strength_activity != 0 && $strength_activity != 1) { $valid = false; } 
		if ($fitness_class != 0 && $fitness_class != 1) { $valid = false; } 

		// insert record
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO healthyu_transtypes (description, points, hu_activity, strength_activity, fitness_class) values(?, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($description, $points, $hu_activity, $strength_activity, $fitness_class));
			Database::disconnect();
		}
	}
?>