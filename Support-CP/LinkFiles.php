<?php 
    include "db-connect.php";

    // Varibles to get the file 
    $tmp = "includes/Template/";
    $func = "includes/functions/";


    // the included Files
    include $func . "functions.php";
    if(!isset($noNavbar)) { include $tmp . "navbar.php"; }
    include $tmp . "header.php";
?>