<?php 
	require 'database.php';

	// if values were passed, validate and insert
	if (isset($_POST['insert'])) {			
		// get values
		$username = $_POST['username'];
		$fullname = $_POST['fullname'];
		$password_hash = $_POST['password_hash'];
        
		$valid = true;
		if (empty($username) || empty($fullname) || empty($password_hash)) {
			$valid = false;
		} 

		// insert record
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO healthyu_users (username, fullname, password_hash) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($username, $fullname, $password_hash));
			Database::disconnect();
		}
	}
?>