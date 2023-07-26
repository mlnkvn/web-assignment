<?php
session_start();

if ($_SESSION["loggedIn"] !== true) {
    header("location: login.php");
    exit;
}
if ($_SESSION["level"] !== 1) {
    header("location: login.php");
    exit;
}
include_once 'header_admin.php';
include_once 'homepage_body_admin.php';
    ?>
</body>

</html>