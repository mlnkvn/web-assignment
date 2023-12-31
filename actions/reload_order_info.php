<?php

function changeItemsAmount($con, $amount, $itemId, $ordId)
{
    $itemInfo = getExistingItem($con, $ordId, $itemId, 0);
    $sql = "UPDATE `orderedItems` SET itemsAmount = ? WHERE orderId = ? AND itemId = ?";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../user/shopping_cartuser.php");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss", $amount, $ordId, $itemId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

if ($_GET["load"] === "true") {
    $id = $_GET['id'];
    $amount = $_GET['amount'];
    require_once 'db.php';
    require_once 'functionality.php';
    session_start();
    $usId = $_SESSION['userId'];
    $curOrd = getActiveOrder($con, $usId);
    changeItemsAmount($con, $amount, $id, $curOrd['orderId']);
//    echo $id;
//    exit();
}
header("location: ../user/shopping_cartuser.php");
exit();
