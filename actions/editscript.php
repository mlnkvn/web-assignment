<?php
if (isset($_POST["edit-submit"])) {
    session_start();
    $prevUid = $_SESSION["username"];
    $usersLevel = $_SESSION["level"];
    $userFullName = $_POST["userFullName"];
    $username = $_POST["userLogin"];
    $userEmail = $_POST["userEmail"];
    $address = $_POST["inputAddress"];
    $oldPwd = $_POST["oldPwd"];
    $newPwd = $_POST["newPwd"];
    $newPwdRepeat = $_POST["newPwdRepeat"];

    require_once 'db.php';
    require_once 'functionality.php';


    if ((empty($oldPwd) or empty($newPwd) or empty($newPwdRepeat)) and !(empty($oldPwd) and empty($newPwd) and empty($newPwdRepeat))) {
        if ($usersLevel === 0) {
            header("location: ../user/edituser.php?error=emptyinput");
        } else {
            header("location: ../admin/settingsadmin.php?error=emptyinput");
        }
        exit();
    }
    if (invalidUsername($username)) {
        if ($usersLevel === 0) {
            header("location: ../user/edituser.php?error=invalidusername");
        } else {
            header("location: ../admin/settingsadmin.php?error=invalidusername");
        }
        exit();
    }
    if (invalidEmail($userEmail)) {
        if ($usersLevel === 0) {
            header("location: ../user/edituser.php?error=invalidemail");
        } else {
            header("location: ../admin/settingsadmin.php?error=invalidemail");
        }
        exit();
    }
    if ($address === "There is no delivery address associated with you") {
        $address = null;
    }
    $user = existingUsernameLogin($con, $prevUid);
    $userId = $user["usersId"];
    if (!empty($oldPwd) and !empty($newPwd) and !empty($newPwdRepeat)) {
        $rightPassword = $user["usersPwd"];
        $validatePwd = password_verify($oldPwd, $rightPassword);
        if (!$validatePwd) {
            if ($usersLevel === 0) {
                header("location: ../user/edituser.php?error=wrongpassword");
            } else {
                header("location: ../admin/settingsadmin.php?error=wrongpassword");
            }
            // exit();
        }
        if ($newPwd !== $newPwdRepeat) {
            if ($usersLevel === 0) {
                header("location: ../user/edituser.php?error=passwordmismatch");
            } else {
                header("location: ../admin/settingsadmin.php?error=passwordmismatch");
            }
            
            exit();
        }

        updateUserWithPwd($con, $userId, $userFullName, $username, $userEmail, $address, $newPwd, $usersLevel);
    } else {
        updateUserWithoutPwd($con, $userId, $userFullName, $username, $userEmail, $address, $usersLevel);
    }
} else {
    if ($usersLevel === 0) {
        header("location: ../user/edituser.php");
    } else {
        header("location: ../admin/settingsadmin.php");
    }
    exit();
}
?>