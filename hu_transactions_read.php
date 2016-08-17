<?php 
	require 'database.php';
    
    $id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
    if ( null==$id ) {
		header("Location: hu_transactions_list.html");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM healthyu_transactions where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
	}
?>

<div style="margin-top: 5%; margin-bottom: 5%; margin-left: 3%; margin-right: 3%;">
    <h3>HealthyU: Read Transaction</h3>
    <p>
        <a href="hu_start.html" class="btn btn-primary">Back to Start</a>
    </p>
    <div class="form-horizontal" >
        <div class="control-group">
            <label class="control-label">user</label>
            <div class="controls">
                <label class="checkbox">
                    <?php 
                        $pdo = Database::connect();
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = "SELECT username FROM healthyu_users where id = ?";
                        $q = $pdo->prepare($sql);
                        $q->execute(array($data['user_id']));
                        $name = $q->fetch(PDO::FETCH_ASSOC);
                        Database::disconnect();
                        echo $name['username'];
                    ?>
                </label>
            </div>
        </div>
    </div>
    <div class="form-horizontal" >
        <div class="control-group">
            <label class="control-label">transtype_id</label>
            <div class="controls">
                <label class="checkbox">
                    <?php echo $data['transtype_id']; ?>
                </label>
            </div>
        </div>
    </div>
    <div class="form-horizontal" >
        <div class="control-group">
            <label class="control-label">trans_date</label>
            <div class="controls">
                <label class="checkbox">
                    <?php echo $data['trans_date']; ?>
                </label>
            </div>
        </div>
    </div>
    <div class="form-horizontal" >
        <div class="control-group">
            <label class="control-label">minutes</label>
            <div class="controls">
                <label class="checkbox">
                    <?php echo $data['minutes']; ?>
                </label>
            </div>
        </div>
    </div>
    <div class="form-horizontal" >
        <div class="control-group">
            <label class="control-label">trans_exercise_points</label>
            <div class="controls">
                <label class="checkbox">
                    <?php echo $data['trans_exercise_points']; ?>
                </label>
            </div>
        </div>
    </div>
    <div class="form-horizontal" >
        <div class="control-group">
            <label class="control-label">trans_points</label>
            <div class="controls">
                <label class="checkbox">
                    <?php echo $data['trans_points']; ?>
                </label>
            </div>
        </div>
    </div>
    <div class="form-horizontal" >
        <div class="control-group">
            <label class="control-label">trans_hu_activity</label>
            <div class="controls">
                <label class="checkbox">
                    <?php echo $data['trans_hu_activity']; ?>
                </label>
            </div>
        </div>
    </div>
    <div class="form-horizontal" >
        <div class="control-group">
            <label class="control-label">trans_strength_activity</label>
            <div class="controls">
                <label class="checkbox">
                    <?php echo $data['trans_strength_activity']; ?>
                </label>
            </div>
        </div>
    </div>
    <div class="form-horizontal" >
        <div class="control-group">
            <label class="control-label">trans_fitness_class</label>
            <div class="controls">
                <label class="checkbox">
                    <?php echo $data['trans_fitness_class']; ?>
                </label>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <a class="btn" href="hu_transactions_list.html">Back</a>
    </div>    
</div>