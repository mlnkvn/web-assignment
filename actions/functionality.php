<?php

function hasEmptyInputs($username, $email, $user_id, $password)
{
    $res;
    if (empty($username) or empty($email) or empty($user_id) or empty($password)) {
        $res = true;
    } else {
        $res = false;
    }
    return $res;
}

function hasEmptyInputsLogin($username, $password)
{
    $res;
    if (empty($username) or empty($password)) {
        $res = true;
    } else {
        $res = false;
    }
    return $res;
}

function invalidUsername($user_id)
{
    $res;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $user_id)) {
        $res = true;
    } else {
        $res = false;
    }
    return $res;
}

function invalidEmail($email)
{
    $res;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $res = true;
    } else {
        $res = false;
    }
    return $res;
}

function existingUsername($con, $user_id, $email)
{
    $sql = "SELECT * FROM `users` WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $user_id, $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}

function createUser($con, $username, $email, $user_id, $password)
{
    $sql = "INSERT INTO `users`(usersName, usersEmail, usersUid, usersPwd, usersLevel) VALUES (?, ?, ?, ?, 0);";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }
    $hashed_pwd = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $user_id, $hashed_pwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../register.php?error=none");
    exit();
}

function existingUsernameLogin($con, $user_id)
{
    $sql = "SELECT * FROM `users` WHERE usersUid = ?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../login.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $user_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        mysqli_stmt_close($stmt);
        return $row;
    } else {
        mysqli_stmt_close($stmt);
        $result = false;
        return $result;
    }
}

function loginUser($con, $username, $password)
{
    $getUser = existingUsernameLogin($con, $username);
    if ($getUser === false) {
        header("location: ../login.php?error=unknownusername");
        exit();
    }
    $rightPassword = $getUser["usersPwd"];
    $validatePwd = password_verify($password, $rightPassword);

    if ($validatePwd === false) {
        header("location: ../login.php?error=wrongpassword");
        exit();
    } else if ($validatePwd === true) {
        session_start();
        $_SESSION["loggedIn"] = true;
        $_SESSION["userFullName"] = $getUser["usersName"];
        $_SESSION["userId"] = $getUser["usersId"];
        $_SESSION["username"] = $getUser["usersUid"];
        $_SESSION["useremail"] = $getUser["usersEmail"];
        $_SESSION["userAddress"] = $getUser["deliveryAddress"];
        $_SESSION["level"] = $getUser["usersLevel"];

        if ($_SESSION["level"] == 0) {
            header("location: ../user/indexuser.php");
        } else {
            header("location: ../admin/indexadmin.php");
        }
        exit();
    }
}

function updateUserWithPwd($con, $userId, $userFullName, $username, $userEmail, $address, $newPwd, $userLevel) {
    $sql = "UPDATE users SET usersName=?,usersEmail=?,usersUid=?, usersPwd=?, deliveryAddress=? WHERE usersId=?;";
    $stmt = mysqli_stmt_init($con);
    session_start();
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        if ($userLevel == 0) {
            header("location: ../user/edituser.php?error=stmtfailed");
        } else {
            header("location: ../admin/settingsadmin.php?error=stmtfailed");
        }
        exit();
    }
    $hashed_pwd = password_hash($newPwd, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssssss", $userFullName, $userEmail, $username, $hashed_pwd, $address, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $_SESSION["userFullName"] = $userFullName;
    $_SESSION["username"] = $username;
    $_SESSION["useremail"] = $userEmail;
    $_SESSION["userAddress"] = $address;
    if ($userLevel == 0) {
        header("location: ../user/edituser.php?error=none");
    } else {
        header("location: ../admin/settingsadmin.php?error=none");
    }
    exit();
}

function updateUserWithoutPwd($con, $userId, $userFullName, $username, $userEmail, $address, $userLevel) {
    $sql = "UPDATE users SET usersName=?,usersEmail=?,usersUid=?, deliveryAddress=? WHERE usersId=?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        if ($userLevel == 0) {
            header("location: ../user/edituser.php?error=stmtfailed");
        } else {
            header("location: ../admin/settingsadmin.php?error=stmtfailed");
        }
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssss", $userFullName, $userEmail, $username, $address, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    session_start();
    $_SESSION['userFullName'] = $userFullName;
    $_SESSION['username'] = $username;
    $_SESSION['useremail'] = $userEmail;
    $_SESSION['userAddress'] = $address;
    if ($userLevel == 0) {
        header("location: ../user/edituser.php?error=none");
    } else {
        header("location: ../admin/settingsadmin.php?error=none");
    }
    exit();
}

//function getItemsWith($con, $cat, $pageBack) {
//    $sql = "SELECT * FROM `items` WHERE 1;";
//    if ($cat !== "all") {
//        $sql = "SELECT * FROM `items` WHERE itemCategory=?;";
//    }
//    $stmt = mysqli_stmt_init($con);
//    if (!mysqli_stmt_prepare($stmt, $sql)) {
//        header($pageBack);
//        exit();
//    }
//    mysqli_stmt_bind_param($stmt, "s", $cat);
//    mysqli_stmt_execute($stmt);
//    $result = mysqli_stmt_get_result($stmt);
//    while($row = mysql_fetch_assoc($result)){
////        foreach($row as $key => $val){
////            echo $key . ": " . $val . "<BR />";
////        }
//    }
//    header($pageBack);
//    exit();
//}
?>