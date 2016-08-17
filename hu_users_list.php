<div style="margin-top: 5%; margin-bottom: 5%; margin-left: 3%; margin-right: 3%;">
    <div style="font-weight: bold; font-size: 2em; margin-bottom: 3%;">
        HealthyU: Users
    </div>
    <div style="font-size: 1em;">
        <a href="hu_users_create.html" class="btn btn-success">Create</a>
        <a href="hu_start.html" class="btn btn-primary">Back to Start</a>
        <table class="table table-striped table-bordered" style="margin-top: 2%">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbody">
<?php 
    include 'database.php';
    $pdo = Database::connect();
    $sql = 'SELECT * FROM healthyu_users ORDER BY username ASC';
    foreach ($pdo->query($sql) as $row) {
        echo '<tr>';
        echo '<td width="20%">'. $row['username'] . '</td>';
        echo '<td width="30%">'. $row['fullname'] . '</td>';
        echo '<td width="50%">';
        echo '<a class="btn" href="hu_users_read.html?id='.$row['id'].'">Read</a>';
        echo '&nbsp;';
        echo '<a class="btn btn-success" href="hu_users_update.html?id='.$row['id'].'">Update</a>';
        echo '&nbsp;';
        echo '<a class="btn btn-danger" href="hu_users_delete.html?id='.$row['id'].'">Delete</a>';
        echo '</td>';
        echo '</tr>';
    }
    Database::disconnect();
?>
            </tbody>
        </table>
    </div>
</div>