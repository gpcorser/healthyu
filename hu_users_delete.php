<?php 
	require 'database.php';
	
	if (isset($_POST['delete'])) {
		// keep track post values
		$id = $_POST['id'];
		
        $valid = true;
		if (empty($id)) { $valid = false; } 

		// delete data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM healthyu_users  WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            Database::disconnect();
        }
	}
?>		