<?php

if (isset($_POST["submit"])) {
    $username = $_POST["user_name"];
    $email = $_POST["user_email"];
    $user_id = $_POST["user_id"];
    $password = $_POST["user_pass"];

    require_once 'db.php';
    require_once 'functionality.php';

    if (hasEmptyInputs($username, $email, $user_id, $password) !== false) {
        header("location: ../register.php?error=emptyinput");
        exit();
    }
    if (invalidUsername($user_id) !== false) {
        header("location: ../register.php?error=invaliduid");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../register.php?error=invalidemail");
        exit();
    }
    if (existingUsername($con, $user_id, $email) !== false) {
        header("location: ../register.php?error=existinguserid");
        exit();
    }
    createUser($con, $username, $email, $user_id, $password);
} 
else {
    header("location: ../register.php");
    exit();
}
?>