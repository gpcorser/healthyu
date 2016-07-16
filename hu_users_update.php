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
		$username = $_POST['username'];
		$fullname = $_POST['fullname'];
		$password_hash = $_POST['password_hash'];
		
		$valid = true;
		if (empty($username) || empty($fullname) || empty($password_hash)) {
			$valid = false;
		} 
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE healthyu_users  set username = ?, fullname = ?, password_hash = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$password_hash = MD5($password_hash);
			$q->execute(array($username,$fullname,$password_hash,$id));
			Database::disconnect();
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// do not select * because we do not want the server to SEND password
		$sql = "SELECT id,username,fullname FROM healthyu_users where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$username = $data['username'];
		$fullname = $data['fullname'];
		$password_hash = $data['password_hash'];
		Database::disconnect();
	}
?>

    		<div class="row">
		    	<h3>HealthyU: Update User (Password)</h3>
		    </div>
            
			<p><a href="hu_start.html" class="btn btn-primary">Back to Start</a></p>
            
            <div class="control-group">
                <label class="control-label">username</label>
                <div class="controls">
                    <input id="username" type="text"  placeholder="username" value="<?php echo !empty($username)?$username:'';?>" required>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">fullname</label>
                <div class="controls">
                    <input id="fullname" type="text"  placeholder="fullname" value="<?php echo !empty($fullname)?$fullname:'';?>" required>
                </div>
            </div>
          
            <div class="control-group">
                <label class="control-label">password_hash</label>
                <div class="controls">
                    <input id="password_hash" type="password" placeholder="password_hash" value="<?php echo !empty($password_hash)?$password_hash:'';?>" required>
                </div>
            </div>