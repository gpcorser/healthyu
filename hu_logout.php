<?php
session_start();
$_SESSION['loggedin'] = false;
header("Location: act_list.php");
?>