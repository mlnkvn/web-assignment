<?php
if (isset($_POST["submit"])) {
    $username = $_POST["user_id"];
    $password = $_POST["user_pass"];

    require_once 'db.php';
    require_once 'functionality.php';

    if (hasEmptyInputsLogin($username, $password) !== false) {
        header("location: ../login.php?error=emptyinput");
        exit();
    }
    loginUser($con, $username, $password);
}
else {
    header("location: ../login.php");
    exit();
}
?>