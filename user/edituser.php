<?php
session_start();

if ($_SESSION["loggedIn"] !== true) {
    header("location: ../login.php");
    exit;
}

include_once 'header_user.php';
include_once '../editingpage.php';
include_once '../footer.php'
    ?>