<?php
session_start();
if ($_GET['admId'] == $_SESSION['userId']) {
    session_start();
    require_once 'db.php';
    $sql = "DELETE FROM `users` WHERE usersId=?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin/usersadmin.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $_GET['userId']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../admin/usersadmin.php?error=none");
    exit();
} else {
    header("location: ../admin/usersadmin.php");
    exit();
}
