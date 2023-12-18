<?php 


session_start();

if ($_SESSION['admin_logged_in']){

    unset($_SESSION['admin_logged_in']);
    
}


header("Location: admin_login.php"); //redirect to login
die;

?>