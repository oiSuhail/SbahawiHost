<?php
    ob_start();
    session_start();
	$pageTitle = "Support cp";

    if(isset($_SESSION['username'])) { 
        if($_SESSION['rank'] == "Member") {
            header("Location: ../Member-CP/index.php");
        }
    } else {
        header("Loaction: ../index.php");
    }

    include "../LinkFiles.php";
    ob_end_flush();
?>