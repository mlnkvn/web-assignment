<?php
session_start();

if (isset($_POST["back"])) {
    header("location: ../user/indexuser.php");
    exit();
}
else if (isset($_POST["logout"])) {
    $_SESSION = array();
    session_destroy();
    header("location: ../index.php");
    exit();
}
else {
    header("location: ../login.php");
    exit();
}
?>