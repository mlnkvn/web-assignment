<?php
session_start();
if ($_GET['admId'] == $_SESSION['userId']) {
    session_start();
    require_once 'functionality.php';
    deleteUser($_GET['userId'], "../admin/usersadmin.php");
    header("location: ../admin/usersadmin.php?error=none");
    exit();
} else {
    header("location: ../admin/usersadmin.php");
    exit();
}
