<?php
function updateWithPwd($con, $userId, $userFullName, $username, $userEmail, $address, $newPwd, $userLevel)
{
    $sql = "UPDATE users SET usersName=?,usersEmail=?,usersUid=?, usersPwd=?, deliveryAddress=?, usersLevel=? WHERE usersId=?;";
    $stmt = mysqli_stmt_init($con);
    session_start();
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin/edit_user_page.php?error=stmtfailed");
        exit();
    }
    $hashed_pwd = password_hash($newPwd, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sssssss", $userFullName, $userEmail, $username, $hashed_pwd, $address, $userLevel, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if ($_SESSION['userId'] == $userId) {
        $_SESSION["userFullName"] = $userFullName;
        $_SESSION["username"] = $username;
        $_SESSION["useremail"] = $userEmail;
        $_SESSION["userAddress"] = $address;
    }
    header("location: ../admin/usersadmin.php?error=none");
    exit();
}

function updateWithoutPwd($con, $userId, $userFullName, $username, $userEmail, $address, $userLevel)
{
    $sql = "UPDATE users SET usersName=?,usersEmail=?,usersUid=?, deliveryAddress=?, usersLevel=? WHERE usersId=?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin/edit_user_page.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssssss", $userFullName, $userEmail, $username, $address, $userLevel, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    session_start();
    if ($_SESSION['userId'] == $userId) {
        $_SESSION["userFullName"] = $userFullName;
        $_SESSION["username"] = $username;
        $_SESSION["useremail"] = $userEmail;
        $_SESSION["userAddress"] = $address;
    }
    header("location: ../admin/usersadmin.php?error=none");
    exit();
}

if (isset($_POST["edit-user-submit"])) {
    session_start();
    $userId = $_POST["userId"];
    $newLevel = $_POST["level-user"];
    $userFullName = $_POST["userFullName"];
    $username = $_POST["userLogin"];
    $userEmail = $_POST["userEmail"];
    $address = $_POST["inputAddress"];
    $oldPwd = $_POST["oldPwd"];
    $newPwd = $_POST["newPwd"];
    $newPwdRepeat = $_POST["newPwdRepeat"];

    require_once 'db.php';
    require_once 'functionality.php';

    if (invalidUsername($username)) {
        header("location: ../admin/edit_user_page.php?error=invalidusername");
        exit();
    }
    if (invalidEmail($userEmail)) {
        header("location: ../admin/edit_user_page.php?error=invalidemail");
        exit();
    }
    if ($address === "There is no delivery address associated with you") {
        $address = null;
    }
    if (!empty($newPwd) and !empty($newPwdRepeat)) {
        if ($newPwd !== $newPwdRepeat) {
            header("location: ../admin/edit_user_page.php?error=passwordmismatch");
            exit();
        }
        updateWithPwd($con, $userId, $userFullName, $username, $userEmail, $address, $newPwd, $newLevel);
    } else {
        updateWithoutPwd($con, $userId, $userFullName, $username, $userEmail, $address, $newLevel);
    }
} else {
    header("location: ../admin/edit_user_page.php");
    exit();
}
?>