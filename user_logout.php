<?php 


session_start();

if ($_SESSION['user_logged_in']){

    $_SESSION['user_logged_in'] = false;
    unset($_SESSION['user_id']);

    unset($_SESSION['user_cart_id']);
}


header("Location: user_login.php"); //redirect to login
die;

?>