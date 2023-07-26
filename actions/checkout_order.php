<?php

function processOrder($con, $orderId, $date, $address)
{
    $sql = "UPDATE `orders` SET orderStatus=1, orderDate=?,orderDestination=? WHERE orderId= ?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../user/order_submit.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss", $date, $address, $orderId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../user/ordersuser.php?error=none");
    exit();
}

if (isset($_POST["checkout-submit"])) {
    $orderId = $_POST["orderId"];
    $date = $_POST["date"];
    $fullname = $_POST["firstname"];
    $email = $_POST["email"];
    $address = $_POST["address"];

    require_once 'db.php';
    require_once 'functionality.php';

    processOrder($con, $orderId, $date, $address);
} else {
    header("location: ../user/order_submit.php");
    exit();
}
?>