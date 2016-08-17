<div style="margin-top: 5%; margin-bottom: 5%; margin-left: 3%; margin-right: 3%;">
    <div style="font-weight: bold; font-size: 2em; margin-bottom: 3%;">
        HealthyU: Transaction Types
    </div>
    <div style="font-size: 1em;">
        <a href="hu_transtypes_create.html" class="btn btn-success">Create</a>
        <a href="hu_start.html" class="btn btn-primary">Back to Start</a>
        <table class="table table-striped table-bordered" style="margin-top: 2%">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Points</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
<?php 
    include 'database.php';
    $pdo = Database::connect();
    $sql = 'SELECT * FROM healthyu_transtypes ORDER BY description ASC';
    foreach ($pdo->query($sql) as $row) {
        echo '<tr>';
        echo '<td width="30%">'. $row['description'] . '</td>';
        echo '<td width="10%">'. $row['points'] . '</td>';        
        echo '<td width="20%"><div width="100%">';
        echo '<input type="checkbox"';
        if ($row['hu_activity']==1) echo ' checked ';
        echo 'disabled="disabled">HealthyU<br />';
        echo '<input type="checkbox"';
        if ($row['strength_activity']==1) echo ' checked ';
        echo 'disabled="disabled">Strength<br />';
        echo '<input type="checkbox"';
        if ($row['fitness_class']==1) echo ' checked ';
        echo 'disabled="disabled">Fitness</td>';
        echo '<td width="20%">';
        echo '<a class="btn" href="hu_transtypes_read.html?id='.$row['id'].'"">Read</a>';
        echo '<a class="btn btn-success" href="hu_transtypes_update.html?id='.$row['id'].'"">Update</a>';
        echo '<a class="btn btn-danger" href="hu_transtypes_delete.html?id='.$row['id'].'"">Delete</a>';
        echo '</td>';
        echo '</tr>';
    }
    Database::disconnect();
?>
            </tbody>
        </table>
    </div>
</div>