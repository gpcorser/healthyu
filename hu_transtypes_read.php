<?php 
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: hu_transtypes_list.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM healthyu_transtypes where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
	}
?>

<div style="margin-top: 5%; margin-bottom: 5%; margin-left: 3%; margin-right: 3%;">
    <h3>HealthyU: Transaction Type Details</h3>        
    <p>
        <a href="hu_start.html" class="btn btn-primary">Back to Start</a>
    </p>
    <div class="form-horizontal" >
        <div class="control-group">
            <label class="control-label">description</label>
            <div class="controls">
                <label class="checkbox">
                    <?php echo $data['description'];?>
                </label>
            </div>
        </div>
    </div>
    <div class="form-horizontal" >
        <div class="control-group">
            <label class="control-label">points</label>
            <div class="controls">
                <label class="checkbox">
                    <?php echo $data['points'];?>
                </label>
            </div>
        </div>
    </div>
    <div class="form-horizontal" >
        <div class="control-group">
            <label class="control-label">hu_activity</label>
            <div class="controls">
                <label class="checkbox">
                    <?php echo $data['hu_activity'];?>
                </label>
            </div>
        </div>
    </div>
    <div class="form-horizontal" >
        <div class="control-group">
            <label class="control-label">strength_activity</label>
            <div class="controls">
                <label class="checkbox">
                    <?php echo $data['strength_activity'];?>
                </label>
            </div>
        </div>
    </div>
    <div class="form-horizontal" >
        <div class="control-group">
            <label class="control-label">fitness_class</label>
            <div class="controls">
                <label class="checkbox">
                    <?php echo $data['fitness_class'];?>
                </label>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <a class="btn" href="hu_transtypes_list.html">Back</a>
    </div>    
</div>