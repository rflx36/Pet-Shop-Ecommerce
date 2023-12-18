<?php



include("PHP/log_connection.php");
include("PHP/log_functions.php");
session_start();

if(isset($_SESSION['main-current-page'])){
    unset($_SESSION['main-current-page']);
}

if (isset($_SESSION['selected-category'])) {
    unset($_SESSION['selected-category']);
}

if (isset($_SESSION['sort'])) {
    unset($_SESSION['sort']);
}


if (isset($_SESSION['search'])) {
    unset($_SESSION['search']);
}   

header("Location: main_products.php");
die;
?>