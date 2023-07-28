<?php

function changeOrder($con, $orderId, $totalPrice, $amountInOrder)
{
    $sql = "UPDATE orders SET orderAmount = ?, orderTotal = ? WHERE orderId = ?";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../user/shopping_cartuser.php");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss", $amountInOrder, $totalPrice, $orderId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return true;
}

if ($_GET["load"] === "true") {
    $amount = $_GET['amount'];
    $total = $_GET['total'];
    require_once 'db.php';
    require_once 'functionality.php';
    session_start();
    $usId = $_SESSION['userId'];
    $curOrd = getActiveOrder($con, $usId);
    changeOrder($con, $curOrd['orderId'], $total, $amount);
}
header("location: ../user/order_submit.php");
exit();