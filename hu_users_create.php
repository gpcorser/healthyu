<?php 
// session_start();

// if not loggedin redirect to act_list.php
// if ($_SESSION['loggedin'] == false) header("Location: act_list.php");

	require 'database.php';

	// if values were passed, validate and insert
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

		// insert record
		if ($valid) 
		{
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO healthyu_users (username, fullname, password_hash) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($username, $fullname, $password_hash));
			Database::disconnect();
			header("Location: hu_users_list.html");
		}
	}
?>

    <div class="container">
    
		<div class="span10 offset1">
			<div class="row">
				<h3>HealthyU: Create User</h3>
			</div>
			
			<p>
				<a href="hu_start.html" class="btn btn-primary">Back to Start</a>
			</p>
	
			<form class="form-horizontal" action="hu_users_create.php" method="post" enctype="multipart/form-data">

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
					<button type="submit" class="btn btn-success">Create</button>
					<a class="btn" href="hu_users_list.html">Back</a>
				</div>
				
			</form>
			
		</div> <!-- span10 offset1 -->
    </div> <!-- container -->