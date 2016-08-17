<div style="margin-top: 5%; margin-bottom: 5%; margin-left: 3%; margin-right: 3%;">
    <div style="font-weight: bold; font-size: 2em; margin-bottom: 3%;">
        HealthyU: Transactions
    </div>
    <div style="font-weight: bold; display: inline;">
        Transactions
    </div>
    <div style="display: inline; margin-bottom: 3%;">
        include any and all events that might affect the calculation of HealthyU rewards, including all transaction types (transtypes): exercise minutes, HealthyU activities, fitness classes, etc.
    </div>
    <div style="font-size: 1em;">
        <div style="margin-top: 3%; margin-bottom: 3%;">
            <a href="hu_transactions_create.html" class="btn btn-success">Create</a>
            <a href="hu_start.html" class="btn btn-primary">Back to Start</a>
        </div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                  <th>User</th>
                  <th>Type</th>
                  <th>Date</th>
                  <th>Points</th>
                  <th>Minutes</th>
                  <th></th>
                </tr>
            </thead>
            <tbody>
<?php 
include 'database.php';
$pdo = Database::connect();
$sql = 'SELECT * FROM healthyu_transactions AS HU1 '; 
$sql .= 'INNER JOIN healthyu_users AS HU2 ';
$sql .= 'ON HU1.user_id = HU2.id ' ;
$sql .= 'INNER JOIN healthyu_transtypes AS HU3 ';
$sql .= 'ON HU1.transtype_id = HU3.id ' ;
$sql .= 'ORDER BY HU2.username ASC, HU1.trans_date DESC';
foreach ($pdo->query($sql) as $row) {
    echo '<tr>';
    echo '<td>'. $row['username'] . '</td>';
    echo '<td>'. $row['description'] . '</td>';
    echo '<td>'. $row['trans_date'] . '</td>';
    echo '<td>'. $row['trans_points'] . '</td>';
    echo '<td>'. $row['minutes'] . '</td>';
    echo '<td>';
    echo '<a class="btn" href="hu_transactions_read.html?id='.$row[0].'">Read</a>';
    echo '&nbsp;';
    echo '<a class="btn btn-success" href="hu_transactions_update.html?id='.$row[0].'">Update</a>';
    echo '</td></tr>';
}
Database::disconnect();
?>
            </tbody>
        </table>
    </div>
</div>