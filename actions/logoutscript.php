<?php
session_start();

if (isset($_POST["back"])) {
    if ($_SESSION["level"] == 0) {
        header("location: ../user/indexuser.php");
    } else {
        header("location: ../admin/indexadmin.php");
    }
    exit();
} else if (isset($_POST["logout"])) {
    $_SESSION = array();
    session_destroy();
    header("location: ../index.php");
    exit();
} else {
    header("location: ../login.php");
    exit();
}
?>