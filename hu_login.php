<?php
    session_start();
    $_SESSION['loggedin'] = true;
    header("Location: act_list.php");
?>