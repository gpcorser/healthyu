<?php 
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: hu_users_list.php");
	}
	
	// if data was entered by the user
	if ( !empty($_POST)) {
	
		// get values
		$username = $_POST['username'];
		$fullname = $_POST['fullname'];
		$password_hash = $_POST['password_hash'];
		
		// validate input
		$usernameError = null;
		$fullnameError = null;
		$password_hashError = null;
		
		$valid = true;
		if (empty($username)) {
			$usernameError = 'Please enter username';
			$valid = false;
		}
		if (empty($fullname)) {
			$fullnameError = 'Please enter full name of user';
			$valid = false;
		}
		if (empty($password_hash)) {
			$password_hashError = 'Please enter new password';
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
			header("Location: hu_users_list.html");
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

    <div class="container">
    
    	<div class="span10 offset1">
    		<div class="row">
		    	<h3>HealthyU: Update User (Password)</h3>
		    </div>
			<p>
				<a href="hu_start.html" class="btn btn-primary">Back to Start</a>
			</p>
    		
	    	<form name="frm" class="form-horizontal" action="hu_users_update.php?id=<?php echo $id?>" method="post">
					  
				<div class="control-group <?php echo !empty($usernameError)?'error':'';?>">
					<label class="control-label">username</label>
					<div class="controls">
						<input name="username" type="text"  placeholder="username" value="<?php echo !empty($username)?$username:'';?>" required>
					</div>
				</div>
				
				<div class="control-group <?php echo !empty($fullnameError)?'error':'';?>">
					<label class="control-label">fullname</label>
					<div class="controls">
						<input name="fullname" type="text"  placeholder="fullname" value="<?php echo !empty($fullname)?$fullname:'';?>" required>
					</div>
				</div>
			  
				<div class="control-group <?php echo !empty($password_hashError)?'error':'';?>">
					<label class="control-label">password_hash</label>
					<div class="controls">
						<input name="password_hash" type="text" placeholder="password_hash" value="<?php echo !empty($password_hash)?$password_hash:'';?>" required>
					</div>
				</div>
			  		
				<div class="form-actions">
					<button type="submit" class="btn btn-success">Update</button>
					<a class="btn" href="hu_users_list.html">Back</a>
				</div>
			</form>
		</div>
				
    </div> <!-- /container -->